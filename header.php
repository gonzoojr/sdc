		<div class="prop_header">
			<img src="img/logo.png" class="logo"><img src="img/bg_top_left.png" class="bg-left"><img src="img/bg_top_right.png" class="bg-right">
			<div id="user" style="position: absolute; top: 25px; right: 0px; z-index: 100;">
				<?
				if($_GET['login']=="sair"){
					expulsaVisitante();
				}
				?>
				Olá <b><? $infUser = limitaPalavras($_SESSION['usuarioNome'], 2); echo $infUser;?></b><a href="?login=sair"> sair</a>
			</div>
		</div>
		<br>
		<nav class="navbar navbar-inverse" role="navigation">
			<a href="#">Inicio</a>
  			<a href="#">Cadastrar Empresa</a>
  			<a href="#">Editar Empresa</a>
  			<a href="#">Listar Propostas</a>
  			<a href="proposta.php?acao=cad">Cadastrar Proposta</a>
		</nav>