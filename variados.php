<?
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
if(isset($_POST['vlr_unidade']) && $_GET['teste']==""){

	$qtd = $_POST['qtd'];
	$vlr_unidade = str_replace(".", "", $_POST['vlr_unidade']);
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
	
	//echo $percent_icms . ";" . $percent_ipi . ";" . $percent_st . ";" .$vlr_nota;//resultado que será enviado!!!!!!!

}elseif(isset($_POST['vlr_unidade']) && 
		isset($_POST['percent_icms']) && 
		isset($_POST['percent_ipi'])){
	$qtd = $_POST['qtd'];
	$vlr_unidade = $_POST['vlr_unidade'];
	$vlr_total_prod = $qtd * $vlr_unidade;

	echo "formula basica<br><br>";
	
	$percent_icms = (100 - $_POST['percent_icms']) / 100;
	$percent_ipi = number_format($_POST['percent_ipi'], 4,'.','') / 100;
	
	if(isset($_GET['usuario']) && $_GET['usuario']==1){
		$percent_icms = $_POST['percent_icms'] / 100;
		$icms = number_format(($vlr_total_prod /(1-($percent_icms*(1+$percent_ipi)))* (1+$percent_ipi) * $percent_icms), 2,'.','');
		echo "ICMS: " . $icms . " = ($vlr_total_prod /(1-($percent_icms*(1+$percent_ipi)))* (1+$percent_ipi) * $percent_icms)<br>";
	}else{
		$icms = number_format(($vlr_total_prod / $percent_icms) - $vlr_total_prod, 2,'.','');
		echo "ICMS: " . $icms . " = (".$vlr_total_prod." / ".$percent_icms.") - ".$vlr_total_prod."<br>";
	}	
	
	$vlr_unidade_c_icms = number_format($vlr_total_prod + $icms, 2,'.','');
	echo "Produto c/ ICMS: " . $vlr_unidade_c_icms . "<br>";
	
	$ipi = number_format($vlr_unidade_c_icms * $percent_ipi, 2,'.','');
	echo "IPI: " . $ipi . "<br>";
	
	$total_item =  $vlr_unidade_c_icms + $ipi;
	echo "TOTAL basico: " . $total_item . "<br>";
	
	#CÁLCULO COM ST	
	if(strlen($_POST['percent_st'])>0){
		$percent_st = number_format($_POST['percent_st'], 4,'.','') / 100;
		
		$percent_icms_st = number_format($_POST['percent_icms_st'] / 100, 2,'.','');
		
		$base_icms_st = number_format(($total_item * $percent_st) + $total_item, 2,'.','');
		echo "Base ICMS c ST: " . $base_icms_st . "<br>";
		
		$icms_st = number_format(($base_icms_st * $percent_icms_st) - $icms, 2,'.',''); 
		echo "ICMS c ST: " . $icms_st . "<br>";
		
		$total_item_c_icms_st =  number_format($total_item + $icms_st, 2,'.','');
		echo "Total com ST: " . $total_item_c_icms_st;
		
		$basica = $vlr_total_prod + $icms + $ipi;
	}
	if(isset($_GET['usuario'])){
		if($_GET['usuario']==1){
			echo "USU";
		}
	}	
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

			<label>%ICMS_ST</label>

			<input type="text" name="percent_icms_st" id="percent_icms_st"><br>

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