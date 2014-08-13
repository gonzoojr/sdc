<html>
	<head>
		<title>Visualização de Proposta</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="Content-Language" content="pt-BR en">
		<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
		<script type="text/javascript" src="js/simpleAutoComplete.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="js/funcoes.js"></script>
		
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
		<link rel="stylesheet" type="text/css" href="css/simpleAutoComplete.css" />
		<link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css" />
		<link rel="stylesheet" type="text/css" href="css/jquery-ui.structure.css" />
		<link rel="stylesheet" type="text/css" href="css/jquery-ui.theme.min.css" />
		<link rel="stylesheet" type="text/css" href="css/proposta.css" />
		
		<?
		include "funcoes.php";
		include "consultas.php";
		include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
		
		protegePagina(); // Chama a função que protege a página
		$desc_cont = nl2br("Kit CPU para instalação em Gabinete GEA (SEM BACKPLANE)
		-- Embedded Core 2 Duo E-7400 - 2.8GHz, 3MB de cache com 2 núcleos
		-- Fonte Industrial de alto MTBF 80 plus Bronze com entrada 110~220VCA
		-- Motherboard Industrial Modelo WSB-9454
		-- Porta PS2 para teclado e mouse
		-- 4GB de memória DDR2-800 em dois módulos de 2GB dual channel
		-- Hard Disk Drive SATA III 7200RPM com 500GB
		-- Serviço de Instalação do kit no gabinete GEA");
		$empresa = "Fulano de Tal LTDA";
		$nomeContato = "Beltrano da Silva (beltrano.silva@fulanodetaltda.com.br)";
		$dataAtuProposta = "13/06/2014";
		$foneEmpresa = "(11)5633-2855";
		
		if($_GET['acao']=="cad" || isset($_GET['id'])){
				$query_ultimo_reg = "SELECT idProposta FROM `tbl_proposta` order by idGeral desc";
				$query = consultas("mysql", $query_ultimo_reg);
				$result = mysql_fetch_assoc($query);
				if(!isset($_GET['id'])){
					$_1 = 1;
				}else{
					$_1 = 0;
				}
				$id_proposta = intval($result['idProposta']) + $_1;
				//echo 'Ultima proposta' . $id_proposta;
				######################################
				if(!isset($_GET['id'])){
					$insert = "
						INSERT INTO  `sis_proposta`.`tbl_proposta` (
						`idProposta`, `idGerente`, `dataCadastro`
						)
						VALUES ('". $id_proposta ."', '" . $_SESSION['usuarioID'] . "', '". date("Y-m-d H:i:s") ."'
						);
					";
					$query = consultas("mysql", $insert);
					$camposFechado = "idGeral, idProposta, idEmpresa, idContato, dataCadastro, tipoUsuario, idGerente";
				######################################
				}else{
					$whereMaroto = "WHERE idGeral=".$_GET['id'];
					$camposFechado = "`tbl_proposta`.idGeral, `tbl_proposta`.idProposta, `tbl_proposta`.idEmpresa, `tbl_proposta`.idContato, `tbl_proposta`.dataCadastro, `tbl_proposta`.tipoUsuario, `tbl_proposta`.idGerente, `tbl_empresa`.Estado, `tbl_empresa`.NomeEmpresa, `tbl_contato`.NomeContato, `tbl_contato`.Sobrenome, `tbl_contato`.EmailContato, `tbl_contato`.TelefoneFixoContato";
					$innerJoin = " INNER JOIN `tbl_empresa` ON tbl_empresa.idEmpresa = `tbl_proposta`.idEmpresa
								INNER JOIN `tbl_contato` ON `tbl_contato`.idContato = `tbl_proposta`.idContato ";
				}
			$query_id_geral = "SELECT ".$camposFechado." FROM `tbl_proposta` ".$innerJoin." ".$whereMaroto." order by idGeral desc";
			$query = consultas("mysql", $query_id_geral);
			$result = mysql_fetch_assoc($query);
			$idGeral = $result['idGeral'];
			$idProposta = $result['idProposta'];
			$id_proposta = $idProposta;
			$idEmpresa = $result['idEmpresa'];
			$idContato = $result['idContato'];
			$dataCadastro = $result['dataCadastro'];
			$tipoUsuario = $result['tipoUsuario'];
			$idGerente = $result['idGerente'];
			if(isset($_GET['id'])){
				$UFechado = $result['Estado'];
				$nomeEmpresaFechado = mb_convert_encoding($result['NomeEmpresa'],'UTF-8',mb_detect_encoding($result['NomeEmpresa'],"ISO-8859-1, UTF-8, ASCII"));
				$nomeContatoFechado = $result['NomeContato'];
				$sobreNomeFechado = $result['Sobrenome'];
				$emailContatoFechado = $result['EmailContato'];
				$foneContatoFechado = $result['TelefoneFixoContato']; 
			}
			
			
			//echo $query;
			mysql_close();
		}else{
			
		}
		?>
		
		<script>
		
		$(document).ready(function() {
			$("#addEmpresa").css("opacity", 0.5);
		    $("#addEmpresa").hover(function() {
		        $(this).animate({opacity: 1.0}, 500);
		    }, function() {
		        $(this).animate({opacity: 0.5}, 500);
		    });
		    
		});
		$(function() {
			$( "#subitens" ).dialog({
				autoOpen: false,
				width: 450,
				show: 'slideDown',
				hide: 'slideUp',
			});
			//$('#subitens').draggable();
		});
		function janela(titulo){
			$('#subitens').dialog('option', 'title', titulo);
			//alert(titulo);
			zoia();
		}
       function zoia() {
	           $("#subitens").dialog("open");
	   }
		</script>
	</head>
	<body>
		<?
		include "header.php";
		?>
		<div id="subitens" title="Itens da Proposta">
		</div>
		<?
		if(isset($_GET['id'])){
		?>
		<div width="100%" height="30px" style="position: relative;left:0px;border: solid #000 0px;">&nbsp;<a href="print.php?id=<?=$idGeral?>&numProp=<?=$id_proposta?>" target="_blank"><span class="glyphicon glyphicon-print" style="position: absolute; right: 50px;{height: 50px !important;}"></span></a></div>
		<?
		}
		?>
		<table class="borda-arr">
			<tr class="meia">
				<th>
					Proposta Comercial: 
					<?php if($_GET['acao']=="cad" || isset($_GET['id'])) {
						echo $id_proposta . "<input type='hidden' value='".$id_proposta."' id='idProposta'> 
											<input type='hidden' value='".$idGeral."' id='idGeral'> 
											<input type='hidden' value='".$dolar."' id='dolarDia'>
											<input type='hidden' value='".$UFechado."' id='idUF'>
											<input type='hidden' value='".$tipoUsuario."' id='tipoUsuarioConsulta'>";
					}
					?>
					<span id="editEmpresa" style="position: absolute;">
						<?
						if(isset($_GET['id'])){
						?>
						<img src='img/edit.png' class='editEmpresa' onclick="altContDialog('formEmp','#subitens');janela('Busca de Empresa');">
						<?	
						}
						?>
					</span>
				</th>
				<th>
					Versão: <b>b</b> Atualizado em: <?=$dataAtuProposta?>
				</th>
			</tr>
			<tr class="meia">
				<td id="empresa">
					<?
					if($_GET['acao']=="cad"){
					?>
					<div style="text-align: center;">
					<img src="img/add.png" id="addEmpresa" onclick='altContDialog("formEmp","#subitens");janela("Busca de Empresa");'><br>
					Adicionar Empresa
					</div>
					<?	
					}elseif(isset($_GET['id'])){
						$UFechado = $result['Estado'];
				$nomeContatoFechado = mb_convert_encoding($result['NomeContato'],'UTF-8',mb_detect_encoding($result['NomeContato'],"ISO-8859-1, UTF-8, ASCII"));
				$sobreNomeFechado = mb_convert_encoding($result['Sobrenome'],'UTF-8',mb_detect_encoding($result['Sobrenome'],"ISO-8859-1, UTF-8, ASCII"));
				$emailContatoFechado = $result['EmailContato'];
				$foneContatoFechado = $result['TelefoneFixoContato']; 
					?>
					<b>Empresa: </b><?=$nomeEmpresaFechado;?><br>
					<b>Contato: </b><?=$nomeContatoFechado;?> <?=$sobreNomeFechado;?>(<?=$emailContatoFechado;?>)<br>
					<b>Telefone: </b><?=$foneContatoFechado;?>
					<?	
					}
					?>
				</td>
				<td class="direita">
					<b>Empresa: </b> SDC Engenharia &nbsp;<br>
					<b>Contato: </b><?=$infUser;?> (beltrano.silva@fulanodetaltda.com.br) <br>
					<b>Telefone:</b> (11)5633-2855
				</td>
			</tr>

		</table>
		Prezado(a): <?=$nomeContatoFechado;?> <?=$sobreNomeFechado;?><br>
		Segue abaixo escopo de fornecimento e condições comerciais para o fornecimento de produtos do seu interesse.<br>
		<table id="listaItens" class="borda-arr">
			<tr>
				<th width="70px">Item <img src="img/add.png" height="15px" onclick='altContDialog("formProd","#subitens");janela("Buscar Produto");' id="add_item"></th><th>Descrição</th><th>NCM</th><th>Valor Unit</th><th>ICMS %</th><th>IPI %</th><th>ISS %</th><th>Subst. Trib.%</th><th>Qtd</th><th>&nbsp;</th>
			</tr>
		
		<?
		if(isset($_GET['id'])){
			$query_item = "SELECT * FROM `tbl_item_proposta` WHERE idGeral = ".$_GET['id']." order by posItem asc";
			$queryItem = consultas("mysql", $query_item);
			while($result_item = mysql_fetch_assoc($queryItem)){

			$posicao_item = $result_item['posItem'];
			$idItem = $result_item['idItem'];
			$descricao_item = $result_item['descricao']; 
			$Ncm_item = $result_item['ncm'];
			//$vlrUnit_item = $result_item['vlrUnit'];
			$vlrUnit_item = $result_item['vlrUnit'];
			$icms_item = $result_item['icms'];
			$ipi_item = $result_item['ipi'];
			$iss_item = $result_item['iss'];
			$st_item = $result_item['st'];
			$qtd_item = $result_item['qtd'];
			$total_item = ($qtd_item * $vlrUnit_item) + $icms_item + $ipi_item + $iss_item + $st_item;
			$total_proposta += $total_item;
			
			
			//CONVERTE CARACTERES DO BANCO QUE SÃO EXIBIDOS ERRADO
			$descricaoAD = mb_convert_encoding($descricao_item,'UTF-8',mb_detect_encoding($descricao_item,"ISO-8859-1, UTF-8, ASCII")); 
			
			$linha = '<tr class="comum" id="linha_'.$posicao_item.'">'
					.'<td align="right">'.$posicao_item.'
					<img src=\'img/edit.png\' class=\'editEmpresa\' onclick="editarItem(\''.$posicao_item.'\',\''.$_GET['id'].'\');janela(\'Edição de Produto\');"><img src=\'img/remove.png\' onclick="rmvLinhaItem('.$posicao_item.','.$_GET['id'].');" class=\'editEmpresa\'></td>'
					.'<td>'.nl2br($descricaoAD).'</td>'
					.'<td>'.$Ncm_item.'</td>'
					.'<td>'.number_format($vlrUnit_item, 2, "," , ".").'</td>'
					.'<td>'.number_format($icms_item, 2, "," , ".").'</td>'
					.'<td>'.number_format($ipi_item, 2, "," , ".").'</td>'
					.'<td>'.number_format($iss_item, 2, "," , ".").'</td>'
					.'<td>'.number_format($st_item, 2, "," , ".").'</td>'
					.'<td>'.$qtd_item.'</td>'
					.'<td>R$ '.number_format($total_item, 2, "," , ".").'</td>'
				.'</tr>';
			echo $linha;
			}
			$total_proposta = number_format($total_proposta, 2, "," , ".");
			echo '<tr class="total" id="total">'
					.'<td align="center">&nbsp;</td>'
					.'<td>&nbsp;</td>'
					.'<td>&nbsp;</td>'
					.'<td>&nbsp;</td>'
					.'<td>&nbsp;</td>'
					.'<td>&nbsp;</td>'
					.'<td>&nbsp;</td>'
					.'<td style="border: 1px solid #dadada;vertical-align:text-top;text-align: right;" colspan=2>Valor Total</td>'
					.'<td style="border: 1px solid #dadada;background:#c9e3f6;vertical-align:text-top;text-align: left;"><b>R$ '.$total_proposta.'</b></td>'
				.'</tr>';
		}
		?>
		
			<!--<tr class="comum">
				<td>1</td><td><?=$desc_cont;?></td><td>8471.50.10</td><td>3.299,99</td><td>0</td><td>0</td><td>0</td><td>0</td><td>80</td><td>R$ 263.999,12</td>
			</tr>-->
		</table><br>
		
		<table class="borda-arr">
			<tr class="comum">
				<td style="text-align: center;"><b>CONDIÇÕES COMERCIAIS</b></td>
			</tr >
		</table>
		<br>
		<table class="borda-arr">
			<tr class="comum">
				<th>Prazo de Pagamento:<img src='img/edit.png' class='editEmpresa' onclick="altContDialog('formPrazoPgto','#subitens');janela('Detalhes da Proposta');"></th> <td id="prazoPgto">- à vista;</td>
			</tr >
			<tr class="comum">
				<th>Prazo de Entrega:</th> <td id="prazoEntrega">- 45 dias após confirmação do pedido;</td>
			</tr>
			<tr class="comum">
				<th>Garantia:</th> <td id="garantia">- Balcão, 12 (doze) meses contra defeitos de manufatura;</td>
			</tr>
			<tr class="comum">	
				<th>Validade da Proposta:</th> <td id="validadeProposta">- 05 (cinco) dias</td>
			</tr>
			<tr class="comum">	
				<th>Preços:</th> <td id="precos">- Expressos em Real, fixo durante a validade da Proposta.</td>
			</tr>
			<tr class="comum">	
				<th>Impostos:</th> <td id="impostos">- Item1</td>
			</tr>
			<tr class="comum">	
				<th>Frete e Seguro:</th> <td id="freteSeguro">- Por conta do cliente</td>
			</tr>
			<tr class="comum">	
				<th>Política de Cancelamento:</th> <td id="politicaCancel">- O cliente tem até 24 horas após o aceite da proposta para cancelar o pedido sem multa;
				- Para equipamentos que a SDC possui em prateleira/estoque, multa de 20%;
				- Para equipamentos em processo de importação à partir deste pedido, multa de 40%;
				- Para equipamentos já faturados, a SDC se reserva o direito de não aceitar a devolução, caso a devolução seja aceita, deve ser feita
				em até 30 dias após a data de faturamento, com multa de até 60%.</td>
			</tr>
			<tr class="comum">	
				<th>- Observações:</th> <td id="obs">- - -</td>
			</tr>
		</table>
		<?php

		?>
	</body>
</html>