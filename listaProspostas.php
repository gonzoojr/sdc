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
		?>
	</head>
	<body>
		<?
		include "header.php";
		$camposFechado = "`tbl_proposta`.idGeral, `tbl_proposta`.idProposta, `tbl_proposta`.idEmpresa, `tbl_proposta`.idContato, `tbl_proposta`.dataCadastro, `tbl_proposta`.tipoUsuario, `tbl_proposta`.idGerente, `tbl_empresa`.Estado, `tbl_empresa`.NomeEmpresa, `tbl_contato`.NomeContato, `tbl_contato`.Sobrenome, `tbl_contato`.EmailContato, `tbl_contato`.TelefoneFixoContato";
		$innerJoin = " INNER JOIN `tbl_empresa` ON tbl_empresa.idEmpresa = `tbl_proposta`.idEmpresa
					INNER JOIN `tbl_contato` ON `tbl_contato`.idContato = `tbl_proposta`.idContato ";
		
		$query = "SELECT ".$camposFechado." FROM `tbl_proposta` ".$innerJoin." ".$whereMaroto." order by idGeral desc LIMIT 30";
			$queryProposta = consultas("mysql", $query);
			echo "<table class='table table-striped'>";
			echo "<tr><th>ID</th><th>Empresa</th><th>Contato</th><th>UF</th><th>Ver</th></tr>";
			while($resultPropostas = mysql_fetch_assoc($queryProposta)){
			$idGeral = $resultPropostas['idGeral'];
			$idProposta = $resultPropostas['idProposta'];
			$idEmpresa = $resultPropostas['idEmpresa'];
			$idContato = $resultPropostas['idContato'];
			$dataCadastro = $resultPropostas['dataCadastro'];
			$tipoUsuario = $resultPropostas['tipoUsuario'];
			$idGerente = $resultPropostas['idGerente'];
			$UFechado = $resultPropostas['Estado'];
			$nomeEmpresaFechado = mb_convert_encoding($resultPropostas['NomeEmpresa'],'UTF-8',mb_detect_encoding($resultPropostas['NomeEmpresa'],"ISO-8859-1, UTF-8, ASCII"));
			$nomeContatoFechado = $resultPropostas['NomeContato'];
			$sobreNomeFechado = $resultPropostas['Sobrenome'];
			$emailContatoFechado = $resultPropostas['EmailContato'];
			$foneContatoFechado = $resultPropostas['TelefoneFixoContato']; 
			echo '<tr><td>'.$idProposta.'</td><td>'.$nomeEmpresaFechado.'</td><td>'.$nomeContatoFechado.'</td><td>'.$UFechado.'</td><td align="center"><a href="proposta.php?id='.$idGeral.'"><span class="glyphicon glyphicon-pencil"></span></td></tr>';
			}
			echo "</table>";
		?>
		
	</body>
</html>