<?php 
require_once('../../conexao.php');
$pagina = filter_input(INPUT_POST, 'pagina');

$id = filter_input(INPUT_POST, 'id');
$txtbuscar = filter_input(INPUT_POST, 'txtbuscar', FILTER_SANITIZE_STRING);
$dataInicial = filter_input(INPUT_POST, 'dataInicial', FILTER_SANITIZE_STRING);
$dataFinal = filter_input(INPUT_POST, 'dataFinal', FILTER_SANITIZE_STRING);
$tipo = filter_input(INPUT_POST, 'tipo');
$data_pagamento = filter_input(INPUT_POST, 'data_liquidacao');

if($tipo == 'pagar') {
    $tipo = 'pago';
} else if($tipo == 'receber') {
    $tipo = 'recebido';
}

if($id) {
    $sql = $pdo->prepare("UPDATE lancamentos SET tipo = :tipo, data_pagamento = :data_pagamento WHERE id = :id");
    $sql->bindValue(':id', $id);
    $sql->bindValue(':tipo', $tipo);
    $sql->bindValue(':data_pagamento', $data_pagamento);
    $sql->execute();
}

require_once '../'.$pagina.'/pagina_listar.php';

?>