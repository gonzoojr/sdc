<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<meta http-equiv="Content-Language" content="pt-BR en">
		
		<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
		<script type="text/javascript" src="js/simpleAutoComplete.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui.min.js"></script>
		
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
		<link rel="stylesheet" type="text/css" href="css/simpleAutoComplete.css" />
		<link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css" />
		<link rel="stylesheet" type="text/css" href="css/jquery-ui.structure.css" />
		<link rel="stylesheet" type="text/css" href="css/jquery-ui.theme.min.css" />
		<title>Cadastro de Proposta</title>
		
		<script>
			var number = 0;
			var caixa = new Array();
			function add_subitem(way, especifico) {
			    //check if we should increment or decrement
			    /*METtODO POP REMOVE O ULTIMO ITEM DA ARRAY
			    METtODO SHIFT REMOVE O PRIMEIRO ITEM DA ARRAY
			    array.shift();
			    array.pop();
			    * */
				
			    if (way == "inc") {
			        //two plus signs will increment our variable by one
			        //caixa[number] = 'item_' +number + ',' + $('#desc_prod').val() + ',' + $('#vlr_u').val() + ',' + $('#vlr_i').val() + '';
			        caixa[number] = $('#desc_prod').val() + ',' + $('#vlr_u').val() + ',' + $('#vlr_i').val() + '';
			        
			        insCont(caixa[number], number);
			        
			        //alert(caixa);
			        number++;
			    } else if (way == "dec") {
			        //two minus signs will decrement our variable by one
			        if (number == 0){
			        	alert("Não existem itens para excluir");
			        }else{
			        	caixa.pop();
			        	number--;
			        }
			        //caixa[number] = "";
			        if (number == 0){
			        	alert("Não existem itens para exibir");
			        }else{
			        	//alert(caixa);
			        }
			    }else if (way == "esp"){
			    	//alert(especifico);
			    	for (i=especifico; i<caixa.length-1; i++) {
						caixa[i] = caixa[i+1];
						//alert("removendo" + caixa[i]);
					}
					caixa.pop();
			    }
			}
			
			function insCont(content, indice) {
	           $("#subitens").append('<p>' +content + ' <a href="#" onClick="add_subitem(\'esp\', '+indice+');$(this).parent(\'p\').remove();"><img src="img/remove.png" height="20px"></a></p>');
	        }
			
			$(function() {
				$( "#subitens" ).dialog({
					autoOpen: false,
					width: 350,
					show: 'slideDown',
					hide: 'slideUp',
					position: [500,250]
				});
				$( "#subitens" ).dialog( "option", "position", { my: "right top", at: "right top", of: "#list_item" } );
				//$('#subitens').draggable();
			});
			
			function zoia() {
	           $("#subitens").dialog("open");
	        }
	        
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
			
			function fill(thisValue, desc_prod, vlr_u, vlr_i) {
				$('#inputString').val(thisValue);
				$('#desc_prod').val(desc_prod);
				$('#vlr_u').val(vlr_u);
				$('#vlr_i').val(vlr_i);
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
					alert('Os Campos empresa e contato não podem estar em branco!!!');
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
			
			$(function() {
			    $( "button:first" ).button({
			      icons: {
			        primary: "ui-icon-locked"
			      },
			      text: false
			    }).next().button({
			      icons: {
			        primary: "ui-icon-locked"
			      }
			    }).next().button({
			      icons: {
			        primary: "ui-icon-gear",
			        secondary: "ui-icon-triangle-1-s"
			      }
			    }).next().button({
			      icons: {
			        primary: "ui-icon-gear",
			        secondary: "ui-icon-triangle-1-s"
			      },
			      text: false
			    });
			  });
			  
			function mascara(o,f){
    			v_obj=o
			    v_fun=f
			    setTimeout("execmascara()",1)
			}
			function execmascara(){
			    v_obj.value=v_fun(v_obj.value)
			}
			function mvalor(v){
			    v=v.replace(/\D/g,"");//Remove tudo o que não é dígito
			    v=v.replace(/(\d)(\d{8})$/,"$1.$2");//coloca o ponto dos milhões
			    v=v.replace(/(\d)(\d{5})$/,"$1.$2");//coloca o ponto dos milhares
			 
			    v=v.replace(/(\d)(\d{2})$/,"$1,$2");//coloca a virgula antes dos 2 últimos dígitos
			    return v;
			}
		</script>
		
		<?php
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
		
		include("conn_mssql.php");
				
		$query = mssql_query("SELECT top 1 moedacot_valor_venda FROM moedas_cotacao order by moedaskey DESC;");
		if (!mssql_num_rows($query)) {
			$dolar = 'Não foi encontrada nenhuma cotação!';
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
			#subitens p{
				border: 1px solid #999999;
				margin: 0 0 0 0;
			}
		</style>
	</head>
	<body>
		<div id="datepicker"></div>
		<!--<input type="button" name="mybutton" value="Add" onclick="add_subitem('inc');" />
		<input type="button" name="mybutton" value="MOstrar Janela" onclick="zoia();" />
		<input type="button" name="mybutton" value="Rem 2" onclick="add_subitem('esp', 1);" />
		<input type="button" name="mybutton" value="Show" onclick="alert(caixa);alert(caixa.length);" />-->
		<div id="subitens" title="Itens da Proposta">
		</div>
		<!--FORMULÁRIO DE CADASTRO-->		
		<form class="form-inline" id="form1" name="form1" method="post" action="">
			<table border="0" align="center" style="border: 1px solid #000;border-collapse:collapse; min-width: 50%">
				<tr>
					<td align="right" colspan="3">
						<label for="num_prop">Proposta:</label><br />
						<input class="form-control" style="width: 80px;" type="text" name="num_prop" id="num_prop" />
					</td>
					<td align="right">
						<b>Versão:</b><br />
						<input type="text" class="form-control" style="width: 30px;" name="versao" readonly="readonly" id="versao" />
					</td>
					<td align="right">
						<label for="dolar">Dolar:</label><br />
						<input type="text" class="form-control" name="dolar" style="width: 60px;" value="<?php echo $dolar;?>" readonly="readonly" id="dolar" />
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<label for="empresa">Empresa:</label><br />
						<input type="text" class="form-control" name="empresa" style="width: 400px;" id="empresa" onKeyUp="lookupEmp(this.value);" onBlur="fillEmp();" />
						<input type="hidden" name="Idempresa" style="width: 350px;" id="Idempresa" />
						<div class="suggestionsBoxEmp" id="suggestionsEmp" style="display: none;">
							<!--<img src="img/upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />-->
							<div class="suggestionListEmp" id="autoSuggestionsListEmp">		 
							</div>
						</div>
					</td>
					<td>
						<label for="contato">Contato:</label><br />
						<select class="form-control" style="width: 120px;" name="contato" id="contato" onChange="fillCont(this.value,'GerenteContato');">
						</select>
						<!--<input type="text" style="width: 200px;" name="contato" id="contato" />-->
					</td>
					<td>
						<label for="uf">UF:</label><br />
						<input type="text" class="form-control" name="uf" id="uf" readonly="readonly" />
					</td>
				</tr>
				<tr>
					<td>
						<label for="gerente">Gerente:</label><br />
						<input type="text" name="gerente" class="form-control" readonly="readonly" id="gerente" />
					</td>
					<td>
						<label for="data_abertura">Data:</label><br />
						<input type="text" class="form-control" name="data" id="data" />
					</td>
					<td>
						<label for="status">Status:</label><br />
						<select class="form-control" name="status" id="status">
							<option value="abe">Aberta</option>
							<option value="fat">Faturada</option>
							<option value="per">Perdida</option>
						</select>
					</td>
					<td>
						<label for="tipo">Tipo:</label><br />
						<select class="form-control" name="tipo" id="tipo">
							<option value="ven">Venda</option>
							<option value="emp">Empréstimo</option>
							<option value="loc">Locação</option>
						</select>
					</td>
					<td>
						<label for="usuario">Usuário:</label><br />
						<select class="form-control" name="usuario" id="usuario">
							<option value="int">Integrador</option>
							<option value="fin">Final</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="5">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="5">Titulo Produto: &nbsp;<input type="text" class="form-control" name="titulo_prod" id="titutlo_prod">&nbsp;
						<button type="button" class="btn btn-primary">Adicionar Produto Pai</button>
						<button type="button" class="btn btn-primary" id="list_item" onclick="zoia();" >Listar Itens</button></td>
				</tr>
				<tr>
					<td colspan="5">

						Descrição do Produto:
							<br />
						<input type="text" class="form-control" size="30" value="" id="inputString" onKeyUp="lookup(this.value);" onBlur="fill();" />
						<div class="suggestionsBox" id="suggestions" style="display: none;">
							<!--<img src="img/upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />-->
							<div class="suggestionList" id="autoSuggestionsList">		 
							</div>
						</div>
						<br />
						<img src="img/usuariointegrador.jpg"><br />
						<input type="text" class="form-control" style="width: 110px;" placeholder="Produto" id="desc_prod" name="desc_prod">
						<input type="text" class="form-control" style="width: 110px;" placeholder="Valor Usuário" readonly="readonly" id="vlr_u" name="vlr_u">
						<input type="text" class="form-control" style="width: 110px;" placeholder="Valor Integrador" readonly="readonly" id="vlr_i" name="vlr_i">
						<input type="text" class="form-control" style="width: 110px;" placeholder="Seu Valor" id="valor_prop" onkeyup="mascara(this, mvalor);" name="valor_prop">
						<img src="img/add.png" height="20px" onclick="add_subitem('inc');">											
						
					</td>
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
		<!--FORMULÁRIO DE CADASTRO-->
	</body>
</html>