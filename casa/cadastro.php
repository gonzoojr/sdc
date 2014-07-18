<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<title>Cadastro de Proposta</title>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<meta http-equiv="Content-Language" content="pt-BR en">
		<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
		<script type="text/javascript" src="js/simpleAutoComplete.js"></script>
		<script type="text/javascript" src="js/jquery-ui.min.js"></script>
		<!-- Latest compiled and minified JavaScript -->
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		
		
		<link rel="stylesheet" type="text/css" href="css/simpleAutoComplete.css" />
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<!-- Optional theme -->
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
		<link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css" />
		
		
   		<script type="text/javascript">
			// lookup W3
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
			} // lookup W3

			
			// lookup Empresas
			function lookupEmp(inputString) {
				if(inputString.length == 0) {
					// Hide the suggestion box.
					$('#suggestionsEmp').hide();
				} else {
					$.post("busca_empresa.php", {queryString: ""+inputString+""}, function(data){
						if(data.length >0) {
							$('#suggestionsEmp').show();
							$('#autoSuggestionsListEmp').html(data);
						}
					});
				}
			} // lookup Empresas
			
			// lookup Contat
			function lookupCont(inputString) {
				if(inputString.length == 0) {
					// Hide the suggestion box.
					//$('#suggestionsCont').hide();
					alert('Preencha o campo Empresa!!!');
				} else {
					$.post("busca_cont.php", {queryString: ""+inputString+""}, function(data){
						if(data.length >0) {
							//$('#suggestionsCont').show();
							$('#contato').html(data);
						}
					});
				}
			} // lookup Contato
			
			function fill(thisValue) {
				$('#inputString').val(thisValue);
				setTimeout("$('#suggestions').hide();", 200);
			}

			function fillEmp(Empresa, IdEmpresa, UF) {
				$('#empresa').val(Empresa);
				$('#Idempresa').val(IdEmpresa);
				$('#uf').val(UF);
				setTimeout("$('#suggestionsEmp').hide();", 200);
				lookupCont(IdEmpresa);
				//alert(value2);
			}

			function fillCont(thisValue, campo) {
				if(thisValue.length == 0) {
					// Hide the suggestion box.
					//$('#suggestionsCont').hide();
					alert('Os Campos empresa e contato n�o podem estar em branco!!!');
				} else {
					$.post("busca_dados_contato.php?campo="+ campo, {queryString: ""+thisValue+""}, function(data){
						if(data.length >0) {
							//$('#suggestionsCont').show();
							//$('#contato').html(data);
							$('#gerente').val(data);
							//alert(data);
						}
					});
				}
				//$('#gerente').val(thisValue);
				//alert(thisValue);
			}
			
			//$( "#datepicker" ).datepicker();
			$(function() {
				$("#data").datepicker();
				$("#data").datepicker("option", "dateFormat", "d/mm/yy");
				$("#data").datepicker("option", "minDate", 0);
				inst.dpDiv.find('.ui-datepicker-current-day a').removeClass('ui-state-active');
			});
		</script>
		<?php
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
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
		
		$query = mssql_query("SELECT top 1 moedacot_valor_venda FROM moedas_cotacao order by moedaskey DESC;");
		if (!mssql_num_rows($query)) {
			echo 'Não foi encontrada nenhuma cotação!';
		}
		else
		{
			while ($row = mssql_fetch_assoc($query)) {
				$dolar = $row['moedacot_valor_venda'];
			}
		}
		// Libera o recurso
		mssql_free_result($query);
		?>
		<style>
		.ui-icon-circle-triangle-e { background-position: -96px -384px; }
		.ui-icon-circle-triangle-s { background-position: -128px -384px; }
		.ui-icon-circle-triangle-w { background-position: -160px -384px; }
		.ui-icon-circle-triangle-n { background-position: -192px -384px; }
		</style>
	</head>
	<body>
	<div id="datepicker"></div>
	<form id="form1" name="form1" method="post" action="">
		<table width="50%" border="1" align="center" style="border: 1px solid #000;border-collapse:collapse;">
			<tr>
				<td align="right" colspan="3">
					<label for="num_prop">Proposta:</label><br />
					<input type="text" name="num_prop" id="num_prop" />
				</td>
				<td align="right">
					<b>Versão:</b><br />
					<input type="text" style="width: 30px;" name="versao" readonly="readonly" id="versao" />
				</td>
				<td align="right">
					<label for="dolar">Dolar:</label><br />
					<input type="text" name="dolar" style="width: 50px;" value="<?php echo $dolar;?>" readonly="readonly" id="dolar" />
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<label for="empresa">Empresa:</label><br />
					<input type="text" name="empresa" style="width: 400px;" id="empresa" onKeyUp="lookupEmp(this.value);" onBlur="fillEmp();" />
					<input type="hidden" name="Idempresa" style="width: 350px;" id="Idempresa" />
					<div class="suggestionsBoxEmp" id="suggestionsEmp" style="display: none;">
						<!--<img src="img/upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />-->
						<div class="suggestionListEmp" id="autoSuggestionsListEmp">		 
						</div>
					</div>
				</td>
				<td>
					<label for="contato">Contato:</label><br />
					<select style="width: 120px;" name="contato" id="contato" onChange="fillCont(this.value,'GerenteContato');">
					</select>
					<!--<input type="text" style="width: 200px;" name="contato" id="contato" />-->
				</td>
				<td>
					<label for="uf">UF:</label><br />
					<input type="text" name="uf" id="uf" readonly="readonly" />
				</td>
			</tr>
			<tr>
				<td>
					<label for="gerente">Gerente:</label><br />
					<input type="text" name="gerente" readonly="readonly" id="gerente" />
				</td>
				<td>
					<label for="data_abertura">Data:</label><br />
					<input type="text" name="data" id="data" />
				</td>
				<td>
					<label for="status">Status:</label><br />
					<select name="status" id="status">
						<option value="abe">Aberta</option>
						<option value="fat">Faturada</option>
						<option value="per">Perdida</option>
					</select>
				</td>
				<td>
					<label for="tipo">Tipo:</label><br />
					<select name="tipo" id="tipo">
						<option value="ven">Venda</option>
						<option value="emp">Empréstimo</option>
						<option value="loc">Locação</option>
					</select>
				</td>
				<td>
					<label for="usuario">Usuário:</label><br />
					<select name="usuario" id="usuario">
						<option value="int">Integrador</option>
						<option value="fin">Final</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="5">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="5">&nbsp;</td>
			</tr>
		</table>
		<!--<label for="email">E-mail:</label>
		<input type="text" name="email" id="email" />
		<label for="fone1">Fone:</label>
		<input type="text" name="fone1" id="fone1" />-->
		<label for="status">Status:</label>
		<select name="status" id="status">
		<option value="abe">Aberta</option>
		<option value="fat">Faturada</option>
		<option value="per">Perdida</option>
		</select>
		<label for="total">Total:</label>
		<input type="text" name="total" id="total" />
	</form>
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
		/*
		if (!$mySqlConection) {
				die('Ocorreu algum problema ao conectar em MYSQL');
		}else{
				echo "Tudo correu bem com MySql!";
		}
		mysql_close();
		*/
		?>
	</body>
</html>