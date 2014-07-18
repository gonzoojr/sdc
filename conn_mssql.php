<?php
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
?>