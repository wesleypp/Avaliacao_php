<html>

<head>
  <title>Avaliação PHP</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <link rel="icon" type="image/png" href="./../Images/icon.png" />
</head>

<body>
  <?php
  //Recebe as informações do formulario via metodo post
  $nome = utf8_decode($_POST["nome"]);
  $cor = utf8_decode($_POST["cor"]);
  $valor = utf8_decode($_POST["valor"]);
  // Função para remove os separadores decimal e de milhar do conteúdo da variavel, e transforma em numero inteiro
  function limpar_texto($str)
  {
    return preg_replace("/[^0-9]/", "", $str);
  }
  //Adiciona ponto como separador de milhar e decimal
  $valor = limpar_texto(utf8_decode($_POST["valor"]));
  $valor = substr_replace($valor, '.', -2, 0);
  $valor = number_format($valor, 2, ".","");

  $mysqli = new mysqli("localhost", "wesley", "aluno", "php_test");  //variavel para conectar ao banco de dados
  if ($result = $mysqli->query("insert into produtos(nome,cor) values ('$nome','$cor')")) {  // insirindo os dados na tabela produtos
    if ($result = $mysqli->query("insert into preco(preco)  values ('$valor')")) {
      // caso a inserção na tabela produtos for bem sucedida, será feito a inserção na tabela preco
      echo "<script>alert('Registro incluído com sucesso!!!')</script>";    // caso todas as inserções sejam ocorram com exito, o sistema retornará um alerta
      echo "<meta http-equiv='refresh' content='0; URL=./relat.php'>";    // Após o alerta redirecionará o usuario para a pagina de relatorio, que contem das as informaçoes do banco de dados
    } else {
      echo "<script>alert('Erro ao incluír o registro.')</script>";     // Cso as inserções falhem o sistema retornará um alerta 
      echo "Erro ao registrar o registro : " . mysqli_error($mysqli);    //Após o alerta o sistema exibe uma mensagem com o erro que ocorreu
      echo "<meta http-equiv='refresh' content='10; URL=./../HTML/insert.html'>"; // 10 segundos apos exibir a mensagem de erro, o sistema redireciona o usuario para a pagina principal
    }
  }


  ?>
</body>

</html>