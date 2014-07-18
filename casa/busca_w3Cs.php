<html>
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	</head>
	<body>
			<?php
			header('Content-Type: text/html; charset=iso-8859-1');
			$server = "TERMINATOR\MEULINDODB"; //serverName\instanceName
			$connectionInfo = array( "Database"=>"w3sdcsdcsdc2017", "UID"=>"sa", "PWD"=>"55143883");
			$SqlConection = sqlsrv_connect( $server, $connectionInfo);
			//mssql_set_charset('iso-8859-1');

			//$conn = mysql_connect("servidor","usuario","senha")  or die ("Erro ao se conectar ao servidor");
			//$bd	  = mysql_select_db("banco") or die ("Erro ao se conectar ao banco");
			
			//agora realizamos nossa consulta no banco com base no que � digitado no nosso input

			if(isset($_POST['queryString']))
			{
					$queryString = $_POST['queryString'];
					if(strlen($queryString) >0) {
						//$query = mysql_query("SELECT nome FROM paises WHERE nome LIKE '$queryString%' LIMIT 10") or die("Erro na consulta");
						$query = sqlsrv_query($SqlConection, "SELECT prd_cod,prd_desc,preco_Usuario,preco_Integrador,categ_prod,prd_cor,prd_tamanho,oo_moeda_de_preco FROM produto WHERE prd_desc like '%" . $queryString . "%';");
						echo "<ul>";
						while ($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
							echo '<li onClick="fill(\''.$result['prd_desc']. ' (' . $result['preco_Usuario'] . ' - ' . $result['preco_Integrador'] . ')\');">'.$result['prd_desc']. ' (<b>U: R$' . number_format($result['preco_Usuario'], 2, ',', '.') . ' - I: R$' . number_format($result['preco_Integrador'], 2, ',', '.') .'</b>) - '.$result['prd_cod'].'</li>';
						}
						echo "</ul>";
					}
			}
			?>
	</body>
</html>