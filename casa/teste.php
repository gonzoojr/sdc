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
		
		
		<script>
			var number = 0;
			var caixa = new Array();
			function change_number(way, especifico) {
			    //check if we should increment or decrement
			    /*METtODO POP REMOVE O ULTIMO ITEM DA ARRAY
			    METtODO SHIFT REMOVE O PRIMEIRO ITEM DA ARRAY
			    array.shift();
			    array.pop();
			    * */
			    
			    if (way == "inc") {
			        //two plus signs will increment our variable by one
			        caixa[number] = 'id' +number + ',campo 1,campo 2,campo 3,campo 4';
			        
			        insCont(caixa[number], number);
			        
			        alert(caixa);
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
			        	alert(caixa);
			        }
			    }else if (way == "esp"){
			    	alert(especifico);
			    	for (i=especifico; i<caixa.length-1; i++) {
						caixa[i] = caixa[i+1];
						//alert("removendo" + caixa[i]);
					}
					caixa.pop();
			    }
			}
			
			function insCont(content, indice) {
	           $("#subitens").append('<p>' +content + ' <a href="#" onClick="change_number(\'esp\', '+indice+');$(this).parent(\'p\').remove();">X</a></p>');
	        }
			
			$(function() {
				$( "#subitens" ).dialog({
					width: 350,
				});
				$('#subitens').draggable();
			});
			
			function zoia() {
	           $("#subitens").dialog("open");
	        }
		</script>
		<style>
			#subitens p{
				border: 1px solid #ff0000;
				margin: 5px 10px 5px 10px;
			}
		</style>
	</head>
	<body>
		<input type="button" name="mybutton" value="Add" onclick="change_number('inc');" />
		<input type="button" name="mybutton" value="MOstrar Janela" onclick="zoia();" />
		<input type="button" name="mybutton" value="Rem 2" onclick="change_number('esp', 1);" />
		<input type="button" name="mybutton" value="Show" onclick="alert(caixa);alert(caixa.length);" />
		<div id="subitens" title="Itens da Proposta">
		</div>
	</body>
</html>