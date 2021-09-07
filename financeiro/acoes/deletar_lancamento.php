<?php 
require_once('../../conexao.php');
$pagina = filter_input(INPUT_POST, 'pagina');

$id = filter_input(INPUT_POST, 'id');
$txtbuscar = filter_input(INPUT_POST, 'txtbuscar', FILTER_SANITIZE_STRING);
$dataInicial = filter_input(INPUT_POST, 'dataInicial', FILTER_SANITIZE_STRING);
$dataFinal = filter_input(INPUT_POST, 'dataFinal', FILTER_SANITIZE_STRING);

if($id) {
    $sql = $pdo->prepare("DELETE FROM lancamentos WHERE id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();
}

require_once '../'.$pagina.'/pagina_listar.php';

?>