<?php 
require_once("../../conexao.php");
$pagina = 'lancamentos';

$q = filter_input(INPUT_GET, 'q');

if($q) {
    $res = array();
    $sql = $pdo->prepare("SELECT * FROM lanc_contas WHERE nome LIKE :q");
    $sql->bindValue(':q', '%'.$q.'%');
    $sql->execute();
    if($sql->rowCount() > 0) {
        $res = $sql->fetchAll();
    }
    
    echo json_encode($res);
}
