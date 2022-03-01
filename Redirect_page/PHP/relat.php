<!DOCTYPE html>

<head>
    <title>AVALIAÇÃO PHP</title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="icon" type="image/png" href="./../Images/icon.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./../CSS/style_relat.css">
    <link rel="stylesheet" href="./../CSS/formulario.css">
    <script src="https://code.jquery.com/jquery-3.0.0.min.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="./../JS/script_relat.js"></script>
    <script language="javascript">
        function SelectRedirect() {
            // ON selection of section this function will work
            //alert( document.getElementById('s1').value);

            switch (document.getElementById('s1').value) {
                case "AMARELO":
                    window.location = "./relat.php?cor=amarelo";
                    break;

                case "VERMELHO":
                    window.location = "./relat.php?cor=vermelho";
                    break;

                case "AZUL":
                    window.location = "./relat.php?cor=azul";
                    break;

            } // end of switch 
        }
    </script>
</head>

<body>
    <div class="container">
        <aside class="card__contents">

            <a style="margin-left:45%; " class="menu-button js-menu-button">
                <div class="menu-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </a>

        </aside>
        <div class="fullscreen-menu-container js-menu-container">

            <a class="menu-button js-menu-close">
                <div class="menu-icon is-active">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </a>

            <div class="fullscreen-menu">

                <h1 class="fullscreen-menu__title">Filtros</h1>
                <section class="card">
                    <section class="card__contents">
                        <form action="./relat.php?name=nome" method="get" class="col s12">
                            Pesquisar por nome:<input type="text" maxlength="40" name="nome" placeholder="Digite o nome do produto" required autofocus>
                            <div class="formulario">
                                <form action="./relat.php?cor=cor" method="get">
                                    Pesquisar por cor:
                                    <select id="s1" onChange="SelectRedirect();" name='cor'>
                                        <option value=''>Selecione uma cor</option>
                                        <option value='AMARELO'>Amarelo</option>
                                        <option value='AZUL'>Azul</option>
                                        <option value='VERMELHO'>Vermelho</option>
                                    </select>
                                </form>
                            </div>
                            <div class="formulario">
                                <form action="./relat.php?preco=preco&operador=sinal" method="get">
                                    Pesquisar por preço:
                                    <select name='sinal'>
                                        <option value='maior'>Maior que</option>
                                        <option value='igual'>Igual a</option>
                                        <option value='menor'>Menor que</option>
                                    </select>
                                    <input type="number" maxlength="5" name="preco" placeholder="Digite um valor" required autofocus>
                                </form>
                            </div>

                    </section>
                </section>
            </div>

        </div>

        <article class="card">
            <section class="card__contents">

                <header class="card__header">
                    <h1 class="card__title">Relatorio</h1>
                </header>
                <section class="card__body">
                    <?php

                    require "conectar.php";


                    @$getnome = $_REQUEST["nome"];
                    @$getcor = $_REQUEST["cor"];
                    @$getpreco = $_REQUEST["preco"];
                    @$getsinal = $_REQUEST["sinal"];

                    function limpar_texto($str)
                    {
                        return preg_replace("/[^0-9]/", "", $str);
                    }

                    if (isset($getnome)) {
                        $search = "SELECT * FROM (preco INNER JOIN produtos ON produtos.idprod = preco.idpreco) where produtos.nome like '%$getnome%'  order by produtos.nome asc";
                    } elseif (isset($getcor)) {
                        $search = "SELECT * FROM (preco INNER JOIN produtos ON produtos.idprod = preco.idpreco) where produtos.cor='$getcor'  order by produtos.cor asc";
                    } elseif (isset($getpreco)) {
                        if ($getsinal == "maior") {
                            $search = "SELECT * FROM (preco INNER JOIN produtos ON produtos.idprod = preco.idpreco) where preco.preco>'$getpreco' order by preco.preco asc";
                        } elseif ($getsinal == "igual") {
                            $search = "SELECT * FROM (preco INNER JOIN produtos ON produtos.idprod = preco.idpreco) where preco.preco>='$getpreco'  order by preco.preco asc";
                        } elseif ($getsinal == "menor") {
                            $search = "SELECT * FROM (preco INNER JOIN produtos ON produtos.idprod = preco.idpreco) where preco.preco<'$getpreco'  order by preco.preco asc";
                        }
                    } else {
                        $search = "SELECT * FROM (preco INNER JOIN produtos ON produtos.idprod = preco.idpreco)";
                    }
                    $result = mysqli_query($con, $search);

                    if (mysqli_affected_rows($con) == 0) {
                        echo "<script type='text/javascript'>alert('Base de dados Vazia!!!');</script>";
                        echo "<meta http-equiv='refresh' content='0; URL=./../../index.html'>";
                    } else {
                        echo "<table class='table table-striped'><thead  class='thead-light'><tr><th scope='col'>#</th><th scope='col'>Nome produto</th><th scope='col'>Cor</th><th scope='col'>Preço</th><th scope='col'>Desconto</th><th scope='col'>Valor com desconto</th><th scope='col'>Editar</th><th scope='col'>Excluir</th></tr><thead>";
                        while ($registro = mysqli_fetch_assoc($result)) {

                            @$id = utf8_encode($registro["idprod"]);
                            @$nome = utf8_encode($registro["nome"]);
                            @$cor = utf8_encode($registro["cor"]);
                            @$preco = number_format(substr_replace(limpar_texto($registro["preco"]), ',', -2, 0), 2, ",", ".");

                            if ((($cor == "VERMELHO") && ((substr_replace(limpar_texto($registro["preco"]), '.', -2, 0)) <= 50.00)) || ($cor == "AZUL")) {
                                $desconto = "20%";
                                $desc = 0.20;
                                $prec = substr_replace(limpar_texto($registro["preco"]), '.', -2, 0);
                                $valor = ($prec) - (($prec) * ($desc));
                                @$valor = number_format(substr_replace($valor, ',', -2, 0), 2, ",", ".");
                            } elseif ($cor == "AMARELO") {
                                $desconto = "10%";
                                $desc = 0.10;
                                $prec = substr_replace(limpar_texto($registro["preco"]), '.', -2, 0);
                                $valor = ($prec) - (($prec) * ($desc));
                                @$valor = number_format(substr_replace($valor, ',', -2, 0), 2, ",", ".");
                            } elseif (($cor == "VERMELHO") && ((substr_replace(limpar_texto($registro["preco"]), '.', -2, 0)) > 50.00)) {
                                $desconto = "5%";
                                $desc = 0.05;
                                $prec = substr_replace(limpar_texto($registro["preco"]), '.', -2, 0);
                                $valor = ($prec) - (($prec) * ($desc));
                                @$valor = number_format(substr_replace($valor, ',', -2, 0), 2, ",", ".");
                            }

                            echo "<tbody><tr scope='row'><td>$id</td><td>$nome</td><td>$cor</td><td>R$ $preco</td><td>$desconto</td><td>R$ $valor</td><td scope='col'><a href='alterar.php?id=$id'><i type='button'style='witdh:10%;' class='btn btn-primary'>Editar</i></a></td><td scope='col'><a href='excluir.php?id=$id'><i class='btn btn-danger'>Excluir</i></a></td></tr></tbody>";
                        }
                        echo "</table>";
                    }
                    ?>

                </section>
        </article>

    </div>
</body>

</html>