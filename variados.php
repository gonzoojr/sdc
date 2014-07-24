<html>
	<head>
		<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
		<script>
			
			function calcula(valor, qtd, icms, ipi, st){
				var calculado = "";
				$.ajax({
		            type: "POST",
		            data: { vlr_unidade:valor, qtd:qtd, percent_icms:icms, percent_ipi:ipi, percent_st:st },
		            url: "calculadora.php",
		            dataType: "html",
		            async: false,
		            success: function(result){
		            	//$("#teste").val(result);
		            	//alert(result);
		                calculado = result;
		            }
		        });
		        return calculado;
			}
			function calculadoraProd(valor, qtd, icms, ipi, st, volta){
	        	$.post("calculadora.php" , {vlr_unidade: ""+valor+"", qtd: ""+qtd+"", percent_icms: ""+icms+"", percent_ipi: ""+ipi+"", percent_st: ""+st+""}, function(teste){
				//alert("consultas.php?campos=idContato:" + idContato + ",idEmpresa:"+idempresa+"&tabela=tbl_proposta&where=WHERE idProposta:"+idProposta);
					if(teste.length > 0) {
						//$('#suggestionsCont').show();
						//$('#contato').html(data);
						//$('#gerente').val($.trim(data));
						//alert("aqui" + data);
						var volta = teste;
						alert(volta);
						return volta;
					} else if(data == 0){
						alert("Erro ao selecionar empresa!");
						return false;
					}
					//alert(data);
				});
	        }
	        function vamosla(){
		        var vai = calcula(100,1,15,18,27.46);
		        var matrix = vai.split(";");
		        var total = matrix[3];
		        alert (total);
	        } 
		</script>	
	</head>
	<body onload="">
		<input type="text" id="teste" name="teste">
		<button name="botao" onclick="vamosla();" value="Teste">
		<?
		$serverSql = 'localhost';
	
		$userDbMsSql = 'root';
	
		$pwdSql = '1qaz2wsx';
		
		//mssql_set_charset('iso-8859-1');
		$msSqlConection = mysql_connect ($serverSql, $userDbMsSql, $pwdSql);
		
		if (!$msSqlConection) {
			die('Ocorreu algum problema ao conectar em MySQL '. mysql_error());
		}else{
			//echo "Tudo correu bem com MSSQL!!!<br>";
			mysql_select_db('sis_proposta', $msSqlConection);
		}
		$sql = "
		CREATE OR REPLACE FUNCTION REMOVE_ACENTOS (pValue IN VARCHAR)
		  RETURN  VARCHAR IS
		ComAcento VARCHAR(35);
		SemAcento VARCHAR(35);
		Saida     VARCHAR(2000);
		BEGIN
		    ComAcento := 'àâêôûãõáéíóúçüñÀÂÊÔÛÃÕÁÉÍÓÚÇÜÑ';
		    SemAcento := 'aaeouaoaeioucunAAEOUAOAEIOUCUN';
		    Saida := '';
		    If Length(pValue) > 0 then
		      For x in 1..Length(pValue)
		      Loop
		        if Instr(ComAcento,Substr(pValue,x,1)) > 0 then
		          Saida := Saida || Substr(SemAcento,(Instr(ComAcento,Substr(pValue,x,1))),1);
		        else
		          Saida := Saida || Substr(pValue,x,1);
		        end if;
		      End Loop;
		    End If;
		    RETURN Saida;
		END;
		";
		if(strlen($sql) >0) {
			$query = mysql_query($sql) or die("<span class='erro'>Erro " . mysql_error() . "informe o adminitrador!</span><a href='proposta.php'>Voltar</a>");
			echo $query;
		}else{
			echo "hein!";
		}
		?>
	</body>
</html>