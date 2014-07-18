<?
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
?>