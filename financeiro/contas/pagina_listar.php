<?php 

echo '
<table class="table table-responsive-sm table-sm mt-3" tabelas>
	<thead class="thead-light mov-table-head">
		<tr>
			<th>#ID</th>
			<th>Nome</th>
			<th>Saldo Atual</th>
			<th class="nao-imprimir" style="width:100px;">Ações</th>
		</tr>
	</thead>
	<tbody class="mov-table-body">';

	$saldo = 0;

	$res = $pdo->query("SELECT * from lanc_contas where nome LIKE '%$txtbuscar%' order by nome, id");
	$dados = $res->fetchAll(PDO::FETCH_ASSOC);

	for ($i=0; $i < count($dados); $i++) { 
		foreach ($dados[$i] as $key => $value) {
		}

		$id = $dados[$i]['id'];	
		$nome = $dados[$i]['nome'];

		$entradas = $pdo->prepare("SELECT sum(valor) as entradas FROM lancamentos WHERE id_conta = :id AND tipo = 'recebido'");
		$entradas->bindValue(':id', $id);
		$entradas->execute();
		if($entradas->rowCount() > 0) {
			$ent = $entradas->fetch();
		}
		$saidas = $pdo->prepare("SELECT sum(valor) as saidas FROM lancamentos WHERE id_conta = :id AND tipo = 'pago'");
		$saidas->bindValue(':id', $id);
		$saidas->execute();
		if($saidas->rowCount() > 0) {
			$sai = $saidas->fetch();
		}
		$saldo = $ent['entradas'] - $sai['saidas'];

		echo '
		<tr class="linha'.$id.'">

			<td class="id_conta">'.$id.' 
				<span style="display:none;" class="badge badge-success novo">Novo</span>
				<span style="display:none;" class="badge badge-warning editando">Editando...</span>
				<span style="display:none;" class="badge badge-info editado">Editado</span>
			</td>
            
            <td>'.$nome.'</td>
            <td style="text-align:right;padding-right:50px;">'.number_format($saldo, 2, ',', '.').'</td>
			
			<td class="nao-imprimir">
			<div class="d-flex justify-content-between">
				<a title="Editar Conta" href="" id="editar_conta" data-id="'.$id.'">
					<i class="fas fa-edit"></i>
				</a>

				<a title="Visualizar Conta" href="index.php?acao=caixa&id_conta='.$id.'&nome_conta='.$nome.'" id="visualizar_conta"">
					<i class="fas fa-eye"></i>
				</a>

				<a title="Deletar Conta" href="" id="deletar_conta" data-id="'.$id.'">
					<i class="fas fa-trash"></i>
				</a>
				</div>
			</td>

        </tr>
		';
	}

	echo  '
	<tr><td colspan="4" class="nao-imprimir" style="text-align:right;">CTRL + P para Imprimir</td></tr>
	</tbody>
</table>';

?>