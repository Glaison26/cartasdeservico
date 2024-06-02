<?php
// controle de acesso ao formulário
//session_start();
//if (!isset($_SESSION['newsession2'])) {
//    die('Acesso não autorizado!!!');
//}
//if ($_SESSION['c_tipo'] != '1') {
//    header('location: /pcas/voltamenunegado.php');
//}
// Incluir a conexão com banco de dados
// conexão dom o banco de dados

// rotina para entrada do usuário

$servername = "localhost";
$username = "root";
$password =  "";
$database = "cartas";
// criando a conexão com banco de dados
$conection = new mysqli($servername, $username, $password, $database);
$conn = new PDO("mysql:host=$servername;dbname=" . $database, $username, $password);
// checo erro na conexão
if ($conection->connect_error) {
    die("Erro na Conexão com o Banco de Dados!! " . $conection->connect_error);
}
$c_msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Limpar o buffer de saída
    // Limpar o buffer de saída
    ob_start();

    // Receber o arquivo do formulário
    $arquivo = $_FILES['arquivo'];
    //var_dump($arquivo);

    // Variáveis de validação
    $linha_cabecalho = 1;
    $linhas_importadas = 0;
    $linhas_nao_importadas = 0;
    $pca_nao_importado = "";

    // Verificar se é arquivo csv
    if (($arquivo['type'] == "text/csv") && ($c_msg == "")) {

        $i_cabec = 2;

        // Ler os dados do arquivo
        $dados_arquivo = fopen($arquivo['tmp_name'], "r");
        $c_msg = "Importação não completada";
        // Percorrer os dados do arquivo
        while ($linha = fgetcsv($dados_arquivo, 1000, ";")) {
            // Como ignorar a primeira linha do Excel

            if ($linha_cabecalho < $i_cabec) {
                $linha_cabecalho++;
                continue;
            }


            array_walk_recursive($linha, 'converter');
            //var_dump($linha);
            // procuro o id da secretaria selecionada para gravar no registro

            // verifico qual tipo da importação

            // Criar a QUERY para salvar o usuário no banco de dados
            //descricao,documentos,acesso,formadeacesso, custo, previsao )
            $query_pca = "INSERT INTO servicos (secretaria,servico)
            VALUES (:secretaria, :servico)";
            // :descricao, :documentos, :acesso, :formadeacesso, :custo, :previsao)";

            // Preparar a QUERY
            $pca = $conn->prepare($query_pca);
            $c_nivel = "";
            // Substituir os links da QUERY pelos valores
            $pca->bindValue(':servico', ($linha[0] ?? "NULL"));
            $pca->bindValue(':secretaria', ($linha[1] ?? "NULL"));
            //$pca->bindValue(':secretaria', ($linha[1] ?? "NULL"));
            //$pca->bindValue(':descricao', ($linha[3] ?? "NULL"));
            //$pca->bindValue(':documentos', ($linha[6] ?? "NULL"));
            //$pca->bindValue(':acesso', ($linha[4] ?? "NULL"));
            //$pca->bindValue(':formadeacesso', ($linha[5] ?? "NULL"));
            //$pca->bindValue(':custo', ($linha[7] ?? "NULL"));
            //$pca->bindValue(':previsao', ($linha[8] ?? "NULL"));


            // Executar a QUERY
            $pca->execute();

            // Verificar se cadastrou corretamente no banco de dados
            if ($pca->rowCount()) {
                $linhas_importadas++;
            } else {
                $linhas_nao_importadas++;
                $pca_nao_importado = $pca_nao_importado . ", " . ($linha[0] ?? "NULL");
            }
        }
        $c_msg = "Importação Fianalizada com sucesso!!";
    }
}

// Criar função valor por referência, isto é, quando alter o valor dentro da função, vale para a variável fora da função.
function converter(&$dados_arquivo)
{
    // Converter dados de ISO-8859-1 para UTF-8
    //$dados_arquivo = mb_convert_encoding($dados_arquivo, "UTF-8", "ISO-8859-1");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>PMS - PCAS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/yourcode.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<body>
    <div class="panel panel-primary class">
        <div class="panel-heading text-center">
            <h4>PCA - Secretaria Municipal de Administração</h4>
            <h5>Importar dados para banco PCA<h5>
        </div>

    </div>
    <br>
    <div class="container">
        <?php
        if (!empty($c_msg)) {
            echo "
            <div class='alert alert-warning' role='alert'>
                <h4>$c_msg</h4>
            </div>
                ";
        }
        ?>
        <!-- Formulario para enviar arquivo .csv -->
        <form method="post" enctype="multipart/form-data">
            <div class="alert alert-success">
                <strong>Selecione arquivo </strong>
            </div>
            <label>Arquivo: </label>
            <input type="file" name="arquivo" accept="text/csv"><br><br>
            <br>


            <br>
            <hr>
            <div class="container-fluid" class="row col-xs-12 col-sm-12 col-md-12 col-lg-12" align="left">
                <button type="submit" class="btn btn-primary"><span class='glyphicon glyphicon-open-file'></span> Importar Arquivo</button>
                <a class="btn btn-danger" href="/pcas/menu.php"><span class="glyphicon glyphicon-off"></span> Voltar ao menu</a>
            </div>
            <hr>
        </form>
    </div>

</body>

</html>