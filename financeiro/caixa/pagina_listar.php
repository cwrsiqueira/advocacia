<?php 
if(!isset($id_conta)){
	$id_conta = '%';
}

echo '<h4>'.@$conta_nome.'</h4>';

echo '
<table class="table table-responsive-sm table-sm mt-3" tabelas>
	<thead class="thead-light mov-table-head">
		<tr>
			<th scope="col" style="text-align:left;">#Lanç.</th>
			<th scope="col" style="text-align:left;">Data</th>
			<th scope="col">Movimento</th>
			<th scope="col">Entrada</th>
			<th scope="col">Saída</th>
			<th scope="col">Saldo</th>
			<th scope="col" class="nao-imprimir" style="width:100px;">Ações</th>
		</tr>
	</thead>
	<tbody class="mov-table-body">';

	$ent_ants = $pdo->query("SELECT SUM(valor) as entradas FROM lancamentos WHERE tipo = 'recebido' AND data_pagamento < '$dataInicial' AND id_conta LIKE '$id_conta'");
	$sai_ants = $pdo->query("SELECT SUM(valor) as saidas FROM lancamentos WHERE tipo = 'pago' AND data_pagamento < '$dataInicial' AND id_conta LIKE '$id_conta'");

	$ent_totaiss = $pdo->query("SELECT SUM(valor) as entradas_totais FROM lancamentos WHERE tipo = 'recebido' AND data_pagamento <= '$dataFinal' AND id_conta LIKE '$id_conta'");
	$sai_totaiss = $pdo->query("SELECT SUM(valor) as saidas_totais FROM lancamentos WHERE tipo = 'pago' AND data_pagamento <= '$dataFinal' AND id_conta LIKE '$id_conta'");
	
	$ent_ant = $ent_ants->fetch()['entradas'];
	$sai_ant = $sai_ants->fetch()['saidas'];
	$sd_ant = floatval($ent_ant) - floatval($sai_ant);
	$sd_atual = $sd_ant;

	$ent_totais = $ent_totaiss->fetch()['entradas_totais'];
	$sai_totais = $sai_totaiss->fetch()['saidas_totais'];

	$res = $pdo->query("SELECT * from lancamentos where movimento LIKE '%$txtbuscar%' AND (data_pagamento >= '$dataInicial' and data_pagamento <= '$dataFinal') AND (tipo = 'recebido' OR tipo = 'pago') AND id_conta LIKE '$id_conta' order by data_pagamento, tipo DESC, id");
	$dados = $res->fetchAll(PDO::FETCH_ASSOC);

	echo '
		<tr>
			<td>#</td>
			<td class="mov-date">'.date('d/m/Y', strtotime($dataInicial)).'</td>
			<td class="mov-text">Saldo Anterior</td>
			<td class="mov-money">'.number_format(floatval($ent_ant), 2, ',', '.').'</td>
			<td class="mov-money">'.number_format(floatval($sai_ant), 2, ',', '.').'</td>
			<td class="mov-money">'.number_format($sd_ant, 2, ',', '.').'</td>
			<td class="mov-money" class="nao-imprimir"></td>
		</tr>';

	if(empty($dados)) {
		echo '
		<tr>
			<td>#</td>
			<td class="mov-date">'.date('d/m/Y', strtotime($dataInicial)).'</td>
			<td class="mov-text">Nenhum Lançamento nesta data</td>
			<td class="mov-money"></td>
			<td class="mov-money"></td>
			<td class="mov-money"></td>
			<td class="mov-money" class="nao-imprimir"></td>
		</tr>';
	}

	for ($i=0; $i < count($dados); $i++) { 
		foreach ($dados[$i] as $key => $value) {
		}

		$id = $dados[$i]['id'];	
		$tipo = $dados[$i]['tipo'];
		$valor = $dados[$i]['valor'];
		$data = $dados[$i]['data_pagamento'];
		$movimento = $dados[$i]['movimento'];

		echo '
		<tr class="linha'.$id.'">
			<td class="id_lanc">'.$id.' 
				<span style="display:none;" class="badge badge-success novo">Novo</span>
				<span style="display:none;" class="badge badge-warning editando">Editando...</span>
				<span style="display:none;" class="badge badge-info editado">Editado</span>
			</td>
			<td class="mov-date">'.date('d/m/Y', strtotime($data)).'</td>
			<td class="mov-text">'.$movimento.'</td>';

			if($tipo == 'recebido'):
		echo '<td class="mov-money">'.number_format($valor, 2, ',', '.').'</td>';
		echo '<td class="mov-money"></td>';
			else:
		echo '<td class="mov-money"></td>';
		echo '<td class="mov-money">'.number_format($valor, 2, ',', '.').'</td>';
			endif;

			if($tipo == 'recebido'):
		echo '<td class="mov-money">'.number_format(($sd_atual += $valor), 2, ',', '.').'</td>';
			else:
		echo '<td class="mov-money">'.number_format(($sd_atual -= $valor), 2, ',', '.').'</td>';
			endif;

		echo '
		<td class="nao-imprimir">
			<div class="d-flex justify-content-between">
				<a title="Editar Lançamento" href="" id="editar_lancamento" data-id="'.$id.'">
					<i class="fas fa-edit"></i>
				</a>

				<a title="Deletar Lançamento" href="" id="deletar_lancamento" data-id="'.$id.'">
					<i class="fas fa-trash"></i>
				</a>
			</div>
		</td>';
	}

	echo '
		<tr>
			<td>#</td>
			<td class="mov-date">'.date('d/m/Y', strtotime($dataFinal)).'</td>
			<td class="mov-text">Totais</td>
			<td class="mov-money">'.number_format(floatval($ent_totais), 2, ',', '.').'</td>
			<td class="mov-money">'.number_format(floatval($sai_totais), 2, ',', '.').'</td>
			<td></td>
			<td colspan="2" class="nao-imprimir"></td>
		</tr>
		<tr><td colspan="7" class="nao-imprimir" style="text-align:right;">CTRL + P para Imprimir</td></tr>
		';

	echo  '
	</tbody>
</table>';

?>