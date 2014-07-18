<?php
/**
 * @author Wellington Ribeiro
 * @version 1.0
 * @since 2010-02-09
 */

header('Content-type: text/html; charset=UTF-8');

$hostname = '192.168.10.93';
$username = 'sa';
$password = 'w3pepino';
$dbname = 'w3sdcsdcsdc2017';

mssql_connect( $hostname, $username, $password ) or die ( 'Erro ao tentar conectar ao banco de dados.' );
mssql_select_db( $dbname );

if( isset( $_REQUEST['query'] ) && $_REQUEST['query'] != "" )
{
    $q = mssql_real_escape_string( $_REQUEST['query'] );

    if( isset( $_REQUEST['identifier'] ) && $_REQUEST['identifier'] == "estado")
    {
	//$sql = "SELECT * FROM tb_estados where locate('$q',nome) > 0 order by locate('$q',nome) limit 10";
	$sql = "SELECT top 30 prd_cod,prd_desc,preco_Usuario,preco_Integrador,categ_prod,prd_cor,prd_tamanho,oo_moeda_de_preco FROM produto WHERE prd_desc like '%" . $q . "%';";
	$r = mssql_query( $sql );
	if ( $r )
	{
	    echo '<ul>'."\n";
	    while( $l = mssql_fetch_array( $r ) )
	    {
		$p = $l['prd_desc'];
		$p = preg_replace('/(' . $q . ')/i', '<span style="font-weight:bold;">$1</span>', $p);
		echo "\t".'<li id="autocomplete_'.$l['prd_cod'].'" rel="'.$l['prd_cod'].'_' . $l['prd_desc'] . '">'. utf8_encode( $p ) .'</li>'."\n";
	    }
	    echo '</ul>';
	}
    }

    if( isset( $_REQUEST['identifier'] ) && $_REQUEST['identifier'] == "cidade")
    {
	$sql = isset( $_REQUEST['extraParam'] ) ? " and estado = " . mysql_real_escape_string( $_REQUEST['extraParam'] ) . " " : "";
	$sql = "SELECT * FROM tb_cidades where locate('$q',nome) > 0 $sql order by locate('$q',nome) limit 10";
	$r = mysql_query( $sql );
	if ( count( $r ) > 0 )
	{
	    echo '<ul>'."\n";
	    while( $l = mysql_fetch_array( $r ) )
	    {
		$p = $l['nome'];
		$p = preg_replace('/(' . $q . ')/i', '<span style="font-weight:bold;">$1</span>', $p);
		echo "\t".'<li id="autocomplete_'.$l['id'].'" rel="'.$l['id'].'_' . $l['uf'] . '">'. utf8_encode( $p ) .'</li>'."\n";
	    }
	    echo '</ul>';
	}
    }
}

?>