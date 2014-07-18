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
							$('#gerente').val($.trim(data));
							//alert(data);
						}
					});
				}
				//$('#gerente').val(thisValue);
				//alert(thisValue);
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
					+ '<label for="empresa">Empresa:</label><br />'
					+ '<input type="text" class="form-control" name="empresa" style="width: 400px;" id="empresa" onKeyUp="lookupEmp(this.value);" onBlur="fillEmp();" />'
					+ '<input type="text" name="Idempresa" style="width: 350px;" id="Idempresa" />'
					+ '<div class="suggestionsBoxEmp" id="suggestionsEmp" style="display: none;">'
						+ '<div class="suggestionListEmp" id="autoSuggestionsListEmp">'		 
						+ '</div>'
					+ '</div>'
					+ '<label for="contato">Contato:</label><br />'
					+ '<select class="form-control" style="width: 120px;" name="contato" id="contato" onChange="fillCont(this.value,\'GerenteContato\');">'
					+ '</select>'
					+ '<label for="gerente">Gerente:</label><br />'
					+ '<input type="text" style="width: 120px;" name="gerente" readonly="readonly" class="form-control" id="gerente"  /><br />'
					+ '<button type="button" class="btn btn-success" onclick="enviaInfo(\'empresa\')">Escolher Empresa</button>'
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
					
				}else{
					alert("Erro 1");
				}
	        }
	        
	        function enviaInfo(idArea){
	        	var area = '#' + idArea;
	        	var dadosContato = $('#contato').val().split(",");
	        	var foneContato  = dadosContato[3];
	        	var nomeContato  = dadosContato[2];
	        	var emailContato = dadosContato[1];
	        	var idContato    = dadosContato[0];
	        	var conteudo = '<b>Empresa: </b>' + $('#empresa').val() + '<br>'
							+'<b>Contato: </b>' + nomeContato + '(' + emailContato + ')<br>'
							+'<b>Telefone: </b>' + foneContato + '';
				alert(conteudo);
				$(area).html(conteudo);
	        }
			