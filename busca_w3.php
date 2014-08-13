
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
					$queryString = utf8_decode($_POST['queryString']);
					if(strlen($queryString) >0) {
						//$query = mysql_query("SELECT nome FROM paises WHERE nome LIKE '$queryString%' LIMIT 10") or die("Erro na consulta");
						$query = mssql_query("SELECT top 30 prd_cod,
						prd_desc,
						preco_Usuario,
						preco_Integrador,
						class_fiscal_prod,
						categ_prod,
						prd_cor,
						prd_tamanho,
						oo_moeda_de_preco
						 FROM produto
						 WHERE 
						 prd_desc like '%" . $queryString . "%'
						 OR prd_cod like '%" . $queryString . "%';");
						echo "<ul>";
						###################ESTOQUE#####################
						$servermySql = 'localhost';
						$userDbMySql = 'root';
						$pwdmySql = '1qaz2wsx';
						$mySqlConection = mysql_connect ($servermySql, $userDbMySql, $pwdmySql) or die ("Erro ao se conectar ao servidor");
						$bdMy = mysql_select_db('sis_proposta', $mySqlConection) or die ("Erro ao se conectar ao banco");
						###################ESTOQUE#####################
						
						while ($result = mssql_fetch_assoc($query)) {

							###################ESTOQUE#####################	
							if(strlen($queryString) >0) {
							$Myquery = mysql_query("SELECT * FROM estoque_w3 WHERE prd_cod = '" . $result['prd_cod'] . "';") or die ("ERRO: Não foi possível determinar Estoque!");
							$Myresult = mysql_fetch_assoc($Myquery);
							//echo "SELECT ".$_GET['campo']." FROM tbl_contato WHERE IdEmpresa = '" . $queryString . "';";
							//echo "valor " . $valor;
							$estoque = $Myresult['qtd'];
							$pieces_datetime = explode(" ",$Myresult['dataAtualizacao']);
							$pieces_date = explode("-",$pieces_datetime[0]);
							$pieces_time = $pieces_datetime[1];  
							$hora_estoque = "(". $pieces_date[2]."/". $pieces_date[1]." ". $pieces_time . ")";
							}else{
								echo "ERRO: Não foi possível determinar Estoque!";
							}
							###################ESTOQUE#####################

							echo '<li onClick="
							fill(\''.$result['prd_desc']. ' (' . $result['preco_Usuario'] . ' - ' . $result['preco_Integrador'] . ')\'
							,\''.$result['prd_cod'].'\'
							,\''.$result['prd_desc'].'\'
							,\''.$estoque.' '.$hora_estoque.'\'
							,\''.number_format($result['preco_Usuario'], 2, ',', '.').'\'
							,\''.number_format($result['preco_Integrador'], 2, ',', '.').'\'
							,\''.$result['class_fiscal_prod'].'\');">- <b class="verde">'.$result['prd_cod'].'</b>:'.$result['prd_desc']. '
							 (<b>U: R$' . number_format($result['preco_Usuario'], 2, ',', '.') . '
							  - I: R$' . number_format($result['preco_Integrador'], 2, ',', '.') .'
							  </b>)</li>';
						}
						echo "</ul>";
					}
			}
			?>