<?php
require('../connection.php');

require_once('../vendor/tecnickcom/tcpdf/tcpdf.php');

$candidate_id = $_SESSION['candidate_id'];
$position = $_GET['position'];

// Fetch candidate and evaluation details
$query = "SELECT c.name, r.position, cr.score, r.question 
          FROM candidate_responses cr
          JOIN requirements r ON cr.requirement_id = r.id
          JOIN candidates c ON cr.candidate_id = c.id
          WHERE cr.candidate_id = '$candidate_id' AND r.position = '$position'";
$result = mysqli_query($conn, $query);

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Admin');
$pdf->SetTitle('Candidate Evaluation Report');
$pdf->SetSubject('Evaluation Report');

// Add a page
$pdf->AddPage();

// Create the HTML content for the PDF
$html = '<h2>Candidate Evaluation Report</h2>';
$html .= '<table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th>Candidate Name</th>
                    <th>Position</th>
                    <th>Question</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>';

while ($row = mysqli_fetch_assoc($result)) {
    $html .= "<tr>
                <td>{$row['name']}</td>
                <td>{$row['position']}</td>
                <td>{$row['question']}</td>
                <td>{$row['score']}</td>
              </tr>";
}

$html .= '</tbody></table>';

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('Candidate_Evaluation_Report.pdf', 'I'); // I for inline display, D for download
