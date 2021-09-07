<?php 
require_once("../../conexao.php");
$pagina = filter_input(INPUT_POST, 'pagina');

$txtbuscar = filter_input(INPUT_POST, 'txtbuscar', FILTER_SANITIZE_STRING);
$dataInicial = filter_input(INPUT_POST, 'dataInicial', FILTER_SANITIZE_STRING);
$dataFinal = filter_input(INPUT_POST, 'dataFinal', FILTER_SANITIZE_STRING);

$id_conta = filter_input(INPUT_POST, 'id_conta');
$conta_nome = filter_input(INPUT_POST, 'conta_nome');

if(!$id_conta) {
	$id_conta = '%';
}
if(!$conta_nome) {
	$conta_nome = 'Caixa';
}

require_once '../'.$pagina.'/pagina_listar.php';

?>