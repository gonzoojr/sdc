<?
//phpinfo();
include "consultas.php";
$insert = "INSERT INTO  `sis_proposta`.`teste` (
	`nome`, `data`
	)
	VALUES ('paulo', '". date("Y-m-d H:i:s") ."'
	);
";
$query = consultas("mysql", $insert);
?>