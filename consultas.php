<?
/*ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);*/
header('Content-Type: text/html; charset=UTF-8');
function consultas($tipoConn, $sql){
	if($tipoConn=="mssql"){
		
		$serverSql = '192.168.10.93';
	
		$userDbMsSql = 'sa';
	
		$pwdSql = 'w3pepino';
		
		//mssql_set_charset('iso-8859-1');
		$msSqlConection = mssql_connect ($serverSql, $userDbMsSql, $pwdSql);
		
		if (!$msSqlConection) {
			die('Ocorreu algum problema ao conectar em MSSQL');
		}else{
			//echo "Tudo correu bem com MSSQL!!!<br>";
			mssql_select_db('w3sdcsdcsdc2017', $msSqlConection);
		}
		
		
		if(strlen($sql) >0) {
			$query = mssql_query($sql) or die("Erro em consulta MsSql Consulte o administrador!!!");
			return $query;
		}else{
			return false;
		}
		
	}elseif($tipoConn=="mysql"){
		
		$serverSql = 'localhost';
	
		$userDbMsSql = 'root';
	
		$pwdSql = '1qaz2wsx';
		
		//mssql_set_charset('iso-8859-1');
		$msSqlConection = mysql_connect ($serverSql, $userDbMsSql, $pwdSql);
		
		if (!$msSqlConection) {
			die('Ocorreu algum problema ao conectar em MySQL '. mysql_error());
		}else{
			//echo "Tudo correu bem com MSSQL!!!<br>";
			mysql_select_db('sis_proposta', $msSqlConection);
		}
		
		if(strlen($sql) >0) {
			$query = mysql_query($sql) or die("<span class='erro'>Erro " . mysql_errno() . " (".$sql.")  informe o adminitrador!</span><a href='proposta.php'>Voltar</a>");
			return $query;
		}else{
			return false;
		}
		
	}else{
		
	}
}

if(isset($_GET['campos'])){
	function updtProposta($campos, $tabela, $where){
		
		$serverSql = 'localhost';
		
		$userDbMsSql = 'root';
	
		$pwdSql = '1qaz2wsx';
		
		//mssql_set_charset('iso-8859-1');
		$msSqlConection = mysql_connect ($serverSql, $userDbMsSql, $pwdSql);
		
		if (!$msSqlConection) {
			die('Ocorreu algum problema ao conectar em MySQL '. mysql_error());
		}else{
			//echo "Tudo correu bem com MSSQL!!!<br>";
			mysql_select_db('sis_proposta', $msSqlConection);
		}
		$getCampos = str_replace(":", "=", $_GET['campos']);
		$getWhere = str_replace(":", "=", $_GET['where']);
		if(strlen($campos) > 0 && strlen($tabela) > 0 && strlen($where) > 0) {
			$query = mysql_query("UPDATE " . $tabela . " SET " . $getCampos . " " . $getWhere) or die("Erro: " . mysql_errno() . "informe o adminitrador! UPDATE " . $tabela . " SET " . $getCampos . " " . $getWhere);
			//return $query . "UPDATE " . $tabela . " SET " . $getCampos . " " . $getWhere;
			return $query;
		}else{
			return false;
		}
		
	}
	$teste = updtProposta($_GET['campos'], $_GET['tabela'], $_GET['where']);
	echo $teste;
}

function mascara_string($mascara,$string)
{
   $string = str_replace(" ","",$string);
   for($i=0;$i<strlen($string);$i++)
   {
      $mascara[strpos($mascara,"#")] = $string[$i];
   }
   return $mascara;
}

if(strlen($_GET['ncm'])>0 && strlen($_GET['uf'])> 0){
	$estados = array("CE","MG","MS","MT","PE","PR","RJ","RS","SC","SP");
	if(in_array($_GET['uf'],$estados)){
		$ufCorreto = $_GET['uf'];
	} else{
		$ufCorreto = "Demais";
	}
	$tblNcm = "ncm_".str_replace(" ", "", $ufCorreto);
	$buscaNcm = mascara_string("####.##.##",$_GET['ncm']);
	$sql = "SELECT ipi, icms, st, iss, icmsst FROM " . $tblNcm . " WHERE ncm ='" . $buscaNcm . "' ";
	$query = consultas("mysql", $sql);
 
	$result = mysql_fetch_assoc($query);
	
	$retornoNcm = $result['ipi']. ";" .$result['icms']. ";" .$result['st']. ";" .$result['iss']. ";" .$result['icmsst'];
	echo $retornoNcm;
	return $retornoNcm; 
}

if(isset($_GET['item']) && isset($_POST['idGeral'])){
	$query_qts_itens = "SELECT count(idItem) as idItem, idGeral, posItem FROM `tbl_item_proposta` WHERE idGeral=".$_POST['idGeral'];
	$query = consultas("mysql", $query_qts_itens);
	
	$result = mysql_fetch_assoc($query);
	$num_itens = $result['idItem'];
	//echo $num_itens . "############ "; 
	if(isset($num_itens)){
		$num_itens = $num_itens + 1;
		$queryInsItem = utf8_decode("INSERT INTO  `sis_proposta`.`tbl_item_proposta` (
						`idItem` ,
						`idGeral` ,
						`prd_cod` ,
						`ncm` ,
						`vlrUnit` ,
						`icms` ,
						`ipi` ,
						`iss` ,
						`st` ,
						`qtd` ,
						`descricao` ,
						`posItem`
						)
						VALUES (
						NULL ,  
						'".$_POST['idGeral']."',
						'".$_POST['prdCod']."',    
						'".$_POST['mostraNcm']."',  
						'".$_POST['vlrUnit']."',  
						'".$_POST['icms']."',  
						'".$_POST['ipi']."',  
						'".$_POST['iss']."',  
						'".$_POST['st']."',  
						'".$_POST['qtd']."',  
						'".$_POST['descCliente']."',  
						'".$num_itens."'
						);");
		$queryItem = consultas("mysql", $queryInsItem);
		//echo $queryInsItem;
	}
	//echo $queryInsItem;
	echo $num_itens;
	return $num_itens; 
}
if(isset($_GET['estoque']) && isset($_POST['prd_cod'])){
		
	$queryEstoque = "SELECT count(prd_cod)
	FROM estoque_deposito_produto_serie
	WHERE status = 'EFETUADO_NUM_SERIE' 
	AND prd_cod = '".$_POST['prd_cod']."' 
	AND (dep_cod = 4 OR dep_cod = 18)";

	$query = consultas("mssql", $queryEstoque);
	
	$result = mssql_fetch_array($query);
	$num_estoque = $result[0];
	
	echo $num_estoque . " " . $_POST['prd_cod'];
	return $num_estoque; 
}
?>