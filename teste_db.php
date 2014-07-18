<html>
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
		<script type="text/javascript">
			function lookup(inputString) {
				if(inputString.length == 0) {
					// Hide the suggestion box.
					$('#suggestions').hide();
				} else {
					$.post("busca_w3.php", {queryString: ""+inputString+""}, function(data){
						if(data.length >0) {
							$('#suggestions').show();
							$('#autoSuggestionsList').html(data);
						}
					});
				}
			} // lookup
			
			function fill(thisValue) {
				$('#inputString').val(thisValue);
				setTimeout("$('#suggestions').hide();", 200);
			}
		</script>
	</head>
	<body>
		<?php
		header('Content-Type: text/html; charset=UTF-8');
		/*$serverSql = '192.168.10.93';
		$serverMySql = 'localhost';

		$userDbMySql = 'root';
		$userDbMsSql = 'sa';

		$pwdSql = 'w3pepino';
		$pwdMySql = '1qaz2wsx';
		
		//mssql_set_charset('iso-8859-1');
		$msSqlConection = mssql_connect ($serverSql, $userDbMsSql, $pwdSql);
		$mySqlConection = mysql_connect ($serverMySql, $userDbMySql, $pwdMySql);

		if (!$msSqlConection) {
			die('Ocorreu algum problema ao conectar em MSSQL');
		}else{
			echo "Tudo correu bem com MSSQL!!!<br>";
			mssql_select_db('w3sdcsdcsdc2017', $msSqlConection);
		}*/
		####################################################################################
		// Envía una consulta a MSSQL
		//$query = mssql_query("SELECT prd_cod,prd_desc,preco_Usuario,preco_Integrador,categ_prod,prd_cor,prd_tamanho,oo_moeda_de_preco FROM produto WHERE prd_cod like '%" . $_GET['desc_prod'] . "%';");

		// Verifica si había registros
		/*if (!mssql_num_rows($query)) {
			echo 'Sem registros<br><br>';
		}
		else
		{
			// Muestra una bonita lista de usuarios con el formato:
			// * nombre (nombre de usuario)

			echo '<ul>';

			while ($row = mssql_fetch_assoc($query)) {
				echo '<li><b>' . $row['prd_cod'] . '</b><br> (' . $row['prd_desc'] . ') - (' . $row['preco_Usuario']  . ' - ' . $row['preco_Integrador']  . ')  </li><br><br>';
			}

			echo '</ul>';
		}

		// Libera el recurso
		mssql_free_result($query);*/
		####################################################################################
		?>
		<form>
			Descrição do Produto:
				<br />
			<input type="text" size="30" value="" id="inputString" onKeyUp="lookup(this.value);" onBlur="fill();" />
				
			<div class="suggestionsBox" id="suggestions" style="display: none;">
				<img src="img/upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
				<div class="suggestionList" id="autoSuggestionsList">		 
				</div>
			</div>
		</form>
		<?php
		mssql_close();

		if (!$mySqlConection) {
				die('Ocorreu algum problema ao conectar em MYSQL');
		}else{
				echo "Tudo correu bem com MySql!";
		}
		mysql_close();

		?>
	</body>
</html>
