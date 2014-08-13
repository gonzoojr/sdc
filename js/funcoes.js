			var wJanela = $(window).width();
			var hJanela = $(window).height();
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
			
			function fill(thisValue, prd_cod, desc_prod, estoque, vlr_u, vlr_i, ncm) {
				prd_cod = $.trim(prd_cod);
				$('#inputString').val(desc_prod);
				$('#descCliente').val(desc_prod);
				$('#desc_prod').val(desc_prod);
				$("#estoque").val(estoque);
				$('#vlr_u').val(vlr_u);
				$('#vlr_i').val(vlr_i);
				$('#ncm').val(ncm);
				$("#prd_cod").val(prd_cod);
				setTimeout("$('#suggestions').hide();", 200);
				//$("#estoque").val(estoque);
			}

			function fillEmp(Empresa, IdEmpresa, UF) {
				$('#empresa').val(Empresa);
				$('#Idempresa').val(IdEmpresa);
				$('#buscaUF').val(UF);
				setTimeout("$('#suggestionsEmp').hide();", 200);
				lookupCont(IdEmpresa);
				$('#dEmpresa').val($('#empresa').val());
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
							$('#gerente').val($.trim(data));
							//alert(data);
						}
					});
				}
				//$('#gerente').val(thisValue);
				//alert(thisValue);
			}
			
			function todosNcm(UF){
				if($("#prod_n_cad").is(":checked")){
					$.post("consultas.php?todosNcm=ncm", {UF:UF}, function(data){
						if(data.length > 0) {
							dadosNCM = data;
							$("#ncm").remove();
							$("#celNcm").html(dadosNCM);
							$("#inputString").prop('disabled', true);
							//alert(data);
	
						} else if(data == 0){
							//alert(data);
							alert("Problema para exibir lista de NCM!");
						}
					});

				}else{
					//alert("hahaha");
					$("#ncm").remove();
					$("#celNcm").html('<input type="text" class="form-control" size="95%" name="ncm" id="ncm" readonly="readonly" value="" />');
					$("#inputString").prop('disabled', false);
				}
			}
			
			function editarItem(posItem, idGeral){
				
				var formPrd = '<div style"display:inline"><label for="empresa">Busca por Descrição:</label>'
				+ '<span style="position: absolute; right: 0;">Não Existente <input type="checkbox" name="prod_n_cad" id="prod_n_cad" value="sim" onclick="todosNcm(\''+$("#idUF").val().replace("  ","")+'\');">Serviço? <input type="checkbox" name="servico" value="sim">Calcular ST? <input type="checkbox" name="calc_st" id="calc_st" value="sim"></span></div>'
				+ '<input type="text" class="form-control" size="30" value="" name="descProd" id="inputString" onKeyUp="lookup(this.value);" onBlur="fill();" />'
				+ '<div class="suggestionsBox" id="suggestions" style="display: none;">'
				+ '		<!--<img src="img/upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />-->'
				+ '		<div class="suggestionList" id="autoSuggestionsList">'
				+ '		</div>'
				+ '</div>'
				+'<label for="descProd">Descrição para Proposta:</label>'
				+ '<textarea class="form-control" size="30" name="descCliente" id="descCliente" placeholder="Descrição aqui..." /></textarea>'
				+ '<table border="0" class="tbl_clientes">'
				+'<tr><td><label for="vlrProp">Valor para Prosposta:</label></td><td><label for="vlrUsu">Qtd:</label></td><td><label for="vlrInt">Valor Usuário:</label></td><td><label for="estoque">Valor Integrador:</label></td></tr>'
				+ '<tr><td><input type="text" class="form-control" size="30" name="vlr_f" id="vlr_f" onkeyup="mascara(this, mvalor);" value="" /></td>'
				+ '<td><input type="text" class="form-control" size="5%" maxlength="3" name="qtd_prod" id="qtd_prod" value="" /></td>'
				+ '<td><input type="text" class="form-control" size="30" name="vlr_u" id="vlr_u" readonly="readonly" value="" /></td>'
				+ '<td><input type="text" class="form-control" size="30" name="vlr_i" id="vlr_i" readonly="readonly" value="" /></tr>'
				+ '</table>'
				+ '<table border="0" class="tbl_clientes">'
				+ '<tr><td><label for="dolar">Dolar do dia U$:</label></td><td><label for="descProd">Classificação Fiscal (NCM):</label></td><td><label for="descProd">Qtd em Estoque:</label></td></tr>'
				+ '<tr><td><input type="text" class="form-control" name="dolarExib" onkeyup="mascara(this,mvalorDolar);" value="'+$("#dolarDia").val()+'" id="dolar" /></td><td id="celNcm"><input type="text" class="form-control" size="95%" name="ncm" id="ncm" readonly="readonly" value="" /></td><td><input type="text" class="form-control" size="30" name="estoque" id="estoque" readonly="readonly" value="" /></td><input type="hidden" class="form-control" size="5%" name="prd_cod" id="prd_cod" value="" />'
				+ '<input type="hidden" class="form-control" size="5%" name="editIdGeral" id="editIdGeral" value="'+idGeral+'" />'
				+ '<input type="hidden" class="form-control" size="5%" name="editor" id="editor" value="'+posItem+'" /></td></tr>'
				+ '</table>'
				+ '<button type="button" class="btn btn-success" onclick="enviaInfo(\'item\',\'item\');">Atualizar Item</button>'
				;
				
				$('#subitens').html(formPrd);
				
				$.post("consultas.php?select=idGeral, posItem, descricao, vlrUnit, icms, ipi, iss, st, qtd, prd_cod, ncm&tabela=tbl_item_proposta&where=WHERE idGeral:"+idGeral+" AND posItem:"+posItem , {queryString: ""+idGeral+""}, function(data){
					//prompt("a","consultas.php?select=idGeral, posItem, descricao, vlrUnit, icms, ipi, iss, st, qtd, prd_cod&tabela=tbl_item_proposta&where=WHERE idGeral:"+idGeral+" AND posItem:"+posItem);
					if(data.length > 0) {
						//$('#suggestionsCont').show();
						//$('#contato').html(data);
						//$('#gerente').val($.trim(data));
						
						dadosItemEd = data.split("$");
						var ncm = dadosItemEd[10].replace(".","");
						var ncm = ncm.replace(".","");
						$("#prd_cod").val(dadosItemEd[9]);
						$("#descCliente").val(dadosItemEd[2]);
						$("#vlr_f").val(dadosItemEd[3]);
						$("#qtd_prod").val(dadosItemEd[8]);
						$("#ncm").val(ncm);
						//alert(data);
						//alert("Empresa adicionada!");
						
						/*$("#editEmpresa").html("<img src='img/edit.png' class='editEmpresa' onclick='altContDialog(\"formEmp\",\"#subitens\");janela(\"Busca de Empresa\");'>");
						$("#subitens").dialog("close");
						$("#tipoUsuarioConsulta").val(tipoUsuario);
						$("#idUF").val($("#buscaUF").val());*/
					} else if(data == 0){
						alert("Erro ao tentar editar item!");
					}
				});
				
				if($("#tipoUsuarioConsulta").val()=="final"){
					$("#calc_st").attr("disabled", true);
					//alert($("#tipoUsuarioConsulta").val());
				}else{
					$("#calc_st").removeAttr("disabled");
				}
				
				$(function() {
					$( idDialog ).dialog({
						autoOpen: false,
						width: wJanela*0.5,
						height: hJanela*0.5,
						show: 'slideDown',
						hide: 'slideUp',
					});
					//$('#subitens').draggable();
				});
				$('#subitens').dialog('option', 'title', 'Editar Produto');
				//alert(titulo);
				$("#subitens").dialog("open");
			}
			
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
			
			function altContDialog(form, idDialog) {
				if (form == "formEmp"){
					var formEmp = '<form name="selEmpresa" method="POST" action="">'
					+ '<label for="empresa">Buscar Empresa:</label><br />'
					+ '<input type="text" class="form-control" name="empresa" style="width: 400px;" id="empresa" onKeyUp="lookupEmp(this.value);" onBlur="fillEmp();" />'
					+ '<div class="suggestionsBoxEmp" id="suggestionsEmp" style="display: none;">'
						+ '<div class="suggestionListEmp" id="autoSuggestionsListEmp">'		 
						+ '</div>'
					+ '</div>'
					+ '<label for="empresa">Empresa Selecionada:</label><br />'
					+ '<input type="text" id="dEmpresa" class="form-control" style="width: 400px;" value="..." readonly="readonly">'
					+ '<input type="hidden" id="buscaUF" class="form-control width: 400px;">'
					+ '<input type="hidden" name="Idempresa" style="width: 350px;" id="Idempresa" />'
					+ '<table border="0" class="tbl_clientes">'
					+ '<tr><td><label for="contato">Contato:</label></td><td><label for="gerente">Gerente:</label></td><td><label for="contato">Usuário:</label></td></tr>'
					+ '<tr><td><select class="form-control" style="width: 120px;" name="contato" id="contato" onChange="fillCont(this.value,\'GerenteContato\');"></td>'
					+ '<td><input type="text" style="width: 120px;" name="gerente" readonly="readonly" class="form-control" id="gerente"  /></td>'
					+ '<td><select name="tipoUsuario" id="tipoUsuario" class="form-control">'
					+ '<option value="">Escolha</option>'
					+ '<option value="final">Final</option>'
					+ '<option value="integrador">Integrador</option>'
					+ '</select></td></tr>'
					+ '</table>'
					+ '<br />'
					+ '</select>'
					+ '<br />'
					+ '<button type="button" class="btn btn-success" onclick="enviaInfo(\'empresa\',\'empresa\')">OK</button>'
					+ '</form>'
					;
					
					$(idDialog).html(formEmp);
					
					$(function() {
						$( idDialog ).dialog({
							autoOpen: false,
							width: wJanela*0.5,
							height: hJanela*0.5,
							show: 'slideDown',
							hide: 'slideUp',
						});
						//$('#subitens').draggable();
					});
					
				}else if (form == "formProd"){
					
					var formPrd = '<div style"display:inline"><label for="empresa">Busca por Descrição:</label>'
					+ '<span style="position: absolute; right: 0;">Não Existente <input type="checkbox" name="prod_n_cad" id="prod_n_cad" value="sim" onclick="todosNcm(\''+$("#idUF").val().replace("  ","")+'\');">Serviço? <input type="checkbox" name="servico" value="sim">Calcular ST? <input type="checkbox" name="calc_st" id="calc_st" value="sim"></span></div>'
					+ '<input type="text" class="form-control" size="30" value="" name="descProd" id="inputString" onKeyUp="lookup(this.value);" onBlur="fill();" />'
					+ '<div class="suggestionsBox" id="suggestions" style="display: none;">'
					+ '		<!--<img src="img/upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />-->'
					+ '		<div class="suggestionList" id="autoSuggestionsList">'
					+ '		</div>'
					+ '</div>'
					+'<label for="descProd">Descrição para Proposta:</label>'
					+ '<textarea class="form-control" size="30" name="descCliente" id="descCliente" placeholder="Descrição aqui..." /></textarea>'
					+ '<table border="0" class="tbl_clientes">'
					+'<tr><td><label for="vlrProp">Valor para Prosposta:</label></td><td><label for="vlrUsu">Qtd:</label></td><td><label for="vlrInt">Valor Usuário:</label></td><td><label for="estoque">Valor Integrador:</label></td></tr>'
					+ '<tr><td><input type="text" class="form-control" size="30" name="vlr_f" id="vlr_f" onkeyup="mascara(this, mvalor);" value="" /></td>'
					+ '<td><input type="text" class="form-control" size="5%" maxlength="3" name="qtd_prod" id="qtd_prod" value="" /></td>'
					+ '<td><input type="text" class="form-control" size="30" name="vlr_u" id="vlr_u" readonly="readonly" value="" /></td>'
					+ '<td><input type="text" class="form-control" size="30" name="vlr_i" id="vlr_i" readonly="readonly" value="" /></td></tr>'
					+ '</table>'
					+ '<table border="0" class="tbl_clientes">'
					+ '<tr><td><label for="dolar">Dolar do dia U$:</label></td><td><label for="descProd">Classificação Fiscal (NCM):</label></td><td><label for="descProd">Qtd em Estoque:</label></td></tr>'
					+ '<tr><td><input type="text" class="form-control" onkeyup="mascara(this,mvalorDolar);" name="dolarExib" value="'+$("#dolarDia").val()+'" id="dolar" /></td><td id="celNcm"><input type="text" class="form-control" size="95%" name="ncm" id="ncm" readonly="readonly" value="" /></td><td><input type="text" class="form-control" size="30" name="estoque" id="estoque" readonly="readonly" value="" /><input type="hidden" class="form-control" size="5%" maxlength="3" name="prd_cod" id="prd_cod" value="" /></td></tr>'
					+ '</table>'
					+ '<button type="button" class="btn btn-success" onclick="enviaInfo(\'item\',\'item\');">Adicionar Item</button>'
					;
					
					$(idDialog).html(formPrd);
					
					if($("#tipoUsuarioConsulta").val()=="final"){
						$("#calc_st").attr("disabled", true);
						//alert($("#tipoUsuarioConsulta").val());
					}else{
						$("#calc_st").removeAttr("disabled");
					}
					
					$(function() {
						$( idDialog ).dialog({
							autoOpen: false,
							width: wJanela*0.5,
							height: hJanela*0.5,
							show: 'slideDown',
							hide: 'slideUp',
						});
						//$('#subitens').draggable();
					});
					
				}else if (form == "formPrazoPgto"){
					var formPrd = '<label for="descProd">Prazo de Pagamento:</label>'
					+ '<textarea class="form-control" size="30" name="descCliente" id="descCliente" placeholder="Descrição aqui..." /></textarea>'
					+ '<button type="button" class="btn btn-success" onclick="enviaInfo(\'item\',\'item\');">Atualizar</button>'
					;
					
					$(idDialog).html(formPrd);
				}else{
					alert("Erro: Ao Exibir Formulário! Informe o administrador.");
				}
	        }
	        
	        function nl2br(str, is_xhtml) {   
			    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';    
			    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
			}
	        
	        function calculadoraProd(valor, qtd, icms, ipi, st, percent_icms_st, calc_st, tipoUsuario){
				var calculado = "";
				var dolar = $("#dolarDia").val();
				//alert(calc_st);
				//alert("valor " + valor + " icms " + icms + " ipi " + ipi);
				$.ajax({
		            type: "POST",
		            data: { valor:valor, qtd:qtd, percent_icms:icms, percent_ipi:ipi, percent_st:st, percent_icms_st:percent_icms_st, calc_st:calc_st, tipoUsuario:tipoUsuario, dolar:dolar },
		            url: "calculadora.php",
		            dataType: "html",
		            async: false,
		            success: function(result){
		            	$("#teste").val(result);
		            	//alert(result);
		                calculado = result;
		            }
		        });
		        //alert(calculado)
		        return calculado;
			}
			
			function insertItens(idGeral, prd_cod, mostraNcm, vlrUnit, icms, ipi, iss, st, qtd, descCliente, totalCalcItem){
				var item = "";
				//alert("aqui");
				$.ajax({
		            type: "POST",
		            data: { idGeral:idGeral, prdCod:prd_cod, mostraNcm:mostraNcm, vlrUnit:vlrUnit, icms:icms, ipi:ipi, iss:iss, st:st, qtd:qtd,descCliente:descCliente, totalCalcItem:totalCalcItem },
		            url: "consultas.php?item=insert",
		            dataType: "html",
		            async: false,
		            success: function(result){
		            	//alert(result);
		                item = result;
		            }
		        });
		        //alert (item);
		        return item;
			}
	        
	        function verEstoque(prd_cod){
				var prd_cod = "";
				$.ajax({
		            type: "POST",
		            data: { prd_cod:prd_cod },
		            url: "consultas.php?estoque=ver",
		            dataType: "html",
		            async: false,
		            success: function(result){
		            	//alert(result);
		                prd_cod = result;
		            }
		        });
		        //alert (prd_cod);
		        return prd_cod;
			}
	        
	        function enviaInfo(idArea, tipo){
	        	if(tipo == "empresa"){
		        	var area = '#' + idArea;
		        	var dadosContato = $('#contato').val().split(",");
		        	var idProposta = $('#idGeral').val();
		        	var tipoUsuario = $('#tipoUsuario').val();
		        	var foneContato  = dadosContato[3];
		        	var nomeContato  = dadosContato[2];
		        	var emailContato = dadosContato[1];
		        	var idContato    = dadosContato[0];
		        	var conteudo = '<b>Empresa: </b>' + $('#dEmpresa').val() + '<br>'
								+'<b>Contato: </b>' + nomeContato + '(' + emailContato + ')<br>'
								+'<b>Telefone: </b>' + foneContato + '';
					$(area).html(conteudo);
		        	
					var idempresa = $("#Idempresa").val();
					$.post("consultas.php?campos=idContato:" + idContato + ",idEmpresa:"+idempresa+",tipoUsuario:\'"+tipoUsuario+"\'&tabela=tbl_proposta&where=WHERE idGeral:"+idProposta , {queryString: ""+idempresa+""}, function(data){
					
						if(data.length > 0) {
							//$('#suggestionsCont').show();
							//$('#contato').html(data);
							//$('#gerente').val($.trim(data));
							//alert(data);
							//alert("Empresa adicionada!");
							$("#editEmpresa").html("<img src='img/edit.png' class='editEmpresa' onclick='altContDialog(\"formEmp\",\"#subitens\");janela(\"Busca de Empresa\");'>");
							$("#subitens").dialog("close");
							$("#tipoUsuarioConsulta").val(tipoUsuario);
							$("#idUF").val($("#buscaUF").val());
							location.href="proposta.php?id="+idProposta;
						} else if(data == 0){
							alert("Erro ao selecionar empresa!");
						}
					});
				}else if(tipo == "item"){
					var idNcm = $('#ncm').val();
					var idUF = $('#idUF').val();
					
					$.post("consultas.php?ncm=" + idNcm + "&uf=" + idUF , {queryString: "teste"}, function(data){
						if(data.length > 0) {
							
							//$('#suggestionsCont').show();
							//$('#contato').html(data);
							//$('#gerente').val($.trim(data));
							dadosItem = data.split(";");
							var ipi = dadosItem[0];
							//alert(ipi);
							var icms = dadosItem[1];
							var st =  dadosItem[2];
							var iss = dadosItem[3];
							var icmsst = dadosItem[4];
							var qtd = $("#qtd_prod").val();
							var prd_cod = $("#prd_cod").val();
							var mostraNcm = ncm($("#ncm").val());
							var valor_uni = $("#vlr_f").val();
							var tipoUsuario = $("#tipoUsuarioConsulta").val();
							if($("#calc_st").is(":checked")){
								var calc_st = "sim";	
							}else{
								var calc_st = "nao";
							}
							
							
							//alert("icmsstDb: " + icmsst + " tipoUsuario: " + tipoUsuario);
							
							var retorno = calculadoraProd(valor_uni, qtd, icms, ipi, st, icmsst, calc_st, tipoUsuario);
							
							//alert(retorno);
							
							var calculo = retorno.split(";");
							var icms_calc = calculo[0].replace(".", ",");
							var ipi_calc = calculo[1].replace(".", ",");
							var st_calc = calculo[2].replace(".", ",");
							var totalCalcItem = calculo[3].replace(".", ",");
							var iss_calc = calculo[4].replace(".", ",");
							var vlr_unit_db = $("#vlr_f").val().replace(".","");
							var vlr_unit_db = vlr_unit_db.replace(",",".");
							vlr_unit_db = vlr_unit_db * $("#dolarDia").val();
							//alert("Vai pro banco " + vlr_unit_db); 
							
							//SEMPRE QUE MUDAR A VAR vlr_unit_db ALTERAR A LINHA DE UPDATE TBM 
							
							if($("#editor").length==0){
								//prompt("a","consultas.php?ncm=" + idNcm + "&uf=" + idUF);
								var posicao = insertItens($("#idGeral").val(), prd_cod, mostraNcm, vlr_unit_db, icms_calc.replace(",", "."), ipi_calc.replace(",", "."), iss_calc.replace(",", "."), st_calc.replace(",", "."), qtd, $("#descCliente").val(), totalCalcItem);
							}else{
								var posicao = $("#editor").val();
								
								$.post("consultas.php?campos=prd_cod:\'"+prd_cod+"\',ncm:\'"+mostraNcm+"\', vlrUnit:\'"+vlr_unit_db+"\', icms:"+icms_calc.replace(",", ".")+", ipi:"+ipi_calc.replace(",", ".")+", iss:"+iss_calc.replace(",", ".")+", st:"+st_calc.replace(",", ".")+", qtd:"+qtd+"&tabela=tbl_item_proposta&where=WHERE posItem:"+posicao+" AND idGeral:"+$("#idGeral").val() , {queryString: ""+$("#descCliente").val()+""}, function(data){
								
									//prompt("a", data);
									if(data.length == 1) {
										//retorno do php
										//alert("Item atualizado");
									} else if(data != 1){
										alert("Erro ao atualizar produto! " + data);
									}
								});
							}
							
							
							
							var linha = '<tr class="comum" id="linha_'+posicao+'">'
							+'<td align="center">'+posicao+'<img src=\'img/edit.png\' class=\'editEmpresa\' onclick=\'editarItem("'+posicao+'","'+$("#idGeral").val()+'");janela("Edição de Produto");\'>'
							+'<img src=\'img/remove.png\' onclick="rmvLinhaItem('+posicao+','+$("#idGeral").val()+');" class=\'editEmpresa\'></td>'
							+'<td>'+nl2br($("#descCliente").val())+'</td>'
							+'<td>'+mostraNcm+'</td>'
							+'<td>'+$("#vlr_f").val()+'</td>'
							+'<td>'+icms_calc+'</td>'
							+'<td>'+ipi_calc+'</td>'
							+'<td>'+iss_calc+'</td>'
							+'<td>'+st_calc+'</td>'
							+'<td>'+qtd+'</td>'
							+'<td>R$ '+totalCalcItem+'</td>'
							+'</tr>'
							+'<tr class="total" id="total">'
							+'<td align="center">&nbsp;</td>'
							+'<td>&nbsp;</td>'
							+'<td>&nbsp;</td>'
							+'<td>&nbsp;</td>'
							+'<td>&nbsp;</td>'
							+'<td>&nbsp;</td>'
							+'<td>&nbsp;</td>'
							+'<td style="border: 1px solid #dadada;vertical-align:text-top;text-align: right;" colspan=2>Valor Total</td>'
							+'<td style="border: 1px solid #dadada;background:#c9e3f6;vertical-align:text-top;text-align: left;"><b><a href="?id='+$("#idGeral").val()+'">Atualizar</b></td>'
							+'</tr>'
							;
							if($("#editor").length > 0){
								$("#linha_"+posicao).remove();
							}
							addLinhaItem(linha);
							$("#total").remove();
							$("#subitens").dialog("close");
							
							if($("#editor").length > 0){
								$("#editor").val("");
							}
							
							location.href="proposta.php?id="+$("#idGeral").val();
							//alert(linha);
							/*alert("Empresa adicionada!");
							$("#editEmpresa").html("<img src='img/edit.png' class='editEmpresa' onclick='altContDialog(\"formEmp\",\"#subitens\");janela(\"Busca de Empresa\");'>");
							$("#subitens").dialog("close");
							$("#idUF").val($("#buscaUF").val());*/
						} else if(data == 0){
							alert("Erro ao selecionar produto!");
						}
					});
				}
	        }
			
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
			
			function mvalorDolar(v){
			    v=v.replace(/\D/g,"");//Remove tudo o que não é dígito
			    v=v.replace(/(\d)(\d{8})$/,"$1,$2");//coloca o ponto dos milhões
			    v=v.replace(/(\d)(\d{5})$/,"$1,$2");//coloca o ponto dos milhares
			 
			    v=v.replace(/(\d)(\d{2})$/,"$1.$2");//coloca a virgula antes dos 2 últimos dígitos
			    return v;
			}
			
			function cnpj(v){
			    v=v.replace(/\D/g,"")                           //Remove tudo o que não é dígito
			    v=v.replace(/^(\d{2})(\d)/,"$1.$2")             //Coloca ponto entre o segundo e o terceiro dígitos
			    v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3") //Coloca ponto entre o quinto e o sexto dígitos
			    v=v.replace(/\.(\d{3})(\d)/,".$1/$2")           //Coloca uma barra entre o oitavo e o nono dígitos
			    v=v.replace(/(\d{4})(\d)/,"$1-$2")              //Coloca um hífen depois do bloco de quatro dígitos
			    return v
			}
			
			function ncm(v){
				v=v.replace(/\D/g,"");
				v=v.replace(/(\d)(\d{4})$/,"$1.$2");
				
				v=v.replace(/(\d)(\d{2})$/,"$1.$2");//coloca a virgula antes dos 2 últimos dígitos
			    return v;
			    alert(v);
			}
			
			function addLinhaItem(linha){
					$("#listaItens").closest('table').append(linha);  		             
			}
			
			function rmvLinhaItem(posicao, idGeral){ 
				$("#linha_"+posicao).fadeOut("slow", function() { $(this).remove(); });  
				//alert("#linha_"+posicao)
	          	$.post("consultas.php?delete=delete", {tabelaDel: "tbl_item_proposta", whereDel: " idGeral="+idGeral+" AND posItem="+posicao+ " "}, function(data){
					//prompt("a", data);
					if(data == 1) {
						//ERRO
					} else if(data != 1){
						//OK DEU TUDO CERTO
						location.href="proposta.php?id="+idGeral;
					}
				});
			}
