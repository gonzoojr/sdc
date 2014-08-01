<html>
	<head>
		<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
		<script>
			
		</script>	
	</head>
	<body>
		<?
		echo "Inicio: " . date("Y-m-d H:i:s");
		/*ini_set('display_errors',1);
		ini_set('display_startup_errors',1);
		error_reporting(-1);
		header('Content-Type: text/html; charset=iso-8859-1');*/
		$serverSql = '192.168.10.93';
		$userDbMsSql = 'sa';
		$pwdSql = 'w3pepino';
		
		$msSqlConection = mssql_connect ($serverSql, $userDbMsSql, $pwdSql) or die ("Erro ao se conectar ao servidor");

		//$conn = mysql_connect("servidor","usuario","senha")  or die ("Erro ao se conectar ao servidor");
		//$bd	  = mysql_select_db("banco") or die ("Erro ao se conectar ao banco");
		$bd = mssql_select_db('w3sdcsdcsdc2017', $msSqlConection) or die ("Erro ao se conectar ao banco");
		//$queryString = utf8_decode($_GET['ff']);
			
			$query = mssql_query("SELECT prd_cod,
									prd_desc,
									preco_Usuario,
									preco_Integrador,
									class_fiscal_prod,
									categ_prod,
									prd_cor,
									prd_tamanho,
									oo_moeda_de_preco
								 FROM produto ;");
			//echo "<ul>";
			while ($result = mssql_fetch_assoc($query)) {
				
				$queryEstoque = mssql_query("SELECT count(prd_cod)
	  			FROM estoque_deposito_produto_serie
	  			WHERE status = 'EFETUADO_NUM_SERIE' 
	  			AND prd_cod = '".$result['prd_cod']."' 
	  			AND (dep_cod = 4 OR dep_cod = 18)");
				
				$resultEstoque = mssql_fetch_array($queryEstoque);

				/*echo '<li onClick="
				fill(\''.$result['prd_desc']. ' (' . $result['preco_Usuario'] . ' - ' . $result['preco_Integrador'] . ')\'
				,\''.$result['prd_desc'].'\'
				,\''.number_format($result['preco_Usuario'], 2, ',', '.').'\'
				,\''.number_format($result['preco_Integrador'], 2, ',', '.').'\'
				,\''.$result['class_fiscal_prod'].'\');">'.$result['prd_desc']. ' (<b>U: R$' . number_format($result['preco_Usuario'], 2, ',', '.') . ' - I: R$' . number_format($result['preco_Integrador'], 2, ',', '.') .'</b>) - '.$result['prd_cod'].' p - '.$resultEstoque[0].'</li>';
				*/
				
				$con=mysqli_connect("192.168.10.92","root","1qaz2wsx","sis_proposta");
				// Check connection
				if (mysqli_connect_errno()) {
				  echo "Falha ao conectar ao banco MySQL: " . $result['prd_cod'] . " Erro - " . mysqli_connect_error();
				}else{
					
				$buscaMysql = mysqli_query($con,"SELECT count(*) FROM estoque_w3 WHERE prd_cod = '" . $result['prd_cod'] . "'");
				$resultBusca = mysqli_fetch_array($buscaMysql);
				
				if($resultBusca > 0){
					mysqli_query($con,"UPDATE estoque_w3 SET qtd='".$resultEstoque[0]."', dataAtualizacao='".date("Y-m-d H:i:s")."' WHERE prd_cod='".$result['prd_cod']."'");
				}else{
					mysqli_query($con,"INSERT INTO estoque_w3 (prd_cod, qtd, dataAtualizacao) VALUES ('".$result['prd_cod']."', '".$resultEstoque[0]."','".date("Y-m-d H:i:s")."')");	
				}
				
				//echo "INSERT INTO estoque_w3 (prd_cod, qtd, dataAtualizacao) VALUES ('".$result['prd_cod']."', '".$resultEstoque[0]."','".date("Y-m-d H:i:s")."')";
					
				}
			}
			//echo "</ul>";
			mysqli_close($con);
			mssql_close();
			echo "Fim: " . date("Y-m-d H:i:s");
		?>
	</body>
</html>