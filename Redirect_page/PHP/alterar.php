<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>Avaliação PHP</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">
	<link rel="stylesheet" href="./../CSS/formulario.css">
	<link rel="icon" type="image/png" href="./../Images/icon.png" />
	<script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.0.0.min.js" type="text/javascript"></script>
	<script language="javascript">
		// mascara para decimal do campo valor
		function MascaraMoeda(objTextBox, SeparadorMilesimo, SeparadorDecimal, e) {
			var sep = 0;
			var key = '';
			var i = j = 0;
			var len = len2 = 0;
			var strCheck = '0123456789';
			var aux = aux2 = '';
			var whichCode = (window.Event) ? e.which : e.keyCode;
			if (whichCode == 13) return true;
			key = String.fromCharCode(whichCode); // Valor para o código da Chave
			if (strCheck.indexOf(key) == -1) return false; // Chave inválida
			len = objTextBox.value.length;
			for (i = 0; i < len; i++)
				if ((objTextBox.value.charAt(i) != '0') && (objTextBox.value.charAt(i) != SeparadorDecimal)) break;
			aux = '';
			for (; i < len; i++)
				if (strCheck.indexOf(objTextBox.value.charAt(i)) != -1) aux += objTextBox.value.charAt(i);
			aux += key;
			len = aux.length;
			if (len == 0) objTextBox.value = '';
			if (len == 1) objTextBox.value = '0' + SeparadorDecimal + '0' + aux;
			if (len == 2) objTextBox.value = '0' + SeparadorDecimal + aux;
			if (len > 2) {
				aux2 = '';
				for (j = 0, i = len - 3; i >= 0; i--) {
					if (j == 3) {
						aux2 += SeparadorMilesimo;
						j = 0;
					}
					aux2 += aux.charAt(i);
					j++;
				}
				objTextBox.value = ''.substr(len - 2, len - 0);
				len2 = aux2.length;
				for (i = len2 - 1; i >= 0; i--)
					objTextBox.value += aux2.charAt(i);
				objTextBox.value += SeparadorDecimal + aux.substr(len - 2, len - 0);
			}
			return false;
		}
	</script>
</head>

<body>
	<?php
	require "conectar.php";

	$id = @$_REQUEST["id"];

	$search = "SELECT * FROM (preco INNER JOIN produtos ON produtos.idprod = preco.idpreco) where produtos.idprod='$id'";
	$result = mysqli_query($con, $search);

	function limpar_texto($str)
	{
		return preg_replace("/[^0-9]/", "", $str);
	}

	if (mysqli_affected_rows($con) > 0) {
		$registro = mysqli_fetch_assoc($result);

		@$nome = utf8_encode($registro["nome"]);
		@$preco = number_format(substr_replace(limpar_texto($registro["preco"]), ',', -2, 0), 2, ",", ".");
	}
	?>
	<div class="container">
		<div class="formulario">
			<!-- formulario para inserção de dados nas tabelas de produtos e precos -->
			<form action="./editar.php" method="POST" class="col s12">
				<?php echo "
<legend id='font'>Atualização de ficha</legend>
<fieldset>
<input type='hidden' name='id' value='$id' required>
<label>Nome:
<input type='text' maxlength='40' name='nome' value='$nome' placeholder='Digite o nome do produto' required autofocus>
</label>
<label>Preço:
<input type='text' placeholder='Insira o preço do produto' value='R$ $preco' name='preco' onkeypress='return(MascaraMoeda(this,'.',',',event))' maxlength='14' required>
</label>
                    <button type='submit' class='submit-btn'>Atualizar</button>
                </fieldset>
		  "; ?>
			</form>
		</div>
	</div>
</body>

</html>