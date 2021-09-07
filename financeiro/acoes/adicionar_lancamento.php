<?php
require_once('../../conexao.php');
$pagina = filter_input(INPUT_POST, 'pagina');

$id_lancamento = filter_input(INPUT_POST, 'id_lancamento');
$conta_id = filter_input(INPUT_POST, 'conta_id');
$cpf_usuario = filter_input(INPUT_POST, 'cpf_usuario');
$tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_STRING);
$movimento = trim(filter_input(INPUT_POST, 'movimento', FILTER_SANITIZE_STRING));
$data_lancamento = filter_input(INPUT_POST, 'data-lancamento', FILTER_SANITIZE_STRING);
$data_vencimento = filter_input(INPUT_POST, 'data-vencimento', FILTER_SANITIZE_STRING);
$data_pagamento = filter_input(INPUT_POST, 'data-pagamento', FILTER_SANITIZE_STRING);
$valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_STRING);

$txtbuscar = filter_input(INPUT_POST, 'txtbuscar', FILTER_SANITIZE_STRING);
$dataInicial = filter_input(INPUT_POST, 'dataInicial', FILTER_SANITIZE_STRING);
$dataFinal = filter_input(INPUT_POST, 'dataFinal', FILTER_SANITIZE_STRING);

if($cpf_usuario && $tipo && $movimento && $data_lancamento && $valor && $conta_id) {

    $sql = $pdo->prepare("SELECT id FROM usuarios WHERE cpf = :cpf");
    $sql->bindValue(':cpf', $cpf_usuario);
    $sql->execute();
    if($sql->rowCount() > 0) {
        $dados = $sql->fetch();
        $id = $dados['id'];
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);
        $data_vencimento = ($data_vencimento == '')?null:$data_vencimento;
        $data_pagamento = ($data_pagamento == '')?null:$data_pagamento;

        if($id_lancamento) {

            $sql = $pdo->prepare("UPDATE lancamentos SET id_usuario = :id, tipo = :tipo, movimento = :movimento, valor = :valor, data_lancamento = :data_lancamento, data_vencimento = :data_vencimento, data_pagamento = :data_pagamento, id_conta = :conta_id WHERE id = :id_lancamento");
            $sql->bindValue(':id', $id);
            $sql->bindValue(':tipo', $tipo);
            $sql->bindValue(':movimento', $movimento);
            $sql->bindValue(':valor', $valor);
            $sql->bindValue(':data_lancamento', $data_lancamento);
            $sql->bindValue(':data_vencimento', $data_vencimento);
            $sql->bindValue(':data_pagamento', $data_pagamento);
            $sql->bindValue(':id_lancamento', $id_lancamento);
            $sql->bindValue(':conta_id', $conta_id);
            $sql->execute();

            $last_id = $id_lancamento;

            echo '<input class="lastEditId" type="hidden" value="'.$last_id.'">';

        } else {
            // var_dump($id, $tipo, $movimento, $valor, $data_lancamento, $data_vencimento, $data_pagamento, $conta_id);exit;
            $sql = $pdo->prepare("INSERT INTO lancamentos SET id_usuario = :id, tipo = :tipo, movimento = :movimento, valor = :valor, data_lancamento = :data_lancamento, data_vencimento = :data_vencimento, data_pagamento = :data_pagamento, id_conta = :conta_id");
            $sql->bindValue(':id', $id);
            $sql->bindValue(':tipo', $tipo);
            $sql->bindValue(':movimento', $movimento);
            $sql->bindValue(':valor', $valor);
            $sql->bindValue(':data_lancamento', $data_lancamento);
            $sql->bindValue(':data_vencimento', $data_vencimento);
            $sql->bindValue(':data_pagamento', $data_pagamento);
            $sql->bindValue(':conta_id', $conta_id);
            $sql->execute();

            $last_id = $pdo->lastInsertId();

            echo '<input class="lastInsertId" type="hidden" value="'.$last_id.'">';

        }
    }
}

require_once '../'.$pagina.'/pagina_listar.php';

?>
