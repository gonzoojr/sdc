<?
/*ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);*/
if(isset($_POST['valor']) && 
		isset($_POST['percent_icms']) && 
		isset($_POST['percent_ipi'])){
	$qtd = $_POST['qtd'];
	$vlr_unidade = str_replace(".", "", $_POST['valor']);
	$vlr_unidade = str_replace(",", ".", $vlr_unidade);
	
	$dolar = $_POST['dolar'];
	
	$vlr_unidade = $vlr_unidade * $dolar; 

	$vlr_total_prod = $qtd * $vlr_unidade;

	//echo "formula basica<br><br>";
	
	$percent_icms = (100 - $_POST['percent_icms']) / 100;
	$percent_ipi = number_format($_POST['percent_ipi'], 4,'.','') / 100;
	
	if(isset($_POST['tipoUsuario']) && $_POST['tipoUsuario']=="final"){
		$percent_icms = $_POST['percent_icms'] / 100;
		$icms = number_format(($vlr_total_prod /(1-($percent_icms*(1+$percent_ipi)))* (1+$percent_ipi) * $percent_icms), 2,'.','');
		//echo "ICMS: " . $icms . " = ($vlr_total_prod /(1-($percent_icms*(1+$percent_ipi)))* (1+$percent_ipi) * $percent_icms)<br>";
	}else{
		$icms = number_format(($vlr_total_prod / $percent_icms) - $vlr_total_prod, 2,'.','');
		//echo "ICMS: " . $icms . " = (".$vlr_total_prod." / ".$percent_icms.") - ".$vlr_total_prod."<br>";
	}	
	
	$vlr_unidade_c_icms = number_format($vlr_total_prod + $icms, 2,'.','');
	//echo "Produto c/ ICMS: " . $vlr_unidade_c_icms . "<br>";
	
	$ipi = number_format($vlr_unidade_c_icms * $percent_ipi, 2,'.','');
	//echo "IPI: " . $ipi . "<br>";
	
	$total_item =  $vlr_unidade_c_icms + $ipi;
	//echo "TOTAL basico: " . $total_item . "<br>";
	
	#CÁLCULO COM ST	
	if(strlen($_POST['percent_st'])>0 && (isset($_POST['calc_st']) && $_POST['calc_st']=="sim")){
		$percent_st = number_format($_POST['percent_st'], 4,'.','') / 100;
		
		$percent_icms_st = number_format($_POST['percent_icms_st'] / 100, 2,'.','');
		
		$base_icms_st = number_format(($total_item * $percent_st) + $total_item, 2,'.','');
		//echo "Base ICMS c ST: " . $base_icms_st . "<br>";
		
		$icms_st = number_format(($base_icms_st * $percent_icms_st) - $icms, 2,'.',''); 
		//echo "ICMS c ST: " . $icms_st . "<br>";
		
		$total_item_c_icms_st =  number_format($total_item + $icms_st, 2,'.','');
		//echo "Total com ST: " . $total_item_c_icms_st;
		
		$basica = $vlr_total_prod + $icms + $ipi;
	}
	######ORIGINAL##########
	if(isset($total_item_c_icms_st)){
		$vlr_nota = $total_item_c_icms_st;
	}else{
		$vlr_nota = $total_item;
	}
	if(!isset($icms_st)){
		$icms_st = 0;
	}
	echo $icms . ";" . $ipi . ";" . $icms_st . ";" .$vlr_nota . ";" . 0;//resultado que será enviado!!!!!!!
}else{
	echo "Ocorreram erros ao Calcular, consulte o administrador";
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

			<input type="text" name="valor" id="valor">
			<input type="checkbox" name="calc_st" id="calc_st" value="sim">
			
			dola
			<input type="text" name="dolar" id="dolar">

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