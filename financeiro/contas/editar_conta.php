<?php 
require_once("../../conexao.php");
$pagina = filter_input(INPUT_POST, 'pagina');

$id = filter_input(INPUT_POST, 'id');

if($id) {
    $dados = array();

    $sql = $pdo->prepare("SELECT * FROM lanc_contas WHERE id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();

    if($sql->rowCount() > 0) {
        $dados = $sql->fetch(PDO::FETCH_ASSOC);
    }
    
    echo json_encode($dados);
}