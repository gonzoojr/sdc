<html>
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	</head>
	<body>
			<?php
			header('Content-Type: text/html; charset=iso-8859-1');
			$serverSql = '192.168.10.93';
			$userDbMsSql = 'sa';
			$pwdSql = 'w3pepino';
//			mssql_set_charset('iso-8859-1');
			$msSqlConection = mssql_connect ($serverSql, $userDbMsSql, $pwdSql) or die ("Erro ao se conectar ao servidor");

			//$conn = mysql_connect("servidor","usuario","senha")  or die ("Erro ao se conectar ao servidor");
			//$bd	  = mysql_select_db("banco") or die ("Erro ao se conectar ao banco");
			$bd = mssql_select_db('w3sdcsdcsdc2017', $msSqlConection) or die ("Erro ao se conectar ao banco");
			//agora realizamos nossa consulta no banco com base no que � digitado no nosso input

			if(isset($_POST['queryString']))
			{
					$queryString = $_POST['queryString'];
					if(strlen($queryString) >0) {
						//$query = mysql_query("SELECT nome FROM paises WHERE nome LIKE '$queryString%' LIMIT 10") or die("Erro na consulta");
						$query = mssql_query("SELECT prd_cod,prd_desc,preco_Usuario,preco_Integrador,class_fiscal_prod,categ_prod,prd_cor,prd_tamanho,oo_moeda_de_preco FROM produto WHERE prd_desc like '%" . $queryString . "%';");
						echo "<ul>";
						while ($result = mssql_fetch_assoc($query)) {
							echo '<li onClick="fill(\''.$result['prd_desc']. ' (' . $result['preco_Usuario'] . ' - ' . $result['preco_Integrador'] . ')\',\''.$result['prd_desc'].'\',\''.number_format($result['preco_Usuario'], 2, ',', '.').'\',\''.number_format($result['preco_Integrador'], 2, ',', '.').'\');">'.$result['prd_desc']. ' (<b>U: R$' . number_format($result['preco_Usuario'], 2, ',', '.') . ' - I: R$' . number_format($result['preco_Integrador'], 2, ',', '.') .'</b>) - '.$result['prd_cod'].'</li>';
						}
						echo "</ul>";
					}
			}
			?>
	</body>
</html>