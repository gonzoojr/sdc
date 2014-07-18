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
			//agora realizamos nossa consulta no banco com base no que é digitado no nosso input

			if(isset($_POST['queryString']))
			{
					$queryString = $_POST['queryString'];
					if(strlen($queryString) >0) {
						//$query = mysql_query("SELECT nome FROM paises WHERE nome LIKE '$queryString%' LIMIT 10") or die("Erro na consulta");
						$query = mysql_query("SELECT IdContato, NomeContato, EmailContato, GerenteContato FROM tbl_contato WHERE IdEmpresa = '" . $queryString . "';");
						//echo "<ul>";
						echo '<option value="">Escolha um contato</option>';
						while ($result = mysql_fetch_assoc($query)) {
							//echo '<li onClick="fillEmp(\''.$result['IdContato']. '\');">'.$result['NomeContato'].'</li>';
							echo '<option value="'.$result['IdContato'].'")">'.$result['NomeContato'].'</option>';
						}
						//echo "</ul>";
					}
			}
			?>