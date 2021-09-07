<?php
require_once('../../conexao.php');
$pagina = filter_input(INPUT_POST, 'pagina');

$id_conta = filter_input(INPUT_POST, 'id_conta');
$nome = filter_input(INPUT_POST, 'nome');

$txtbuscar = filter_input(INPUT_POST, 'txtbuscar', FILTER_SANITIZE_STRING);

if($pagina && $nome) {
    
    if($id_conta) {

        $sql = $pdo->prepare("UPDATE lanc_contas SET nome = :nome WHERE id = :id_conta");
        $sql->bindValue(':id_conta', $id_conta);
        $sql->bindValue(':nome', $nome);
        $sql->execute();

        $last_id = $id_conta;

        echo '<input class="lastEditId" type="hidden" value="'.$last_id.'">';

    } else {

        $sql = $pdo->prepare("INSERT INTO lanc_contas SET nome = :nome");
        $sql->bindValue(':nome', $nome);
        $sql->execute();

        $last_id = $pdo->lastInsertId();

        echo '<input class="lastInsertId" type="hidden" value="'.$last_id.'">';

    }
}

require_once '../'.$pagina.'/pagina_listar.php';

?>