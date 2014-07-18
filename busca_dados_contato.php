			<?php
			header('Content-Type: text/html; charset=iso-8859-1');
			$serverSql = 'localhost';
			$userDbMsSql = 'root';
			$pwdSql = '1qaz2wsx';
//			mssql_set_charset('iso-8859-1');
			$msSqlConection = mysql_connect ($serverSql, $userDbMsSql, $pwdSql) or die ("Erro ao se conectar ao servidor");

			//$conn = mysql_connect("servidor","usuario","senha")  or die ("Erro ao se conectar ao servidor");
			//$bd	  = mysql_select_db("banco") or die ("Erro ao se conectar ao banco");
			$bd = mysql_select_db('sis_proposta', $msSqlConection) or die ("Erro ao se conectar ao banco");
			//agora realizamos nossa consulta no banco com base no que � digitado no nosso input
			$valor = $_POST['queryString'];
			//$valor = "17";
			if(isset($valor))
			{
					$campo = $_GET["campo"];
					$queryString = $valor;
					if(strlen($queryString) >0) {
						$query = mysql_query("SELECT ".$_GET["campo"]." FROM tbl_contato WHERE IdContato = '" . $queryString . "';") or die ("ERRO: SELECT ".$_GET['campo']." FROM tbl_contato WHERE IdEmpresa = '" . $queryString . "';");
						$result = mysql_fetch_assoc($query);
						//echo "SELECT ".$_GET['campo']." FROM tbl_contato WHERE IdEmpresa = '" . $queryString . "';";
						//echo "valor " . $valor;
						echo $result[$_GET["campo"]];
					}else{
						echo "ERRO: SELECT ".$_GET["campo"]." FROM tbl_contato WHERE IdEmpresa = '" . $queryString . "';";
					}
			}else{
				echo "ERRO: SELECT ".$_GET["campo"]." FROM tbl_contato WHERE IdEmpresa = '" . $queryString . "';";
			}	
			?>