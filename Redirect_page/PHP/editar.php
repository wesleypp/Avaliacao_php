<html>

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
   <link rel="icon" type="image/png" href="./../../Images/icon.png" />
   <style>
      body {
         height: auto;
         width: auto;
         background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url(./../../Images/bbg.jpg);
         background-position: center;
         background-size: cover;
      }
   </style>
</head>

<body>

</body>

</html>
<?php
require "conectar.php";

$id = $_REQUEST["id"];
$nome = $_REQUEST["nome"];
$preco = limpar_texto(utf8_decode($_REQUEST["preco"]));
$preco = substr_replace($preco, '.', -2, 0);
$preco = number_format($preco, 2, ".", "");
function limpar_texto($str)
{
   return preg_replace("/[^0-9]/", "", $str);
}


$sql = "UPDATE produtos SET nome='$nome' WHERE idprod='$id'";
$sql1 = "UPDATE preco SET preco='$preco' WHERE idpreco='$id'";

if (mysqli_query($con, $sql)) {
   if (mysqli_query($con, $sql1)) {
      echo "<script>alert('Registro atualizado com sucesso!!!')</script>";
      echo "<meta http-equiv='refresh' content='0; URL=./relat.php'>";
   }
} else {
   echo "Erro ao atualizar o registro : " . mysqli_error($con);
   echo "<meta http-equiv='refresh' content='0; URL=./relat.php'>";
}
mysqli_close($con);
?>