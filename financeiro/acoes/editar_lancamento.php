<?php 
require_once("../../conexao.php");
$pagina = filter_input(INPUT_POST, 'pagina');

$id = filter_input(INPUT_POST, 'id');

if($id) {
    $dados = array();

    $sql = $pdo->prepare("SELECT * FROM lancamentos WHERE id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();

    if($sql->rowCount() > 0) {
        $dados = $sql->fetch(PDO::FETCH_ASSOC);
        $dados['data_lancamento'] = ($dados['data_lancamento'] != null)?date('Y-m-d', strtotime($dados['data_lancamento'])):'';
		$dados['data_vencimento'] = ($dados['data_vencimento'] != null)?date('Y-m-d', strtotime($dados['data_vencimento'])):'';
		$dados['data_pagamento'] = ($dados['data_pagamento'] != null)?date('Y-m-d', strtotime($dados['data_pagamento'])):'';

        $res = $pdo->prepare("SELECT * FROM lanc_contas WHERE id = :id_conta");
        $res->bindValue(':id_conta', $dados['id_conta']);
        $res->execute();

        if($res->rowCount() > 0) {
            $dados['conta_nome'] = $res->fetch()['nome'];
        } else {
            $dados['conta_nome'] = '';
        }
    }
    
    echo json_encode($dados);
}