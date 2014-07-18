<?php
$tipoConn = $_GET['tipoConn'];

if($tipoConn == "mysql"){
	$server = 'localhost';
	$userDb = 'root';
	$pwdSql = '1qaz2wsx';
	//mssql_set_charset('iso-8859-1');
	$SqlConection = mysql_connect ($server, $userDb, $pwdSql) or die ("Erro ao se conectar ao servidor");

	//$conn = mysql_connect("servidor","usuario","senha")  or die ("Erro ao se conectar ao servidor");
	//$bd	  = mysql_select_db("banco") or die ("Erro ao se conectar ao banco");
	$bd = mysql_select_db('sis_proposta', $SqlConection) or die ("Erro ao se conectar ao banco");
	//agora realizamos nossa consulta no banco com base no que é digitado no nosso input
}elseif("sqlsrv"){
	/*SDC
	$serverSql = '192.168.10.93';
	$userDbMsSql = 'sa';
	$pwdSql = 'w3pepino';
	*/
	
	$server = "TERMINATOR\MEULINDODB"; //serverName\instanceName
	$connectionInfo = array( "Database"=>"w3sdcsdcsdc2017", "UID"=>"sa", "PWD"=>"55143883");
	$SqlConection = sqlsrv_connect( $server, $connectionInfo);

	if( $SqlConection ) {
		 echo "<div style='position: absolute;'>DB: <font color='green'><b>OK</b></font></div>";
	}else{
		 echo "";
		 die( print_r( sqlsrv_errors(), true));
	}

}elseif($tipoConn == "mssql"){
	$server = '192.168.10.93';
	$userDb = 'sa';
	$pwdSql = 'w3pepino';
	//mssql_set_charset('iso-8859-1');
	$SqlConection = mssql_connect ($server, $userDb, $pwdSql) or die ("Erro ao se conectar ao servidor");

	//$conn = mysql_connect("servidor","usuario","senha")  or die ("Erro ao se conectar ao servidor");
	//$bd	  = mysql_select_db("banco") or die ("Erro ao se conectar ao banco");
	$bd = mssql_select_db('w3sdcsdcsdc2017', $SqlConection) or die ("Erro ao se conectar ao banco");
	//agora realizamos nossa consulta no banco com base no que é digitado no nosso input
}else{
	echo "Erro de conexão, consulte o adminitrador!";
}
?>