<?php 
require_once('../../conexao.php');
$pagina = filter_input(INPUT_POST, 'pagina');

$id = filter_input(INPUT_POST, 'id');
$txtbuscar = filter_input(INPUT_POST, 'txtbuscar', FILTER_SANITIZE_STRING);

if($id) {

    $sql = $pdo->prepare("SELECT id FROM lancamentos WHERE id_conta = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();

    if($sql->rowCount() <= 0) {
        $sql = $pdo->prepare("DELETE FROM lanc_contas WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
    } else {
        echo '<div class="deletar-conta-error" style="color:red;font-size:20px;font-weight:bold;">Conta com lançamentos não pode ser excluída!</div>';
    }   
}

require_once '../'.$pagina.'/pagina_listar.php';

?>