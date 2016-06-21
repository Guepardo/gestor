<!DOCTYPE html>
<html>
<head>
	<title>Pedido</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.2.3/foundation.min.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/motion-ui/1.1.1/motion-ui.min.css" />

	<style type="text/css">
		body{
			font-family: 'Open Sans', sans-serif !important;
			overflow: auto !important;
		}

		h1, h2, h3, h4, h5, h6 {
			font-family: 'Open Sans', sans-serif !important;
		}

		.fix{
			margin-top:20px;
		}
		
		.fix button{
			margin-bottom: 20px;
		}

		.button{
			margin:0;
		}

		#lista span{
			font-size: 12px;
			border: solid black 1px;
			border-radius: 10px;
			padding: 3px;
			margin: 2px;
			display: inline-block;
		}

		#lista{
			margin: 20px 0 20px 0; 
		}

		td, th {
			padding: 3px !important;
		}

		table{
			font-size:13px;
		}
		
		.reveal.without-overlay {
			position: absolute;
			/* overflow: auto; */
		}
	</style>
</head>
<body>
	<!-- Menu -->
	<div class="top-bar">
		<div class="top-bar-left">
			<ul class="menu">
				<li class="menu-text">Logo</li>
				<li><a href="home">Home</a></li>
				<li class="active"><a href="pedido">Pedidos</a></li>
				<li><a href="garcom">Garçons</a></li>
				<li><a href="item">Itens</a></li>
				<li><a href="cliente">Clientes</a></li>
			</ul>
		</div>
		<div class="top-bar-right">
			<ul class="dropdown menu" data-dropdown-menu>
				<li><?php echo $this->session->userdata('login'); ?></li>
				<li>
					<a href="#"></a>
					<ul class="menu vertical">
						<li><a href="a/sair">Sair</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<!-- Menu -->

	<!-- Label -->
	<div class="row fix">
		<div class="medium-12 columns">
			<h3>Pedido</h3>
		</div>
	</div>
	<!-- Label -->

	<!-- Funções -->
	<div class="row fix">
		<div class="medium-12 columns">
			<button class="button" data-toggle="cadastrar">Novo <i class="fa fa-plus" aria-hidden="true"></i></button>
		</div>
	</div>
	<!-- Funções -->

	<!-- Conteúdo -->
	<div class="row">
		<div class="medium-12 columns">
			<table>
				<thead>
					<tr>
						<th width="200">Id</th>
						<th>Status</th>
						<th>Nª Mesa</th>
						<th width="150">Valor</th>
						<th width="150">Ação</th>
						<th width="150">Ação</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($pedidos as $pedido){?> 		
						<tr>
							<td><?php echo $pedido['id']; ?></td>
							<td><?php echo $pedido['status']; ?></td>
							<td><?php echo $pedido['numero_mesa']; ?></td>
							<td><?php echo $pedido['valor']; ?></td>
							<td><a class="button tiny">Alterar</a></td>
							<td><a class="button tiny deletar" data-delete="<?php echo $pedido['id']; ?>">Excluir</a></td>
						</tr>
						<?php }?> 
					</tbody>
				</table>
			</div>
		</div>
		<!-- Conteúdo -->

		<!-- Modal -->
		<div class="reveal" id="cadastrar" data-reveal data-overlay="true">

			<div class="row">
				<div class="medium-12 columns">
					<h4>Novo Pedido</h4>
				</div>	
			</div>

			<form data-abide novalidate>
				<div class="row">
					<div class="medium-12 columns">
						<label>Nª Mesa
							<input type="number" name="numero_mesa" max="10" min="1" placeholder="Numeração da mesa" required>
							<span class="form-error">Este campo é obrigatório.</span>
						</label>
					</div>	
				</div>

				<div class="row">
					<div class="medium-12 columns">
						<label>Descrição	
							<textarea row="100" required name="descricao" ></textarea>
							<span class="form-error">Este campo é obrigatório.</span>
						</label>
					</div>	
				</div>

				<div class="row">
					<div class="medium-6 columns">
						<label>Cliente
							<select name="cliente_id" required >
								<option value=''>--Selecione--</option>
								<?php foreach( $todosClientes as $cliente){ ?>
									<option value='<?php echo $cliente->id;?>'> <?php echo $cliente->nome; ?></option>
									<?php } ?> 
								</select>
								<span class="form-error">Selecione um cliente.</span>
							</label>

						</div>	
					</div>

					<hr />

					<!-- Adicionar itens -->
					<div class="row">
						<div class="medium-6 columns">
							<label>Item
								<select id="item">
									<option value="-1">--Selecione--</option>
									<?php foreach($todosItens as $item) {?>
										<option value="<?php echo $item->id ?>" data-valor="<?php echo $item->valor;?>">
											<?php echo $item->nome; ?></option>
											<?php }?>
										</select>
									</label>
								</div>

								<div class="medium-5 columns">
									<label>Quantidade
										<input id="qtd" type="number" max="40" min="1" value="1">
									</label>
								</div>
							</div>


							<div class="row">
								<div class="medium-12 columns">
									<a id="add" class="button small">Add ao Pedido <i class="fa fa-plus" aria-hidden="true"></i></a>
								</div>
							</div>	

							<!-- lista-->
							<div class="row">
								<div id="lista" class="medium-12 columns">

								</div>
							</div>	

							<!-- lista-->
							<div class="row">
								<div class="medium-12 columns">
									<small id="valor">Valor total: R$0</small>
								</div>
							</div>	
							<!-- Adicionar itens -->

							<div class="row">
								<div class="medium-12 columns">
									<button type="submit" class="button">Cadastrar</button>
								</div>	

							</div>
						</form>

						<button class="close-button" data-close aria-label="Close reveal" type="button">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<!-- Modal -->
					
					<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
					<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.2.3/foundation.min.js"></script>
					<script src="https://cdn.rawgit.com/alertifyjs/alertify.js/v1.0.10/dist/js/alertify.js"></script>

					<script type="text/javascript">
						$(document).foundation();

						$(document).ready(function(){


						//Adicionar itens
						var itens = new Array(); 
						var total = 0; 

						$("#add").click(function(){
							var qtd      = $('#qtd').val(); 
							var itemId   = $('#item').find(":selected").val(); 
							var itemNome = $('#item').find(":selected").text(); 
							var valor    = $('#item').find(":selected").data('valor'); 


							if(itemId == '-1'){
								alertify.log("Selecione um item antes de adicionar."); 
								return; 
							}

							var object ={
								item_id: itemId, 
								qtd    : qtd
							}; 

							for(var item of itens ){
								if(itemId == item.item_id){
									alertify.error("Este item já está incluso."); 
									return;
								}
							}

							qtd   = parseInt(qtd); 
							valor = parseFloat(valor); 

							var label = itemNome+" - ("+qtd+"*"+valor+") = R$"+ qtd * valor; 

							total += qtd * valor; 
							$('#valor').text("Valor total: R$ "+ total); 
							$("#lista").append("<span>"+label+"</span>"); 

							itens.push(object);
						}); 


						$(document)
						.on("formvalid.zf.abide", function(ev,form) {
							var data = $(form).serializeArray();

							for(var item of itens ){

								var value = item.item_id+"-"+item.qtd; 
								var temp ={
									name: 'item[]', 
									value: value
								}; 

								data.push(temp); 
							}

							$.post('p/criar', data)
							.done(function(data){
								data = JSON.parse(data); 

								if(data.status){
									alertify.success(data.msg); 
									reload(1000); 
								}
								else
									alertify.error(data.msg); 
							}); 
						})
						.on("submit", function(ev){ev.preventDefault();});


						$('.deletar').click(function(){
							var value = $(this).data('delete'); 

							var self = this; 

							alertify
							.okBtn("Aceitar")
							.cancelBtn("Cancelar")
							.confirm("Você tem certeza que deseja apagar este garçom?", function (ev) {

								$.post('g/deletar',{ id : value}). 
								done(function(data){
									data = JSON.parse(data);

									if(data.status){
										alertify.success(data.msg); 
										$(self).parent().parent().remove(); 
									}
									else
										alertify.error(data.msg); 
								}); 
								ev.preventDefault();
							}, function(ev) {
								ev.preventDefault();
								alertify.error("Opereção cancelada.");
							});
						}); 
					}); 

						function reload(timeout){
							setTimeout(function(){
								location.reload(); 
							},timeout); 
						}

					</script>
				</body>
				</html>