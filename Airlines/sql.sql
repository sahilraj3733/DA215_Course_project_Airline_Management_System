CREATE TABLE adds (
  Aid INT NOT NULL,
  Fno INT NOT NULL,
  PRIMARY KEY (Aid, Fno)
);

CREATE TABLE admin (
  Aid INT NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  Name VARCHAR(100) NOT NULL,
  Password VARCHAR(100) NOT NULL,
  Gender VARCHAR(50) NOT NULL,
  PRIMARY KEY (Aid)
);

CREATE TABLE flight (
  Fname VARCHAR(50) NOT NULL,
  Fno INT NOT NULL,
  source VARCHAR(100) NOT NULL,
  destination VARCHAR(100) NOT NULL,
  price INT NOT NULL,
  Distance INT NOT NULL,
  sdate DATE NOT NULL,
  edate DATE NOT NULL,
  seatava INT NOT NULL,
  stime TIME NOT NULL,
  etime TIME NOT NULL,
  total_seats INT NOT NULL,
  PRIMARY KEY (Fno)
);

CREATE TABLE passengers (
  passenger_id INT NOT NULL,
  pnr VARCHAR(15) NOT NULL,
  name VARCHAR(20) DEFAULT NULL,
  age INT DEFAULT NULL,
  gender VARCHAR(8) DEFAULT NULL,
  seatno INT NOT NULL,
  PRIMARY KEY (passenger_id),
  UNIQUE (pnr)
);

CREATE TABLE ticket_details (
  pnr VARCHAR(15) NOT NULL,
  date_of_reservation DATE DEFAULT NULL,
  flight_no INT DEFAULT NULL,
  journey_date DATE DEFAULT NULL,
  booking_status VARCHAR(20) DEFAULT NULL,
  no_of_passengers INT DEFAULT NULL,
  payment_id VARCHAR(20) DEFAULT NULL,
  customer_id VARCHAR(20) DEFAULT NULL,
  PRIMARY KEY (pnr),
  FOREIGN KEY (flight_no) REFERENCES flight(Fno)
);

CREATE TABLE users (
  UID VARCHAR(25) NOT NULL,
  Name VARCHAR(50) NOT NULL,
  email VARCHAR(50) NOT NULL,
  password VARCHAR(50) NOT NULL,
  Gender VARCHAR(10) NOT NULL,
  Age INT NOT NULL,
  
  PRIMARY KEY (UID),
  UNIQUE (email)
);

CREATE INDEX idx_fno ON adds(Fno);

ALTER TABLE adds
  ADD CONSTRAINT adds_ibfk_1 FOREIGN KEY (Aid) REFERENCES admin (Aid),
  ADD CONSTRAINT adds_ibfk_2 FOREIGN KEY (Fno) REFERENCES flight (Fno);

COMMIT;
