<?php
// recebe id para query
$i_id = $_GET["id"]; // pego o parametro enviado pela escolha da lista
// monto sql com o registro selecionado
// conexão dom o banco de dados
$servername = "localhost";
$username = "root";
$password =  "";
$database = "cartas";
// criando a conexão com banco de dados
$conection = new mysqli($servername, $username, $password, $database);
// checo erro na conexão
if ($conection->connect_error) {
    die("Erro na Conexão com o Banco de Dados!! " . $conection->connect_error);
}
// faço a Leitura da tabela com sql
$c_sql = "SELECT * FROM servicos where id=$i_id";
//echo $c_sql;
$result = $conection->query($c_sql);
$registro = $result->fetch_assoc();
// verifico se a query foi correto
if (!$result) {
    die("Erro ao Executar Sql!!" . $conection->connect_error);
}
// Armazeno resultado da query na variaveis para apresentação

$c_servico = $registro['servico'];
$c_secretaria = $registro['secretaria'];
$c_descricao =  mb_convert_encoding($registro['descricao'], "UTF-8", "ISO-8859-1");
$c_acesso =  mb_convert_encoding($registro['acesso'], "UTF-8", "ISO-8859-1");
$c_formas = mb_convert_encoding($registro['formadeacesso'], "UTF-8", "ISO-8859-1");
$c_documentos = mb_convert_encoding($registro['documentos'], "UTF-8", "ISO-8859-1");
$c_previsao = mb_convert_encoding($registro['previsao'], "UTF-8", "ISO-8859-1");
$c_custo = mb_convert_encoding($registro['custo'], "UTF-8", "ISO-8859-1");
$c_email = $registro['email'];
$c_telefone = $registro['telefone'];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=<p>, initial-scale=1.0">
    <title>PMS - Cartas de Serviço</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>

<body>
    <div class="panel panel-primary class">
        <div class="panel-heading text-center">
            <h3>Prefeitura Municipal de Sabará</h3>
            <h4>Detalhe da Carta de Serviço</h4>
        </div>
    </div>
    <br>

    <div class="container -my5">
        <h7 class="text-primary" Align="justify">
            <h4>

                <label class="text-secondary" class="col-sm-3 col-form-label">Secretaria : </label>
            </h4>
            <p><?php echo $c_secretaria ?></p>
            <br>
            <h4>
                <label class="text-secondary" class="col-sm-3 col-form-label">Serviço : </label>
                </h5>
                <p><?php echo $c_servico ?></p>
                <br>
                <h4>
                    <label class="text-secondary" class="col-sm-3 col-form-label">Descrição do Serviço :</label>
                </h4>

                <p><?php echo $c_descricao ?></p>
                <br>
                <h4><label class="text-secondary" class="col-sm-3 col-form-label">Quem Acessa : </label></h4>
                <p><?php echo $c_acesso ?></p>
                <br>
                <h4><label class="text-secondary" class="col-sm-3 col-form-label">Formas de Acesso : </label></h4>
                <p><?php echo $c_formas ?></p>
                <br>
                <h4><label class="text-secondary" class="col-sm-3 col-form-label">Telefone(s) : </label></h4>
                <p><?php echo $c_telefone ?></p>

                <br>
                <h4><label class="text-secondary" class="col-sm-3 col-form-label">e-mail : </label></h4>
                <p><?php echo $c_email ?></p>
                <br>
                <h4><label class="text-secondary" class="col-sm-3 col-form-label">Documentos Necessários : </label></h4>
                <p><?php echo $c_documentos ?></p>
                <br>
                <h4><label class="text-secondary" class="col-sm-3 col-form-label">Previsão : </label></h4>
                <p><?php echo $c_previsao ?></p>
                <br>
                <h4><label class="text-secondary" class="col-sm-3 col-form-label">Custo : </label></h4>
                <p><?php echo $c_custo ?></p>
        </h7>
    </div>
</body>

</html>