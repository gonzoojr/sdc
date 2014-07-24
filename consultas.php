<?
/*ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);*/
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
			$query = mssql_query($sql);
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
			$query = mysql_query($sql) or die("<span class='erro'>Erro " . mysql_errno() . "informe o adminitrador!</span><a href='proposta.php'>Voltar</a>");
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
			$query = mysql_query("UPDATE " . $tabela . " SET " . $getCampos . " " . $getWhere) or die("<span class='erro'>Erro " . mysql_errno() . "informe o adminitrador!</span><a href='proposta.php'>Voltar</a>");
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
	$query = consultas("mysql", $query_ultimo_reg);
	$result = mysql_fetch_assoc($query);
	$num_itens = intval($result['idItem']);
	if($num_itens==0){
		$num_itens ++;
		$queryInsItem = "INSERT INTO  `sis_proposta`.`tbl_item_proposta` (
						`idItem` ,
						`idGeral` ,
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
						'".$_POST['mostraNcm']."',  
						'".$_POST['vlrUnit']."',  
						'".$_POST['icms']."',  
						'".$_POST['ipi']."',  
						'".$_POST['iss']."',  
						'".$_POST['st']."',  
						'".$_POST['qtd']."',  
						'".$_POST['descCliente']."',  
						'".$num_itens."'
						);";
		$queryItem = consultas("mysql", $queryInsItem);
	}
	echo $num_itens;
	return $num_itens; 
}
?>