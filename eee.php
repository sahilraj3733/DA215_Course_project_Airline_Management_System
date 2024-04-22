<!-- <?php
    // Your PHP code here
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Container Inside PHP</title>
    <style>
        /* CSS styling */
        .container {
            width: 80%;
            margin: 0 auto;
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <?php
        // PHP code to create a container
        echo '<div class="container">';
        
        // Inside the container, you can include any HTML content
        echo '<h1>Hello, Container!</h1>';
        echo '<p>This is a container created inside PHP.</p>';
        
        // Close the container
        echo '</div>';
    ?>
</body>
</html> -->
<?php
// Include the TCPDF library
require_once('tcpdf/tcpdf.php');

// Create a new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Ticket');
$pdf->SetSubject('Your Ticket Subject');
$pdf->SetKeywords('Ticket, PDF, Example');

// Add a page
$pdf->AddPage();

// Set some content to display in the PDF (you can customize this as per your requirement)
$html = '<h1>Your Ticket Details</h1>';
$html .= '<p>This is your ticket content. Customize it as per your requirement.</p>';

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('ticket.pdf', 'D'); // 'D' means the PDF will be downloaded by the user

// Exit the script
exit;
?>
