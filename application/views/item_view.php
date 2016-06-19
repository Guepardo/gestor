<!DOCTYPE html>
<html>
<head>
	<title>Itens</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.2.3/foundation.min.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/motion-ui/1.1.1/motion-ui.min.css" />

	<style type="text/css">
		body{
			font-family: 'Open Sans', sans-serif !important;

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

		td, th {
			padding: 3px !important;
		}

		table{
			font-size:13px;
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
				<li><a href="garcom">Carçons</a></li>
				<li><a href="item">Itens</a></li>
				<li><a href="pedido">Pedidos</a></li>
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
			<h2>Itens</h2>
		</div>
	</div>
	<!-- Label -->

	<!-- Funções -->
	<div class="row fix">
		<div class="medium-12 columns">
			<button class="button" data-toggle="cadastrar">Novo</button>
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
						<th>Login</th>
						<th>Valor R$</th>
						<th width="150">Ação</th>
						<th width="150">Ação</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($itens as $value){?> 		
					<tr>
						<td><?php echo $value->id; ?></td>
						<td><?php echo $value->nome; ?></td>
						<td><?php echo $value->valor; ?></td>
						<td><a class="button tiny">Alterar</a></td>
						<td><a class="button tiny deletar" data-delete="<?php echo $value->id; ?>">Excluir</a></td>
					</tr>
					<?php }?> 
				</tbody>
			</table>
		</div>
	</div>
	<!-- Conteúdo -->
	
	<!-- Modal -->
	<div class="reveal" id="cadastrar" data-reveal data-overlay="false">
		
		<div class="row">
			<div class="medium-12 columns">
				<h4>Novo Item</h4>
			</div>	
		</div>

		<form data-abide novalidate>
			<div class="row">
				<div class="medium-12 columns">
					<label>Nome
						<input type="text" name="nome" placeholder="nome" required>
						<span class="form-error">Este campo é obrigatório.</span>
					</label>
				</div>	
			</div>

			<div class="row">
				<div class="medium-12 columns">
					<label>Valor
						<input type="number" name="valor" required>
						<span class="form-error">Este campo é obrigatório.</span>
					</label>
				</div>	
			</div>

			<div class="row">
				<div class="medium-12 columns">
					<label>Confirmação
						<textarea required name="descricao" placeholder="Descreva o produto aqui." style="height:200px" ></textarea>
						<span class="form-error">Este campo é obrigatório.</span>
					</label>
				</div>	
			</div>

			<div class="row">
				<div class="medium-12 columns">
					<button type="submit" class="button" >Cadastrar</button>
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

			$(document)
			.on("formvalid.zf.abide", function(ev,form) {
				var data = $(form).serializeArray();

				$.post('i/cadastrar', data)
				.done(function(data){
					data = JSON.parse(data); 

					if(data.status)
						alertify.success(data.msg); 
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

			      $.post('i/deletar',{ id : value}). 
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

	</script>
</body>
</html>