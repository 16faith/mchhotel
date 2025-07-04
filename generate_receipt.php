<?php
require_once 'pdfgenerator/fpdf.php';
require_once 'admin/inc/db_config.php';

function getBookingDetails($bookingId, $con) {
    $query = "SELECT bo.*, r.name AS room_name, r.price, u.name AS user_name, u.phonenum, u.address
              FROM booking_order bo
              JOIN rooms r ON bo.room_id = r.id
              JOIN user_cred u ON bo.user_id = u.id
              WHERE bo.booking_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('i', $bookingId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

if (isset($_GET['booking_id'])) {
    $bookingId = $_GET['booking_id'];
    $bookingDetails = getBookingDetails($bookingId, $con);

    if (!$bookingDetails) {
        echo "Booking not found.";
        exit;
    }


    $pdf = new FPDF();
    $pdf->AddPage();

    // Title
    $pdf->SetFont('Arial','B',18);
    $pdf->SetTextColor(40,40,120);
    $pdf->Cell(0,20,'Booking Receipt',0,1,'C');
    $pdf->SetTextColor(0,0,0);

    // Line
    $pdf->SetDrawColor(100,100,100);
    $pdf->Line(10,35,200,35);

    $pdf->Ln(10);

    // Details box
    $pdf->SetFont('Arial','',12);
    $pdf->SetFillColor(245,245,245);
    $pdf->Cell(60,10,'Booking ID:',0,0,'L',true);
    $pdf->Cell(0,10,$bookingDetails['booking_id'],0,1,'L',true);

    $pdf->Cell(60,10,'Room:',0,0,'L',true);
    $pdf->Cell(0,10,$bookingDetails['room_name'],0,1,'L',true);

    $pdf->Cell(60,10,'Price Per Night:',0,0,'L',true);
    $pdf->Cell(0,10,'$'.number_format($bookingDetails['price'],2),0,1,'L',true);

    $pdf->Cell(60,10,'Name:',0,0,'L',true);
    $pdf->Cell(0,10,$bookingDetails['user_name'],0,1,'L',true);

    $pdf->Cell(60,10,'Phone Number:',0,0,'L',true);
    $pdf->Cell(0,10,$bookingDetails['phonenum'],0,1,'L',true);

    $pdf->Cell(60,10,'Address:',0,0,'L',true);
    $pdf->Cell(0,10,$bookingDetails['address'],0,1,'L',true);

    $pdf->Cell(60,10,'Check-in Date:',0,0,'L',true);
    $pdf->Cell(0,10,$bookingDetails['check_in'],0,1,'L',true);

    $pdf->Cell(60,10,'Check-out Date:',0,0,'L',true);
    $pdf->Cell(0,10,$bookingDetails['check_out'],0,1,'L',true);

    $pdf->SetFont('Arial','B',14);
    $pdf->SetTextColor(0,100,0);
    $pdf->Cell(60,12,'Total Amount:',0,0,'L',true);
    $pdf->Cell(0,12,'$'.number_format($bookingDetails['trans_amount'],2),0,1,'L',true);

    $pdf->Output('D', 'booking_receipt_' . $bookingDetails['booking_id'] . '.pdf');
    exit;
} else {
    echo "No booking ID provided.";
}
?>