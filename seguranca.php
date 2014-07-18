<?
/**
* Sistema de segurança com acesso restrito
*
* Usado para restringir o acesso de certas páginas do seu site
*/

//  Configurações do Script
// ==============================
$_SG['conectaServidor'] = true;    // Abre uma conexão com o servidor MySQL?
$_SG['abreSessao'] = true;         // Inicia a sessão com um session_start()?

$_SG['caseSensitive'] = false;     // Usar case-sensitive? Onde 'thiago' é diferente de 'THIAGO'

$_SG['validaSempre'] = true;       // Deseja validar o usuário e a senha a cada carregamento de página?
// Evita que, ao mudar os dados do usuário no banco de dado o mesmo contiue logado.

$_SG['servidor'] = '192.168.10.93';    // Servidor MySQL
$_SG['usuario'] = 'sa';          // Usuário MySQL
$_SG['senha'] = 'w3pepino';                // Senha MySQL
$_SG['banco'] = 'w3sdcsdcsdc2017';            // Banco de dados MySQL

$_SG['paginaLogin'] = 'login.php'; // Página de login

$_SG['tabela'] = 'Usuario_Sistema';       // Nome da tabela onde os usuários são salvos
// ==============================

// ======================================
//   ~ Não edite a partir deste ponto ~
// ======================================

// Verifica se precisa fazer a conexão com o MySQL
if ($_SG['conectaServidor'] == true) {
$_SG['link'] = mssql_connect($_SG['servidor'], $_SG['usuario'], $_SG['senha']) or die("MsSQL: Não foi possível conectar-se ao servidor [".$_SG['servidor']."].");
mssql_select_db($_SG['banco'], $_SG['link']) or die("MsSQL: Não foi possível conectar-se ao banco de dados [".$_SG['banco']."].");
}

// Verifica se precisa iniciar a sessão
if ($_SG['abreSessao'] == true) {
session_start();
}
/**
* Função que valida um usuário e senha
*
* @param string $usuario - O usuário a ser validado
* @param string $senha - A senha a ser validada
*
* @return bool - Se o usuário foi validado ou não (true/false)
*/
function validaUsuario($usuario, $senha) {
	global $_SG;
	
	$cS = ($_SG['caseSensitive']) ? 'BINARY' : '';
	
	// Usa a função addslashes para escapar as aspas
	$nusuario = addslashes($usuario);
	$nsenha = addslashes($senha);

	// Monta uma consulta SQL (query) para procurar um usuário
	$sql = "SELECT usu_login, usu_nome FROM ".$_SG['tabela']." WHERE ".$cS." usu_login = '".$nusuario."' AND ".$cS." usu_senha = '".$nsenha."'";
	
	//echo "teste" . $sql;
	
	$query = mssql_query($sql);
	$resultado = mssql_fetch_assoc($query);
	//echo $sql;
	// Verifica se encontrou algum registro
	if (empty($resultado)) {
		// Nenhum registro foi encontrado => o usuário é inválido
		return false;
		//echo "não encontrei seu user";
	
	} else {
		// O registro foi encontrado => o usuário é valido
		
		// Definimos dois valores na sessão com os dados do usuário
		$_SESSION['usuarioID'] = $resultado['usu_login']; // Pega o valor da coluna 'id do registro encontrado no MySQL
		$_SESSION['usuarioNome'] = $resultado['usu_nome']; // Pega o valor da coluna 'nome' do registro encontrado no MySQL
		
		// Verifica a opção se sempre validar o login
		if ($_SG['validaSempre'] == true) {
		// Definimos dois valores na sessão com os dados do login
		$_SESSION['usuarioLogin'] = $usuario;
		$_SESSION['usuarioSenha'] = $senha;
	}
	
	return true;
	}
}

/**
* Função que protege uma página
*/
function protegePagina() {
global $_SG;

if (!isset($_SESSION['usuarioID']) OR !isset($_SESSION['usuarioNome'])) {
// Não há usuário logado, manda pra página de login
expulsaVisitante();

} else if (!isset($_SESSION['usuarioID']) OR !isset($_SESSION['usuarioNome'])) {
// Há usuário logado, verifica se precisa validar o login novamente
if ($_SG['validaSempre'] == true) {
// Verifica se os dados salvos na sessão batem com os dados do banco de dados
if (!validaUsuario($_SESSION['usuarioLogin'], $_SESSION['usuarioSenha'])) {
// Os dados não batem, manda pra tela de login
expulsaVisitante();

}
}
}
}

/**
* Função para expulsar um visitante
*/
function expulsaVisitante() {
global $_SG;

// Remove as variáveis da sessão (caso elas existam)
unset($_SESSION['usuarioID'], $_SESSION['usuarioNome'], $_SESSION['usuarioLogin'], $_SESSION['usuarioSenha']);

// Manda pra tela de login
header("Location: ".$_SG['paginaLogin']);
}
?>