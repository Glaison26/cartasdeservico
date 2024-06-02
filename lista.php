<?php // controle de acesso ao formulário
//session_start();
//if (!isset($_SESSION['newsession'])) {
//    die('Acesso não autorizado!!!');
//}
$c_id = $_GET["id"]; // pego o parametro enviado pelo menu
if ($c_id == '1') {
    $c_secretaria = 'FAZENDA';
}
if ($c_id == '2') {
    $c_secretaria = 'ESPORTES';
}
if ($c_id == '3') {
    $c_secretaria = 'CULTURA';
}
if ($c_id == '4') {
    $c_secretaria = 'TURISMO';
}
if ($c_id == '5') {
    $c_secretaria = 'CONTROLADORIA';
}
if ($c_id == '6') {
    $c_secretaria = 'ADMINISTRAÇÃO';
}
if ($c_id == '7') {
    $c_secretaria = 'MEIO AMBIENTE';
}
if ($c_id == '8') {
    $c_secretaria = 'DEFESA SOCIAL';
}
if ($c_id == '9') {
    $c_secretaria = 'EDUCAÇÃO';
}
if ($c_id == '10') {
    $c_secretaria = 'OBRAS';
}
if ($c_id == '11') {
    $c_secretaria = 'DESENVOLVIMENTO SOCIAL';
}
if ($c_id == '12') {
    $c_secretaria = 'RECURSOS HUMANOS';
}
if ($c_id == '13') {
    $c_secretaria = 'COMUNICAÇÃO';
}
if ($c_id == '14') {
    $c_secretaria = 'PLANEJAMENTO';
}
if ($c_id == '15') {
    $c_secretaria = 'SINE';
}
if ($c_id == '16') {
    $c_secretaria = 'SAÚDE';
}
if ($c_id == '17') {
    $c_secretaria = 'PROCURADORIA JURÍDICA';
}
if ($c_id == '0') {
    $c_secretaria = 'Todas';
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PMS - Cartas de Serviço</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.3/datatables.min.css" rel="stylesheet">
    <link href="DataTables/datatables.min.css" rel="stylesheet">


</head>

<body>
    <script scr="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script scr="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="DataTables/datatables.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.3/datatables.min.js"></script>


    <script>
        $(document).ready(function() {
            $('.tabcartas').DataTable({
                // 
                "iDisplayLength": 6,
                "order": [1, 'asc'],
                "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [2]
                }, {
                    'aTargets': [0],
                    "visible": false
                }],
                "oLanguage": {
                    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sLengthMenu": "_MENU_ resultados por página",
                    "sInfoFiltered": " - filtrado de _MAX_ registros",
                    "oPaginate": {
                        "spagingType": "full_number",
                        "sNext": "Próximo",
                        "sPrevious": "Anterior",
                        "sFirst": "Primeiro",
                        "sLoadingRecords": "Carregando...",
                        "sProcessing": "Processando...",
                        "sZeroRecords": "Nenhum registro encontrado",

                        "sLast": "Último"
                    },
                    "sSearch": "Pesquisar",
                    "sLengthMenu": 'Mostrar <select>' +
                        '<option value="5">5</option>' +
                        '<option value="10">10</option>' +
                        '<option value="20">20</option>' +
                        '<option value="30">30</option>' +
                        '<option value="40">40</option>' +
                        '<option value="50">50</option>' +
                        '<option value="-1">Todos</option>' +
                        '</select> Registros'

                }

            });

        });
    </script>
    <div class="panel panel-primary class">
        <div class="panel-heading text-center">
            <h3>Prefeitura Municipal de Sabará</h3>
            <h4>Lista de Cartas de serviços - Secretaria : <?php echo $c_secretaria ?> <h4>
        </div>
    </div>

    <div class="container -my5">
        

        <hr>
        <table class="table display table-bordered tabcartas">
            <thead class="thead">
                <tr>
                    <th>Código</th>
                    <th>Descrição do Serviço</th>
                    <th>Opções</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // conexão dom o banco de dados
                $servername = "localhost";
                $username = "root";
                $password =  "";
                $database = "cartas";
                // criando a conexão com banco de dados
                $conection = new mysqli($servername, $username, $password, $database);
                // checo erro na conexão
                if ($conection->connect_error) {
                    die("Erro na Conexão com o Banco de Dados!!" . $conection->connect_error);
                }
                // faço a Leitura da tabela com sql
                if ($c_secretaria == 'Todas') {
                    $c_sql = "SELECT id,servico FROM servicos order by servico";
                } else {
                    $c_sql = "SELECT id,servico FROM servicos where secretaria='$c_secretaria' order by servico";
                }
                //echo $c_sql;
                $result = $conection->query($c_sql);
                // verifico se a query foi correto
                if (!$result) {
                    die("Erro ao Executar Sql!!" . $conection->connect_error);
                }

                // insiro os registro do banco de dados na tabela 
                while ($c_linha = $result->fetch_assoc()) {
                    echo "
                    <tr class='table-primary'>
                    <td>$c_linha[id]</td>
                    <td>$c_linha[servico]</td>                    
                    <td>
                    <a class='btn btn-info' title='Visualizar Carta de Serviço' href='/cartasdeservico/carta.php?id=$c_linha[id]'><span class='glyphicon glyphicon-folder-open'> Visualizar</span></a>
                    </td>

                    </tr>
                    ";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>