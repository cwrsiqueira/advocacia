<?php 
$pagina = 'contas';
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
</style>

<div class="container">
	<h4>Plano de Contas</h4>
	<div class="nao-imprimir">

		<div class="row">

			<form method="POST" id="adicionar_conta" class="form-field">

				<input type="hidden" id="pag"  name="pag" value="<?php echo @$_GET['pagina'] ?>">
				<input type="hidden" id="itens"  name="itens" value="<?php echo @$itens_por_pagina; ?>">
				<input type="hidden" name="pagina" value="<?php echo $pagina; ?>">
				
				<div class="row">
					
					<div class="col-sm">
						<div class="form-group">
							<label for="nome">Conta:</label>
							<input type="text" name="nome" id="nome" class="form-control" placeholder="Nome da Conta" required>
							<input type="hidden" name="id_conta" id="id_conta" value="">
						</div>
					</div>
					<div class="col-sm-2 btn-add-lanc">
						<div class="form-group">
							<button type="submit" class="btn btn-sm btn-primary form-control btn-salvar">Incluir</button>
						</div>
					</div>
				</div>
			</form>

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

						<a class="btn btn-sm btn-secondary m-3" href="<?php echo BASE_URL; ?>financeiro/index.php?acao=contas">Limpar Buscas</a>

						<input type="text" name="txtbuscar" id="txtbuscar" class="form-control form-control-sm mr-sm-2" placeholder="Busca Movimento...">

						<button class="btn btn-outline-secondary btn-sm my-2 my-sm-0" name="btn-buscar" id="btn-buscar"><i class="fas fa-search"></i></button>
					</form>
				</div>
				
			</div>
			
		</div>
		
	</div>
	
	<div id="listar"></div>

</div>

<script>
	$(function(){

		var base_url = "<?=BASE_URL?>";
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
		});

		// SCRIPT PARA ADICIONAR/EDITAR CONTAS
		$('#adicionar_conta').on('submit', function(e){
			e.preventDefault();
			let txtbuscar = $('#txtbuscar').val();
			let form = $(this).serialize();

			$.ajax({
				url: pag + "/adicionar_conta.php",
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
					$('#nome').val('');
					$('#id_conta').val('');
					$('#editando').val('');
				},
			})
		})

		// SCRIPT PARA EDITAR LANÇAMENTO

			// PREENCHER CAMPOS PARA EDIÇÃO
			$(document).on('click', '#editar_conta', function(e){
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
				$('.btn-salvar').html('Salvar')
				
				$.ajax({
					url: pag + "/editar_conta.php",
					method: "post",
					data: {id},
					dataType: "json",
					success: function(json){
						$('#nome').val(json.nome);
						$('input[name=id_conta]').val(json.id).focus();
					},
				})
			})

		// SCRIPT PARA DELETAR LANÇAMENTO
		$(document).on('click', '#deletar_conta', function(e){
			e.preventDefault();
			let id = $(this).attr('data-id');
			let txtbuscar = $('#txtbuscar').val();
			let pagina = pag;
			
			if(confirm('Confirma a deleção da conta?')) {
				$('.linha'+id).css('background-color', '#FE2E2E');
				$('.linha'+id).animate({opacity: '0'}, '1000');
				setTimeout(() => {
					$.ajax({
						url: pag + "/deletar_conta.php",
						method: "post",
						data: {id, txtbuscar, pagina},
						dataType: "html",
						success: function(result){
							$('#listar').html(result);
						},
					})
				}, 300);
			}
		})

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
		
	});

</script>