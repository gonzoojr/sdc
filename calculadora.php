<?
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
if(strlen($_POST['vlr_unidade']) > 0){

	$qtd = $_POST['qtd'];

	$vlr_unidade = $_POST['vlr_unidade'];

	$vlr_total_prod = $qtd * $vlr_unidade;

	

	$percent_icms = number_format($_POST['percent_icms'], 4,'.','') / 100;

	$percent_ipi = number_format($_POST['percent_ipi'], 4,'.','') / 100;

	$percent_st = number_format($_POST['percent_st'], 4,'.','') / 100;

	$vlr_ipi = $vlr_total_prod * $percent_ipi;

	$vlr_ipi = $vlr_ipi;

	$prod_c_ipi = $vlr_total_prod + $vlr_ipi;

	$vlr_icms = $vlr_total_prod * $percent_icms;

	$base_icms_st = $prod_c_ipi * $percent_st + $prod_c_ipi;

	$base_icms_st = $base_icms_st;

	$vlr_icms_st = $base_icms_st * $percent_icms - $vlr_icms;

	$vlr_icms_st = $vlr_icms_st;

	$vlr_nota = $prod_c_ipi + $vlr_icms_st;

	$vlr_nota = number_format($vlr_nota, 2,',','.');
	if(isset($_GET['teste'])){

	echo "%ICMS: " . $percent_icms . "<br>";

	echo "%IPI: " . $percent_ipi . "<br>";

	echo "%ST: " . $percent_st . "<br>";

	echo "Vlr IPI (total * %ipi): " . $vlr_ipi . "<br>";

	echo "Prod c IPI (total + vlr ipi): " . $prod_c_ipi . "<br>";

	echo "Vlr ICMS(total * %icms): " . $vlr_icms . "<br>";

	echo "Base Icms st( prod c ipi * %st + prod c ipi): " . $base_icms_st . "<br>";

	echo "ICMS ST: " . $vlr_icms_st . "<br>";

	echo "Valor Uni: " . $vlr_unidade . "<br>";

	echo "Valor Total Produto(qtd * vlr unidade): " . $vlr_total_prod . "<br>";

	echo "Valor Nota (prod c ipi + vlr icms st): " . $vlr_nota . "<br>";
	}
	
	echo $percent_icms . ";" . $percent_ipi . ";" . $percent_st . ";" .$vlr_nota;//resultado que será enviado!!!!!!!

}else{

	echo "Preencha para calcular";

}

if(isset($_GET['teste'])){

?>

<html>

	<head>

	<script src="http://code.jquery.com/jquery-1.10.2.js"></script>

	<script>

		qtd = document.getElementById("qtd");

		vlr_unidade = document.getElementById("vlr_unidade");

		vlr_tot_prod = document.getElementById("vlr_tot_prod");

		

		$('#vlr_tot_prod').focusout(function() {

			alert("aaa");

		});

		

	</script>

	</head>

	<body>

		<form method="POST" action="">

			<label>qtd</label>

			<input type="text" name="qtd" id="qtd">

			<label>Valor Unitário</label>

			<input type="text" name="vlr_unidade" id="vlr_unidade">

			<label>Valor Total Produto</label>

			<input type="text" name="vlr_tot_prod" id="vlr_tot_prod">

			<label>%ICMS</label>

			<input type="text" name="percent_icms" id="percent_icms">

			<label>%IPI</label>

			<input type="text" name="percent_ipi" id="percent_ipi">

			<label>%ST</label>

			<input type="text" name="percent_st" id="percent_st"><br>

			<label>Valor IPI</label>

			<input type="text" name="vlr_ipi" id="vlr_ipi">

			<label>Produto com IPI</label>

			<input type="text" name="prod_c_ipi" id="prod_c_ipi">

			<label>Valor ICMS</label>

			<input type="text" name="vlr_icms" id="vlr_icms">

			<label>Base ICMS ST</label>

			<input type="text" name="base_icms_st" id="base_icms_st">

			<label>Valor ICMS ST</label>

			<input type="text" name="vlr_icms_st" id="vlr_icms_st"><br>

			<label>Valor Nota</label>

			<input type="text" name="vlr_nota" id="vlr_nota">

			<input type="submit" name="enviar" id="enviar" value="Calcular">



		</form>

	</body>

</html>
<?
}
?>