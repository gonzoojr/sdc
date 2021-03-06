<html>
	<head>
		<meta charset="UTF-8">
		<title>Visualização de Proposta</title>
		<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
		<script type="text/javascript" src="js/simpleAutoComplete.js"></script>
		<script type="text/javascript" src="js/jquery-ui.min.js"></script>

		<link rel="stylesheet" type="text/css" href="css/simpleAutoComplete.css" />
		<link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css" />
		<link rel="stylesheet" type="text/css" href="css/jquery-ui.structure.css" />
		<link rel="stylesheet" type="text/css" href="css/jquery-ui.theme.min.css" />
		<link rel="stylesheet" type="text/css" href="css/proposta.css" />
		<?
		$desc_cont = nl2br("Kit CPU para instalação em Gabinete GEA (SEM BACKPLANE)
		-- Embedded Core 2 Duo E-7400 - 2.8GHz, 3MB de cache com 2 núcleos
		-- Fonte Industrial de alto MTBF 80 plus Bronze com entrada 110~220VCA
		-- Motherboard Industrial Modelo WSB-9454
		Suporte a Windows 2000
		Chipset Intel 945G +ICH7
		(x2) Portas Ethernet 10/100/1000Mbps on board
		Expansão de memória até 4GB
		WDT
		(x4) Portas SATA II 3GB/s
		(x7) Portas USB 2.0 (1x faceplate, 8x onboard pin headers)
		(x1) Porta LPT
		(x2) Portas seriais RS-232
		(x1) Saída de Vídeo VGA
		-- Porta PS2 para teclado e mouse
		-- 4GB de memória DDR2-800 em dois módulos de 2GB dual channel
		-- Hard Disk Drive SATA III 7200RPM com 500GB
		-- Serviço de Instalação do kit no gabinete GEA");
		$idProposta = "13333";
		$empresa = "Fulano de Tal LTDA";
		$nomeContato = "Beltrano da Silva (beltrano.silva@fulanodetaltda.com.br)";
		$dataAtuProposta = "13/06/2014";
		$foneEmpresa = "(11)555-66665";
		?>
	</head>
	<body>
		<div id="clickme">
		  Click here
		</div>
		<img id="book" src="img/add.png" alt="" width="100" height="123">
		<script>
		
		$(document).ready(function() {
			$("#clickme").click(function() {
		        alert("aaa");
		  });
		    $("#addEmpresa").css("opacity", 0.1);
		    $("#addEmpresa").hover(function() {
		        $(this).animate({opacity: 1.0}, 500);
		    }, function() {
		        $(this).animate({opacity: 0.5}, 500);
		    });
		});
		
		$( "#clickme" ).hover(function() {
		  $( "#addEmpresa" ).fadeTo( "slow" , 0.5, function() {
		    alert("aaa");
		  });
		});
		</script>
		<div class="prop_header">
		<img src="img/logo.png" class="logo"><img src="img/bg_top_left.png" class="bg-left"><img src="img/bg_top_right.png" class="bg-right">
		</div>
		<br>
		<table class="borda-arr">
			<tr class="meia">
				<th>Proposta Comercial: <?=$idProposta?></th><th>Versão: <b>b</b> Atualizado em: <?=$dataAtuProposta?></th>
			</tr>
			<tr class="meia">
				<td>
					<?
						if($_GET['teste']==1){
					?>
					<b>Empresa:</b> <?=$nomeEmpresa?><br>
					<b>Contato</b><?=$nomeContato?><br>
					<b>Telefone:</b> <?=$foneEmpresa?>
					<?
					}else{
					?>
					<img src="img/add.png" id="addEmpresa">
					<?	
					}
					?>
				</td>
				<td class="direita">
					<b>Empresa:</b> SDC Engenharia &nbsp;<br>
					<b>Contato</b>Beltrano da Silva (beltrano.silva@fulanodetaltda.com.br) <br>
					<b>Telefone:</b> (11)555-66665
				</td>
			</tr>

		</table>
		Presado(a): Beltrano da Silva<br>
		Segue abaixo escopo de fornecimento e condições comerciais para o fornecimento de produtos do seu interesse.<br>
		<table class="borda-arr">
			<tr>
				<th>Item <img src="img/add.png" height="15px" id="add_item"></th><th>Descrição</th><th>NCM</th><th>Valor Unit</th><th>ICMS %</th><th>IPI %</th><th>ISS %</th><th>Subst. Trib.%</th><th>Qtd</th><th>&nbsp;</th>
			</tr>
			<tr class="comum">
				<td>1</td><td><?=$desc_cont;?></td><td>8471.50.10</td><td>3.299,99</td><td>0</td><td>0</td><td>0</td><td>0</td><td>80</td><td>R$ 263.999,12</td>
			</tr>
		</table><br>
		<table class="borda-arr">
			<tr class="comum">
				<th>- Prazo de Pagamento:</th> <td>- à vista;</td>
			</tr >
			<tr class="comum">
				<th>- Prazo de Entrega:</th> <td>- 45 dias após confirmação do pedido;</td>
			</tr>
			<tr class="comum">
				<th>- Garantia:</th> <td>- Balcão, 12 (doze) meses contra defeitos de manufatura;</td>
			</tr>
			<tr class="comum">	
				<th>- Validade da Proposta:</th> <td>- 05 (cinco) dias</td>
			</tr>
			<tr class="comum">	
				<th>- Preços:</th> <td>- Expressos em Real, fixo durante a validade da Proposta.</td>
			</tr>
			<tr class="comum">	
				<th>- Impostos:</th> <td>- Item1</td>
			</tr>
			<tr class="comum">	
				<th>- Frete e Seguro:</th> <td>- Por conta do cliente</td>
			</tr>
			<tr class="comum">	
				<th>- Política de Cancelamento:</th> <td>- O cliente tem até 24 horas após o aceite da proposta para cancelar o pedido sem multa;
				- Para equipamentos que a SDC possui em prateleira/estoque, multa de 20%;
				- Para equipamentos em processo de importação à partir deste pedido, multa de 40%;
				- Para equipamentos já faturados, a SDC se reserva o direito de não aceitar a devolução, caso a devolução seja aceita, deve ser feita
				em até 30 dias após a data de faturamento, com multa de até 60%.</td>
			</tr>
			<tr class="comum">	
				<th>- Observações:</th> <td>- - -</td>
			</tr>
		</table>
		<?php

		?>
	</body>
</html>