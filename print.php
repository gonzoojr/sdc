<?
if(isset($_GET['id']) && isset($_GET['numProp'])){
	$id = $_GET['id'];
	$numProp = $_GET['numProp'];
//CLASSE DE IMPRESSAO PDF
define('MPDF_PATH', 'mPDF/');
include(MPDF_PATH.'mpdf.php');
// Define a Landscape page size/format by name
$mpdf=new mPDF('utf-8', 'A4-L', 0,'', 5, 5, 5, 5, 9, 9);
$mpdf->setFooter('Rua Santo Alberto, 381 - CEP: 04676-041 - São Paulo - SP - Fone: 11 5633-2855 / Fax: 5631-5392 Site: www.sdc.com.br                                                                                                                     -pg {PAGENO}-');
$pagina = file_get_contents("http://192.168.10.92/print_prop.php?id=".$id);
$mpdf->WriteHTML($pagina);
//$mpdf->Output();//DESSA FORMA NÃO GERA ARQUIVO SÓ VISUALIZAÇÃO EM TELA
$mpdf->Output('pdf/PropostaSdc_'.$numProp.'.pdf','F');
header("location:pdf/PropostaSdc_".$numProp.".pdf");
exit();
//CLASSE DE IMPRESSAO PDF
}else{
	echo "Informações insuficientes, tente outra vez!";
}
?>
	