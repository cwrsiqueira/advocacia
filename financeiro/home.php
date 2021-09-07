<?php
require_once("../conexao.php");
$cpf_adv = $_SESSION['cpf_usuario'];

// SELEÇÃO DO PERÍODO DOS GRÁFICOS
$data_ini = filter_input(INPUT_POST, 'data_ini') ?? date('Y-m-d', strtotime(date('Y-m-d').' -30 days'));
$data_fin = filter_input(INPUT_POST, 'data_fin') ?? date('Y-m-d');

// APURAÇÃO DOS SALDOS (CAIXA, A RECEBER, A PAGAR E RESULTADO)
$ent_totaiss = $pdo->query("SELECT SUM(valor) as entradas_totais FROM lancamentos WHERE tipo = 'recebido'");
$sai_totaiss = $pdo->query("SELECT SUM(valor) as saidas_totais FROM lancamentos WHERE tipo = 'pago'");
$ent_totais = $ent_totaiss->fetch()['entradas_totais'];
$sai_totais = $sai_totaiss->fetch()['saidas_totais'];
$caixa = $ent_totais - $sai_totais;

$ent_totaiss = $pdo->query("SELECT SUM(valor) as entradas_totais FROM lancamentos WHERE tipo = 'receber'");
$aReceber = $ent_totaiss->fetch()['entradas_totais'];

$sai_totaiss = $pdo->query("SELECT SUM(valor) as saidas_totais FROM lancamentos WHERE tipo = 'pagar'");
$aPagar = $sai_totaiss->fetch()['saidas_totais'];

$resultado = $caixa + $aReceber - $aPagar;

// LEVANTAMENTO DA MOVIMENTAÇÃO PARA GERAÇÃO DO GRÁFICO
$data_graph = [
	['Dia', 'Receitas', 'Despesas'],
	[date('d/m/Y', strtotime($data_ini)), 0, 0],
];

$res = $pdo->query("SELECT valor, data_pagamento, tipo FROM lancamentos WHERE data_pagamento != '' AND (data_pagamento BETWEEN '$data_ini' AND '$data_fin') ORDER BY data_pagamento");
$lanc = $res->fetchAll(PDO::FETCH_ASSOC);

$data = array();
foreach($lanc as $item) {
	if($item['tipo'] == 'recebido') {
		@$data[$item['data_pagamento']]['entradas'] += $item['valor'];
	}
	if($item['tipo'] == 'pago') {
		@$data[$item['data_pagamento']]['saidas'] += $item['valor'];
	}
}
if(!empty($data)){
	$data_graph = [
		['Dia', 'Receitas', 'Despesas'],
	];
}
foreach ($data as $key => $value) {
	$data_graph[] = [date('d/m/Y', strtotime($key)), intval(@$value['entradas']), intval(@$value['saidas'])];
}

?>

<style>
	label {
		color:#555;
	}
</style>

<div class="container-fluid">

	<div class="area_cards">

		<div class="row">

			<div class="d-flex flex-column">

				<div class="col-sm mb-3">

					<div class="card card-stats">

						<div class="card-body ">
							<div class="row">
								<div class="col-5 col-md-4">
									<div class="icone-card text-center text-success">
										<i class="fas fa-coins"></i>
									</div>
								</div>
								<div class="col-7 col-md-8">
									<div class="numbers">
										<p class="titulo-card">Resultado em R$</p>
										<ul>
											<li class="d-flex justify-content-between">
												<div>Caixa</div>
												<div><?php echo number_format($caixa, 2, ',', '.'); ?></div>
											</li>
											<li class="d-flex justify-content-between">
												<div>A Receber</div>
												<div><?php echo number_format($aReceber, 2, ',', '.'); ?></div>
											</li>
											<li class="d-flex justify-content-between">
												<div>A Pagar</div>
												<div><?php echo number_format($aPagar, 2, ',', '.'); ?></div>
											</li>
											<li class="d-flex justify-content-between">
												<div>Resultado</div>
												<div><?php echo number_format($resultado, 2, ',', '.'); ?></div>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="card-footer rodape-card">
							Apuração do Resultado
						</div>
					</div>
				</div>

				<div class="col-sm mb-3">
					<span class="nao-imprimir" style="color:#555;font-size:20px;font-weight:bold;">Selecionar Período do Gráfico</span>
					<form method="post">
						<div class="form-group">
							<label for="data_ini">Data Inicial:</label>
							<input type="date" class="form-control" name="data_ini" id="data_ini" value="<?php echo @$data_ini; ?>">
						</div>
						<div class="form-group">
							<label for="data_fin">Data Final:</label>
							<input type="date" class="form-control" name="data_fin" id="data_fin" value="<?php echo @$data_fin; ?>">
						</div>
						<div class="d-flex justify-content-around">
							<button type="submit" class="btn btn-sm btn-primary nao-imprimir">Selecionar</button>
							<div onclick="limparPeriodo()" class="btn btn-sm btn-danger nao-imprimir">Limpar</div>
						</div>

					</form>
				</div>

				<div class="col-sm nao-imprimir" style="color:#555">CTRL + P para imprimir a página</div>

			</div>

			<div class="col-sm">
				<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
				<script type="text/javascript">
				google.charts.load('current', {'packages':['corechart']});
				google.charts.setOnLoadCallback(drawChart);

				function drawChart() {
					var data = google.visualization.arrayToDataTable(<?=json_encode($data_graph)?>);

					var options = {
					title: 'Performance Econômica',
					curveType: 'function',
					legend: { position: 'bottom' }
					};

					var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

					chart.draw(data, options);
				}
				</script>
				<div id="curve_chart" style="width: 900px; height: 500px;"></div>
			</div>

		</div>
	</div>
</div>

<script>
	function limparPeriodo(){
		$("input[type=date]").each(function(){
			$(this).val('');
		});
		$('form').submit();
	}
</script>
