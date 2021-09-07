<?php 

echo '
<table class="table table-responsive-sm table-sm mt-3" tabelas>
	<thead class="thead-light mov-table-head">
		<tr>
			<th scope="col" style="text-align:left;">#Lanç.</th>
			<th scope="col" style="text-align:left;">Data</th>
			<th scope="col">Movimento</th>
			<th scope="col">A Pagar</th>
			<th scope="col">Saldo</th>
			<th scope="col" class="nao-imprimir" style="width:100px;">Ações</th>
		</tr>
	</thead>
	<tbody class="mov-table-body">';

	$sai_ants = $pdo->query("SELECT SUM(valor) as saidas FROM lancamentos WHERE tipo = 'pagar' AND data_vencimento < '$dataInicial'");

	$venc_futs = $pdo->query("SELECT SUM(valor) as venc_fut FROM lancamentos WHERE tipo = 'pagar' AND data_vencimento > '$dataFinal'");
	
	$sai_totaiss = $pdo->query("SELECT SUM(valor) as saidas_totais FROM lancamentos WHERE tipo = 'pagar' AND data_vencimento <= '$dataFinal'");
	
	$sai_ant = $sai_ants->fetch()['saidas'];
	$venc_fut = $venc_futs->fetch()['venc_fut'];
	$sd_ant = $sai_ant;
	$sd_atual = $sd_ant;

	$sai_totais = $sai_totaiss->fetch()['saidas_totais'];

	$res = $pdo->query("SELECT * from lancamentos where movimento LIKE '%$txtbuscar%' AND (data_vencimento >= '$dataInicial' and data_vencimento <= '$dataFinal') AND tipo = 'pagar' order by data_vencimento, tipo DESC, id");
	$dados = $res->fetchAll(PDO::FETCH_ASSOC);

	echo '
		<tr>
			<td>#</td>
			<td class="mov-date">'.date('d/m/Y', strtotime($dataInicial)).'</td>
			<td class="mov-text">Saldo Anterior</td>
			<td class="mov-money">'.number_format(floatval($sai_ant), 2, ',', '.').'</td>
			<td class="mov-money">'.number_format($sd_ant, 2, ',', '.').'</td>
			<td class="nao-imprimir"></td>
		</tr>';

	if(empty($dados)) {
		echo '
		<tr>
			<td>#</td>
			<td class="mov-date">'.date('d/m/Y', strtotime($dataInicial)).'</td>
			<td class="mov-text">Nenhum Lançamento neste período</td>
			<td class="mov-money"></td>
			<td class="mov-money"></td>
			<td class="nao-imprimir"></td>
		</tr>';
	}

	for ($i=0; $i < count($dados); $i++) { 
		foreach ($dados[$i] as $key => $value) {
		}

		$id = $dados[$i]['id'];	
		$tipo = $dados[$i]['tipo'];
		$valor = $dados[$i]['valor'];
		$data = $dados[$i]['data_vencimento'];
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

			echo '<td class="mov-money">'.number_format($valor, 2, ',', '.').'</td>';

			echo '<td class="mov-money">'.number_format(($sd_atual -= $valor), 2, ',', '.').'</td>';

			echo '
			<td class="nao-imprimir">
				<div class="d-flex justify-content-between">
					<a title="Editar Lançamento" href="" id="editar_lancamento" data-id="'.$id.'">
						<i class="fas fa-edit"></i>
					</a>

					<a title="Deletar Lançamento" href="" id="deletar_lancamento" data-id="'.$id.'">
						<i class="fas fa-trash"></i>
					</a>

					<a title="Liquidar Lançamento" href="" id="liquidar_lancamento" data-id="'.$id.'" data-tipo="pagar">
						<i class="fas fa-money"></i>
					</a>
				</div>
			</td>

		</tr>';
	}

	echo '
		<tr>
			<td>#</td>
			<td class="mov-date">'.date('d/m/Y', strtotime($dataFinal)).'</td>
			<td class="mov-text">Total até esta data</td>
			<td class="mov-money">'.number_format(floatval($sai_totais), 2, ',', '.').'</td>
			<td></td>
			<td class="nao-imprimir"></td>
		</tr>';

	echo '
		<tr>
			<td>#</td>
			<td class="mov-date"> A partir de '.date('d/m/Y', strtotime($dataFinal.' +1 days')).'</td>
			<td class="mov-text">Vencimentos Futuros</td>
			<td class="mov-money">'.number_format(floatval($venc_fut), 2, ',', '.').'</td>
			<td></td>
			<td class="nao-imprimir"></td>
		</tr>
		<tr><td colspan="6" class="nao-imprimir" style="text-align:right;">CTRL + P para Imprimir</td></tr>
		';

	echo  '
	</tbody>
</table>';

?>