import express from "express";
import bodyParser from "body-parser";
import pg from "pg";
import ejs from "ejs";
import session from "express-session";
import Stripe from "stripe";

const app = express();
const port = 3000;

const db = new pg.Client({
  user: "postgres",
  host: "localhost",
  database: "flight",
  password: "#Sahil",
  port: 5432,
});
db.connect();

app.use(bodyParser.urlencoded({ extended: true }));
app.use(express.static("public"));
app.set("view engine", "ejs");

app.use(session({
  secret: "your-secret-key",
  resave: false,
  saveUninitialized: true
}));

// Route for home (login page)
app.get("/", (req, res) => {
  res.render("login");
});

// Route for register (GET request to render the register form)
app.get("/register", (req, res) => {
  res.render("register");
});

// Route for register (POST request to handle form submission)
app.post("/register", async (req, res) => {
  const email = req.body.email;
  const userss = req.body.user;
  const password = req.body.password;
  const name = req.body.name;
  const age = req.body.age;
  const gender = req.body.gender;

  try {
    const checkResult = await db.query("SELECT * FROM users WHERE email = $1", [email]);

    if (checkResult.rows.length > 0) {
      res.send("Email already exists. Try logging in.");
    } else {
      const result = await db.query(
        "INSERT INTO users (email, uid, password, name, age, gender) VALUES ($1, $2, $3, $4, $5, $6)",
        [email, userss, password, name, age, gender]
      );
      console.log(result);
      res.render("login.ejs");
    }
  } catch (err) {
    console.log(err);
  }
});

// Route for login
app.post("/login", async (req, res) => {
  const email = req.body.email;
  const password = req.body.password;

  try {
    const result = await db.query("SELECT * FROM users WHERE email = $1", [email]);
    console.log("Query result:", result.rows);

    if (result.rows.length > 0) {
      const user = result.rows[0];
      const storedPassword = user.password;

      if (password === storedPassword) {
        req.session.userp = user.uid; // Store user ID in session
        if(email=="admin@gmail.com"){
          res.render("admin_home.ejs");
        }
        else{
          res.render("home.ejs");
        }
        
      } else {
        res.send("Incorrect Password");
      }
    } else {
      res.send("User not found");
    }
  } catch (err) {
    console.log("Error querying the database:", err);
    res.send("An error occurred. Please try again.");
  }
});

app.post('/search', async (req, res) => {
  const { origin, destination, date, pass } = req.body;

  try {
    // Query the database for available flights based on the search criteria
    const flights = await db.query(
      `SELECT * FROM flight WHERE source = $1 AND destination = $2 AND sdate = $3`,
      [origin, destination, date]
    );

    if (flights.rows.length > 0) {
      // Render a page to display the available flights
      res.render('search_results', { flights: flights.rows, date, pass });
    } else {
      // No flights found
      res.send('No flights available for the selected criteria.');
    }
  } catch (error) {
    console.error('Error searching for flights:', error);
    res.status(500).send('An error occurred while searching for flights. Please try again.');
  }
});



// Route to render the add passengers details form
app.post("/add_passengers", (req, res) => {
  req.session.no_of_pass = req.body.no_of_pass; // Assuming the number of passengers is sent in the request
  req.session.flight_no = req.body.select_flight;
  req.session.journey_date = req.body.journey_date;

  res.render("book_ticket", { no_of_pass: req.session.no_of_pass });
});

// Route to handle ticket details submission
app.post("/ticket_details", async (req, res) => {
  const pnr = Math.floor(Math.random() * 9000000) + 1000000;
  const date_of_res = new Date().toISOString().split('T')[0];
  const flight_no = req.session.flight_no;
  const journey_date = req.session.journey_date;
  const no_of_pass = req.session.no_of_pass;
  const customer_id = req.session.userp;
  const payment_id = Math.floor(Math.random() * 900000000) + 100000000;

  try {
    // Check if flight has enough available seats
    const flightResult = await db.query("SELECT seatava FROM flight WHERE Fno = $1", [flight_no]);
    const seatava = flightResult.rows[0].seatava;

    let booking_status = no_of_pass <= seatava ? "CONFIRMED" : "PENDING";

    // Get ticket price and calculate FF mileage
    const priceResult = await db.query("SELECT price FROM flight WHERE Fno = $1 AND sdate = $2", [flight_no, journey_date]);
    const ticket_price = priceResult.rows[0].price;
    const ff_mileage = ticket_price / 10;

    // Insert into Ticket_Details table
    await db.query(
      "INSERT INTO Ticket_Details (pnr, date_of_reservation, flight_no, journey_date, booking_status, no_of_passengers, payment_id, customer_id) VALUES ($1, $2, $3, $4, $5, $6, $7, $8)",
      [pnr, date_of_res, flight_no, journey_date, booking_status, no_of_pass, payment_id, customer_id]
    );

    for (let i = 0; i < no_of_pass; i++) {
      const pass_name = req.body.pass_name[i];
      const pass_age = req.body.pass_age[i];
      const pass_gender = req.body.pass_gender[i];
      const seat_number = seatava - i;

      // Generate unique pnr for each passenger
      const pass_pnr = `${pnr}-${i + 1}`;

      await db.query(
        "INSERT INTO Passengers (passenger_id, pnr, name, age, gender, seatno) VALUES ($1, $2, $3, $4, $5, $6)",
        [i + 1, pass_pnr, pass_name, pass_age, pass_gender, seat_number]
      );
    }

    res.redirect("/payment");
  } catch (err) {
    console.log("Error handling ticket details submission:", err);
    res.send("An error occurred. Please try again.");
  }
});

// Route for payment page

// Route to render the payment page
app.get("/payment", async (req, res) => {
  try {
    const flight_no = req.session.flight_no;
    const journey_date = req.session.journey_date;

    const priceResult = await db.query("SELECT price FROM flight WHERE Fno = $1 AND Sdate = $2", [flight_no, journey_date]);
    const price = priceResult.rows[0].price;

    res.render("payment", {
      session: req.session,
      price: price
    });
  } catch (err) {
    console.log("Error fetching price:", err);
    res.send("An error occurred. Please try again.");
  }
});

// Route to process the payment
app.post("/process_payment", async (req, res) => {
  const payment_mode = req.body.payment_mode;
  const amount = req.session.total_amount * 100; // Amount in cents

  try {
    const paymentIntent = await stripe.paymentIntents.create({
      amount: amount,
      currency: "inr",
      payment_method_types: ["card"], // Change this based on available payment methods
      metadata: {
        payment_id: req.session.payment_id,
        pnr: req.session.pnr
      }
    });

    res.render("payment_confirmation", {
      clientSecret: paymentIntent.client_secret,
      paymentId: req.session.payment_id,
      amount: req.session.total_amount
    });
  } catch (err) {
    console.log("Error creating payment intent:", err);
    res.send("An error occurred. Please try again.");
  }
});
// Route to display payment success message
app.get("/payment_success", (req, res) => {
  res.send("Payment processed successfully. Thank you for your purchase!");
});

app.get('/add_flight', (req, res) => {
  res.render('add_flight');
});

// Route to handle flight addition
app.post('/add_flight', async (req, res) => {
  const { num, name, from, to, distance, seat, sdate, adate, stime, atime, price } = req.body;

  console.log('Received flight data:', req.body);
  
  try {
    const result = await db.query("SELECT * FROM flight WHERE Fno = $1 AND sdate = $2", [num, sdate]);
    if (result.rows.length > 0) {
      return res.send("Flight Number already exists.");
    } else {
      await db.query(
        `INSERT INTO flight (Fname, Fno, "source", "destination", price, Distance, sdate, edate, total_seats, stime, etime, seatava) 
         VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12)`,
        [name, num, from, to, price, distance, sdate, adate, seat, stime, atime, seat]
      );

      console.log('Flight added successfully');
      res.redirect('/admin_home.ejs'); // Redirect to admin home page
    }
  } catch (error) {
    console.error('Error adding flight:', error);
    res.status(500).send("Error adding flight: " + error.message);
  }
});


app.listen(port, () => {
  console.log("server Running " );
});

