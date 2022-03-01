<?php

$servidor = "localhost";
$usuario = "wesley";
$senha = "aluno";
$banco = "php_test";
$con = mysqli_connect($servidor,$usuario,$senha,$banco);

if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " .mysqli_connect_error();
}
?>