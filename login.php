<html>
	<head>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
	</head>
	<style>
	body {
		background: #eee !important;	
	}
	
	.wrapper {	
		margin-top: 80px;
	  margin-bottom: 80px;
	}
	
	.form-signin {
	  max-width: 380px;
	  padding: 15px 35px 45px;
	  margin: 0 auto;
	  background-color: #fff;
	  border: 1px solid rgba(0,0,0,0.1);  
	
	  .form-signin-heading,
		.checkbox {
		  margin-bottom: 30px;
		}
	
		.checkbox {
		  font-weight: normal;
		}
	
		.form-control {
		  position: relative;
		  font-size: 16px;
		  height: auto;
		  padding: 10px;
			@include box-sizing(border-box);
	
			&:focus {
			  z-index: 2;
			}
		}
	
		input[type="text"] {
		  margin-bottom: -1px;
		  border-bottom-left-radius: 0;
		  border-bottom-right-radius: 0;
		}
	
		input[type="password"] {
		  margin-bottom: 20px;
		  border-top-left-radius: 0;
		  border-top-right-radius: 0;
		}
	}

	</style>
	<body>
		<div class="wrapper">
			<form class="form-signin" method="post" action="valida.php">
				<table width="100%">
					<tr>
						<td colspan="2" align="center">
							<img src="img/logo.png" class="">
						</td>
					</tr>
				<!--<h2 class="form-signin-heading">Efetue seu login</h2>-->
					<tr>
						<td>
							<span class="glyphicon glyphicon-user"></span>
						</td>
						<td>
							<input type="text" class="form-control" name="usuario" placeholder="Usuário" required="true" autofocus="" />
						</td>
					</tr>
					<tr>
						<td>
							<span class="glyphicon glyphicon-lock"></span>
						</td>
						<td>
							<input type="password" class="form-control" name="senha" placeholder="Password" required=""/>
						</td>
					</tr>
				</table><br>
				<!--<label class="checkbox">
				<input type="checkbox" value="remember-me" id="rememberMe" name="rememberMe"> Remember me
				</label>-->
				<!--<button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>-->  
				<input type="submit" class="btn btn-lg btn-primary btn-block" value="Entrar" /> 
			</form>
		</div>
		<!--##################################################-->
		<form style="display: none;" method="post" action="valida.php">
			<label>Usuário</label>
			<input type="text" name="usuario" maxlength="50" />
			<label>Senha</label>
			<input type="password" name="senha" maxlength="50" />
			<input type="submit" class="btn btn-lg btn-primary btn-block" value="Entrar" />
		</form>
	</body>
</html>