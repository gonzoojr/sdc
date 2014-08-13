		<div class="prop_header">
			<?
			$server = $_SERVER['SERVER_NAME']; 
			$endereco = $_SERVER ['REQUEST_URI'];
			$impressao = strripos($endereco, "print_prop.php");
			
			if($impressao==true){
				echo '<img src="img/bg_head_print.png" width="100%" class="bg-left">';
			}else{
			?>
			<img src="img/logo.png" class="logo"><img src="img/bg_top_left.png" class="bg-left"><img src="img/bg_top_right.png" class="bg-right">
			<?
			}
			?>
			<div id="user" style="position: absolute; top: 25px; right: 0px; z-index: 100;">
				<?
				header('Content-Type: text/html; charset=UTF-8');
				if($_GET['login']=="sair"){
					expulsaVisitante();
				}
				
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
				
				if($impressao==true){
					//echo $endereco;
				}else{
					//echo "Não Imprimi";	
				?>
				Oi <b><? $infUser = limitaPalavras(mb_convert_encoding($_SESSION['usuarioNome'],'UTF-8',mb_detect_encoding($_SESSION['usuarioNome'],"ISO-8859-1, UTF-8, ASCII")), 2); echo $infUser;?>&nbsp;&nbsp;</b>
				<?
				}
				?>
			</div>
		</div>
		<br>
		<script>
		function sobreMenu(id){
			$(id).hover(function () {
	            $(this).addClass('active');
	        }, function () {
	            $(this).removeClass('active');
	        });	
		}
		
		</script>
		<?
		$impressao = strripos($endereco, "print_prop.php");
		if($impressao==false){
			//echo $endereco;
		?>
		<nav role="navigation" class="navbar navbar-default">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		        <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
		            <span class="sr-only">Toggle navigation</span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		        </button>
		        <a href="#" class="navbar-brand">Home</a>
		    </div>
		    <!-- Collection of nav links and other content for toggling -->
		    <div id="navbarCollapse" class="collapse navbar-collapse">
		        <ul class="nav navbar-nav">
		            <li onmouseover="sobreMenu(this);"><a href="#">Cadastrar Empresa</a></li>
		            <li onmouseover="sobreMenu(this);"><a href="#">Editar Empresa</a></li>
		            <li onmouseover="sobreMenu(this);"><a href="listaProspostas.php">Listar Propostas</a></li>
		            <li onmouseover="sobreMenu(this);"><a href="proposta.php?acao=cad">Cadastrar Proposta</a></li>
		        </ul>
		        <ul class="nav navbar-nav navbar-right">
		        	<li><a href="#"><span class="glyphicon glyphicon-usd"><?=$dolar;?></span></a></li>
		            <li><a href="?login=sair">Sair<span class="glyphicon glyphicon-log-out"></span></a></li>
		        </ul>
		    </div>
		</nav>
		<?
		}else{
			//echo "Não Imprimi";	
		}
		?>