<?
define('MPDF_PATH', 'mPDF/');

include(MPDF_PATH.'mpdf.php');

$mpdf=new mPDF();

// Set a simple Footer including the page number
$mpdf->setFooter('Bacana{PAGENO}');


// You could also do this using
// $mpdf->AddPage('','','','','on');

$mpdf->WriteHTML('Section 2 - No Footer');


$mpdf->WriteHTML('Section 3 - Starting with page a');

$mpdf->Output();
?>