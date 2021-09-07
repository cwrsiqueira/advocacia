<?php 
$pagina = 'contasPagar';
$agora = date('Y-m-d'); 
$cpf_usuario = $_SESSION['cpf_usuario'];
?>

<style>
	.form-field {
		width:100%;
		padding:20px;
	}
	.row {
		margin:0;
	}
	.btn-add-lanc {
		display:flex;
		align-items: center;
		justify-content: center;
	}
	.btn-add-lanc div {
		margin:0;
		display:flex;
		width:100%;
	}
	.btn-add-lanc div button {
		margin-left:10px;
		margin-right:10px;
	}
	td.botao-acoes {
		padding: 0px;
		text-align: center;
	}
</style>

<div class="container">
	<h4>Controle de Contas a Pagar</h4>
	<div class="nao-imprimir">
	<button type="button" class="btn btn-sm btn-primary" data-toggle="collapse" data-target="#collapse-inserir-lancamento">Inserir Lançamento</button>
		<div id="collapse-inserir-lancamento" class="collapse">
		<div class="row">

			<form method="POST" id="adicionar_lancamento" class="form-field">
				<input type="hidden" name="pagina" value="<?php echo $pagina; ?>">
				
				<div class="row">
					<div class="col-sm-2">
						<div class="form-group">
							<label for="tipo">Tipo:</label>
							<select class="form-control" name="tipo" id="tipo" required>
								<option value="pagar">A Pagar</option>
							</select>
						</div>
					</div>	
					<div class="col-sm-10">
						<div class="form-group">
							<label for="conta">De/Para:</label>
							<input type="text" name="conta" class="form-control" placeholder="Contra Partida">
							<input type="hidden" name="conta_id" required>
						</div>
					</div>		
				</div>
				<div class="row">
					<div class="col-sm">
						<div class="form-group">
							<label for="movimento">Discriminação:</label>
							<textarea class="form-control" name="movimento" id="movimento" cols="30" rows="3" placeholder="Discriminação do Lançamento" required></textarea>
							<!-- <input type="text" name="movimento" id="movimento" class="form-control" placeholder="Discriminação do Lançamento" required> -->
							<input type="hidden" name="cpf_usuario" value="<?php echo $cpf_usuario; ?>">
							<input type="hidden" name="id_lancamento" id="editando" value="">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm">
						<div class="form-group">
							<label for="data-lancamento">Data do Lançamento:</label>
							<input type="date" name="data-lancamento" id="data-lancamento" value="<?php echo $agora; ?>" class="form-control" max="<?php echo $agora; ?>" required>
							<input type="hidden" name="data-pagamento" id="data-pagamento" value="">
						</div>
					</div>
					<div class="col-sm">
						<div class="form-group">
							<label for="data-vencimento">Data do Vencimento:</label>
							<input type="date" name="data-vencimento" id="data-vencimento" value="<?php echo $agora; ?>" class="form-control" min="<?php echo $agora; ?>">
						</div>
					</div>
					<div class="col-sm">
						<div class="form-group">
							<label for="valor">Valor:</label>
							<input type="text" name="valor" id="valor" class="form-control" placeholder="0,00" required>
						</div>
					</div>
					<div class="col-sm btn-add-lanc">
						<div class="form-group">
							<button type="submit" class="btn btn-sm btn-primary form-control btn-salvar">Incluir</button>
							<button class="btn btn-sm btn-danger form-control btn-cancelar">Cancelar</button>
						</div>
					</div>
				</div>
			</form>

		</div>
		</div>

	<div class="row mt-4">

		<div class="col-md-3 col-sm-12">
			<div class="float-left">
				
			</div>
		</div>

		<div class="col-md-9 col-sm-12">

			<div class="float-right mr-4">
				<form id="frm" class="form-inline my-2 my-lg-0" method="post">

					<input type="hidden" id="pag"  name="pag" value="<?php echo @$_GET['pagina'] ?>">
					<input type="hidden" id="itens"  name="itens" value="<?php echo @$itens_por_pagina; ?>">
					<input type="hidden" name="pagina" value="<?php echo $pagina; ?>">

					<a class="btn btn-sm btn-secondary m-3" href="<?php echo BASE_URL; ?>financeiro/index.php?acao=contasPagar">Limpar Buscas</a>

					<input type="text" name="txtbuscar" id="txtbuscar" class="form-control form-control-sm mr-sm-2" placeholder="Busca Movimento...">

					<input class="form-control form-control-sm mr-sm-2" type="date" name="dataInicial" id="dataInicial" value="<?php echo $agora; ?>">

					<input class="form-control form-control-sm mr-sm-2" type="date" name="dataFinal" id="dataFinal" value="<?php echo date('Y-m-d', strtotime($agora.' +31 days')); ?>" min="">

					<button class="btn btn-outline-secondary btn-sm my-2 my-sm-0" name="btn-buscar" id="btn-buscar"><i class="fas fa-search"></i></button>
				</form>
			</div>
			
		</div>
		
	</div>

	<div class="modal fade" id="modal-pegar-data-liquidacao">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Digite a data da liquidação e lançamento no caixa:</h4>
				</div>
				<div class="modal-body">
					<form method="post" id="form-pegar-data-liquidacao">
						<div class="form-group">
							<label for="data-liquidacao">Data da Liquidação:</label>
							<input class="form-control" type="date" name="data-liquidacao" id="data-liquidacao" value="<?php echo $agora; ?>" max="<?php echo $agora; ?>">
							<input type="hidden" name="id_lancamento" id="id_lancamento">
							<input type="hidden" name="tipo_lancamento" id="tipo_lancamento">
						</div>
						<button type="submit" class="btn btn-primary">Liquidar</button>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
				</div>
			</div>
		</div>
	</div>
	</div>
	<div id="listar"></div>

</div>

<script>
	$(function(){

		var pag = "<?=$pagina?>";
		var hoje = "<?=$agora?>";
		var novo = 0;
		var editando = 0;
		var editado = 0;

		// AJAX PARA LISTAR OS DADOS
		$.ajax({
			url: "acoes/listar.php",
			method: "post",
			data: $('#frm').serialize(),
			dataType: "html",
			success: function(result){
				$('#listar').html(result)
			},
		})

		// SCRIPT PARA LIMITAR A DATA FINAL BASEADO NA INICIAL
		$('#dataInicial').change(function(){
			$('#dataFinal').attr('min', $(this).val());
		});

		// SCRIPT PARA DEIXAR A DATA DE VENCIMENTO IGUAL A DATA DE LANÇAMENTO
		$('#data-lancamento').change(function(){
			$('#data-vencimento').attr('min', $(this).val());
			$('#data-vencimento').val($(this).val());		
		});

		// SCRIPT PARA ADICIONAR/EDITAR LANCAMENTO
		$('#adicionar_lancamento').on('submit', function(e){
			e.preventDefault();
			let txtbuscar = $('#txtbuscar').val();
			let dataInicial = $('#dataInicial').val();
			let dataFinal = $('#dataFinal').val();
			let form = $(this).serialize() +'&txtbuscar='+ txtbuscar +'&dataInicial='+ dataInicial +'&dataFinal='+ dataFinal;

			$.ajax({
				url: "acoes/adicionar_lancamento.php",
				method: "post",
				data: form,
				dataType: "html",
				success: function(html){
					$('#listar').html(html);
					$('.linha'+$('.lastInsertId').val()).css('background-color', '#81F781');
					$('.linha'+$('.lastInsertId').val()+' span.novo').show();
					$('.linha'+$('.lastEditId').val()).css('background-color', '#81F7BE');
					$('.linha'+$('.lastEditId').val()+' span.editado').show();
					novo = $('.lastInsertId').val();
					editado = $('.lastEditId').val();
					$('#movimento').val(null);
					$('#tipo').val('pagar');
					$('#data-lancamento').val(hoje);
					$('#data-pagamento').val('');
					$('#data-vencimento').val(hoje);
					$('#valor').val('');
					$('#editando').val('');
					$('input[name=conta]').val('');
					$('input[name=conta_id]').val('');
					$('#collapse-inserir-lancamento').collapse('hide');
				},
			})
		})

		// SCRIPT PARA EDITAR LANÇAMENTO

			// PREENCHER CAMPOS PARA EDIÇÃO
			$(document).on('click', '#editar_lancamento', function(e){
				e.preventDefault();
				let id = $(this).attr('data-id');
				$('.linha'+id).css('background-color', '#F7FE2E');
				$('.linha'+id+' span.editando').show();
				$('.linha'+novo+' span.novo').hide();
				$('.linha'+editado+' span.editado').hide();
				
				if(id != editando) {
					$('.linha'+editando).css('background-color', 'transparent');
					$('.linha'+editando+' span.editando').hide();
				}
				if(id != novo) {
					$('.linha'+novo).css('background-color', 'transparent');
				}
				if(id != editado) {
					$('.linha'+editado).css('background-color', 'transparent');
				}

				$('#editando').val(id);
				editando = id;
				$('.btn-salvar').html('Salvar');
				
				$.ajax({
					url: "acoes/editar_lancamento.php",
					method: "post",
					data: {id},
					dataType: "json",
					success: function(json){
						let vlr = parseFloat(json.valor);
						$('#movimento').val(json.movimento);
						$('#tipo').val(json.tipo).focus();
						$('#data-lancamento').val(json.data_lancamento);
						$('#data-pagamento').val(json.data_pagamento);
						$('#data-vencimento').val(json.data_vencimento);
						$('#valor').val(numberToReal(vlr));
						$('input[name=conta_id]').val(json.id_conta);
						$('input[name=conta]').val(json.conta_nome);
						$('#data-vencimento').removeAttr('disabled');
						$('#collapse-inserir-lancamento').collapse('show');
					},
				})
			})

			// SAIR DA EDIÇÃO SEM SALVAR
			$('.btn-cancelar').click(function(e){
				e.preventDefault();
				$('input[name=conta_id]').val('');
				$('input[name=conta]').val('');
				$('#data-vencimento').attr('disabled', 'disabled');
				$('#movimento').val(null);
				$('#tipo').val('pagar');
				$('#data-lancamento').val(hoje);
				$('#data-vencimento').val(hoje);
				$('#data-pagamento').val('');
				$('#valor').val('');
				$('#editando').val('');
				$('.linha'+novo).css('background-color', 'transparent');
				$('.linha'+novo+' span.novo').hide();
				$('.linha'+editando).css('background-color', 'transparent');
				$('.linha'+editando+' span.editando').hide();
				$('.linha'+editado).css('background-color', 'transparent');
				$('.linha'+editado+' span.editado').hide();
				$('#collapse-inserir-lancamento').collapse('hide');
			})

		function numberToReal(numero) {
			var numero = numero.toFixed(2).split('.');
			numero[0] = numero[0].split(/(?=(?:...)*$)/).join('.');
			return numero.join(',');
		}

		// SCRIPT PARA DELETAR LANÇAMENTO
		$(document).on('click', '#deletar_lancamento', function(e){
			e.preventDefault();
			let id = $(this).attr('data-id');
			let txtbuscar = $('#txtbuscar').val();
			let dataInicial = $('#dataInicial').val();
			let dataFinal = $('#dataFinal').val();
			let pagina = pag;
			
			if(confirm('Confirma a deleção do lançamento?')) {
				$('.linha'+id).css('background-color', '#FE2E2E');
				$('.linha'+id).animate({opacity: '0'}, '1000');
				setTimeout(() => {
					$.ajax({
						url: "acoes/deletar_lancamento.php",
						method: "post",
						data: {id, dataInicial, dataFinal, txtbuscar, pagina},
						dataType: "html",
						success: function(result){
							$('#listar').html(result);
						},
					})
				}, 300);
			}
		})

		// SCRIPT PARA LIQUIDAR PAGAMENTO
		$(document).on('click', '#liquidar_lancamento', function(e){
			e.preventDefault();
			$('#modal-pegar-data-liquidacao').modal();
			$('#id_lancamento').val($(this).attr('data-id'));
			$('#tipo_lancamento').val($(this).attr('data-tipo'));
		});

		$('#form-pegar-data-liquidacao').submit(function(e){
			e.preventDefault();
			$('#modal-pegar-data-liquidacao').modal('hide');

			let id = $('#id_lancamento').val();
			let tipo = $('#tipo_lancamento').val();
			let data_liquidacao = $('#data-liquidacao').val();
			let txtbuscar = $('#txtbuscar').val();
			let dataInicial = $('#dataInicial').val();
			let dataFinal = $('#dataFinal').val();
			let pagina = $('input[name=pagina]').val();
			
			if(confirm('Confirma a liquidação do lançamento?')) {
				$('.linha'+id).css('background-color', '#0B614B');
				$('.linha'+id).animate({opacity: '0'}, '1000');
				setTimeout(() => {
					$.ajax({
						url: "acoes/liquidar_lancamento.php",
						method: "post",
						data: {id, tipo, data_liquidacao, txtbuscar, dataInicial, dataFinal, pagina},
						dataType: "html",
						success: function(result){
							$('#listar').html(result);
						},
					})
				}, 300);
			}
		});

		// AJAX PARA BUSCAR OS DADOS
		$('#btn-buscar').click(function(event){
			event.preventDefault();	
			$.ajax({
				url: "acoes/listar.php",
				method: "post",
				data: $('form').serialize(),
				dataType: "html",
				success: function(result){
					$('#listar').html(result)
				},
			})
		})

		// AJAX PARA BUSCAR OS DADOS PELA TXT
		$('#txtbuscar').keyup(function(){
			$('#btn-buscar').click();
		})

		// <!--AJAX PARA BUSCAR OS DADOS PELA DATA INICIAL -->
		$('#dataInicial').change(function(){
			$('#btn-buscar').click();
		})

		// <!--AJAX PARA BUSCAR OS DADOS PELA DATA FINAL -->
		$('#dataFinal').change(function(){
			$('#btn-buscar').click();
		})

		// <!-- SCRIPTS MASK -->
		$('#valor').mask('000.000.000,00', {reverse:true});
		
	});

	// <!-- SCRIPT PARA BUSCAR CONTA PELO NOME -->
	function selectConta(obj) {
		var id = $(obj).attr('data-id');  
		var name = $(obj).html();

		$('.searchresults_conta').hide();
		$('input[name=conta]').val(name);
		$('input[name=conta_id]').val(id);
	}
	$(function(){
		// Consultar e pegar nome da Conta
		$('input[name=conta]').keyup(function(){
			var q = $(this).val();

			if (q.length < 1) {
				$('.searchresults_conta').hide();
				$('input[name=add_conta_id]').val('');
			}

			if (q.length > 0) {

				$.ajax({
					url:"acoes/listar_contas.php",
					type:"get",
					data: {q:q},
					dataType:"json",
					befoneSend:function() {},
					success:function(json) {
						let linha = 0;
						let selecionada = 0;
						
						if( $('.searchresults_conta').length == 0 ) {
							$('input[name=conta]').after('<div class="searchresults_conta" class="d-box"></div>');
						}
						var res_width = $('input[name=conta]').css('width');
						$('.searchresults_conta').css('width', res_width);

						var html = '';

						for(var i in json) {
							html += '<div class="si" id="linhaNr'+(linha+1)+'"><a href="javascript:;" onclick="selectConta(this)" data-id="'+json[i].id+'"">'+json[i].nome+'</a></div>';
							linha++;
						}

						$('.searchresults_conta').html(html);
						$('.searchresults_conta').show();
						$('input[name=add_conta_id]').val('');
					}
				});

			}

		});
	})

</script>