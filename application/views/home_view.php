<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.2.3/foundation.min.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/motion-ui/1.1.1/motion-ui.min.css" />

	<style type="text/css">
		.box h1{
			text-align: center; 
		}

		body{
			font-family: 'Open Sans', sans-serif !important;

		}

		h1, h2, h3, h4, h5, h6 {
			font-family: 'Open Sans', sans-serif !important;
		}

		.itens{
			height: 100px;
			overflow-y: scroll;
		}

		.itens ul{
			font-size: 10px;
		}

		.fix{
			margin-top:20px;
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

	</style>
</head>
<body>
	
	<!-- Menu -->
	<div class="top-bar">
		<div class="top-bar-left">
			<ul class="menu">
				<li class="menu-text">Logo</li>
				<li><a href="pedido">Pedidos</a></li>
				<li><a href="home">Home</a></li>
				<li><a href="garcom">Carçons</a></li>
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

	<!-- Funções -->
	<div class="row fix">
		<div class="medium-12 columns">
			<h3>Visão geral das mesas</h3>
		</div>
	</div>
	<!-- Funções -->

	<!-- Overview -->
	<div class="row">

		<!-- Mesa 1 -->
		<?php for($a = 1; $a <= 10; $a++){ ?>

			<?php 
					//Procurando qual é o índice dessa mesa no vetor. 
			$indiceMesa = 0; 
			$achei = false; 
			for($b = 0; $b < count($mesas); $b++ ){
				if($mesas[$b]['pedido']->numero_mesa == $a ){
					$achei = true; 
					break;  
				}
				$indiceMesa++; 
			}

			$temp; 
			if($achei){
				$temp['cliente'] = $mesas[$indiceMesa]['cliente']; 
				$temp['itens'  ] = $mesas[$indiceMesa]['itensPedido']; 
				$temp['pedido' ] = $mesas[$indiceMesa]['pedido']; 
				// var_dump($temp); 
			}

			?>

			<div class="medium-3 columns">
				<div class="callout box <?php echo ($achei) ? "success" : "alert";  ?> ">
					<!-- Número da mesa, informações do cliente, itens do pedido e funcioalidades-->
					<div>
						<h1><?php echo $a; ?></h1>
					</div>

					<div>
						<small>Nome cliente:   <?php echo ($achei)? $temp['cliente']->nome : "Sem cliente"; ?></small> <br>
						<small>Status: <?php echo ($achei)? "<span style='color:red;'>Ocupada</span>" : "<span style='color:green;'>Livre</span>"; ?></small>
					</div>

					<small>Itens do pedido: </small>
					<div class="itens">
						<ul>

							<?php 
							$total =0; 
							if($achei){
								foreach($temp['itens'] as $item ){
									$retorno  = '<li>'; 
									$retorno .= $item->nome." (".$item->valor."*".$item->quantidade.") = R$". $item->valor * $item->quantidade; 
									$retorno .= '</li>'; 

									$total += $item->valor * $item->quantidade; 
									echo $retorno; 
								}
							}
							?>
						</ul>
					</div>

					<div>
						<small>Valor total: R$<?php echo "<span style='color:red;'>".$total."</span>"; ?> </small>
					</div>

					<div>
						<button data-id="<?php echo ($achei) ? $temp['pedido']->id : -1;  ?>" class="liberar button tiny <?php echo ($achei) ? "success" : "disabled";  ?>">Liberar Mesa</button>
						<button data-id="<?php echo ($achei) ? $temp['pedido']->id : -1;  ?>" class="add_item button tiny <?php echo ($achei) ? "secondary" : "disabled";  ?>" >Add Item</button>
					</div>
				</div>
			</div>
			<!-- Mesa 1 -->
			<?php } ?> 
		</div>


		<!-- Overview -->


		<!-- Modal -->
		<div class="reveal" id="add_item" data-reveal data-overlay="true">

			<div class="row">
				<div class="medium-12 columns">
					<h4 >Adicionar ao pedido</h4>
				</div>	
			</div>

			<form data-abide novalidate>
				<!-- Adicionar itens -->
				<div class="row">
					<div class="medium-6 columns">
						<input id="pedido_id" type="hidden" name="pedido_id" value="-1" >
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
								<a id="add" class="button small">Add ao Pedido</a>
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
								<button type="submit" class="button">Adicionar</button>
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

					//Adicionar itens
					var itens = new Array(); 
					var total = 0; 
					$(document).ready(function(){

						$(".add_item").click(function(){

							var idPedido = $(this).data('id'); 
							if(idPedido == -1){
								alertify.log('Não há um pedido para esta mesa.');
								return; 
							}
							
							$('#add_item').foundation('open'); 

							$("#pedido_id").val(idPedido); 
							resumo(idPedido); 
						}); 

						$(document).on('closed.zf.reveal',function () {
							itens = new Array(); 
							total = 0; 

							$('#valor').text("Valor total: R$ 0"); 
							$("#lista").text("");
						});

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
							$("#lista").append("<span style='color:green;border-color:green;'>"+label+"</span>"); 

							itens.push(object);
						}); 


						$('.liberar').click(function(){
							var id = $(this).data('id'); 

							if(id == "-1"){
								alertify.log("Essa mesa já está livre."); 
								return; 
							}

							$.post('h/liberar', { id_pedido: id}). 
							done(function(data){
								data = JSON.parse(data); 

								if(data.status){
									alertify.success(data.msg); 
									reload(1000); 
								}else{
									alertify.error(data.msg); 
								}
							}); 

						}); 

						$(document)
						.on("formvalid.zf.abide", function(ev,form) {
							var data = $(form).serializeArray();

							for(var item of itens ){

								if(item.old)
									continue; 

								var value = item.item_id+"-"+item.qtd; 
								var temp ={
									name: 'item[]', 
									value: value
								}; 

								data.push(temp); 
							}

							$.post('p/adicionar', data)
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
					}); 

					function reload(timeout){
						setTimeout(function(){
							location.reload(); 
						},timeout); 
					}

					function resumo(idPedido){
						$.post('p/itens',{id_pedido: idPedido}). 
						done(function(data){
							data = JSON.parse(data); 

							for(var item of data.data){

								var qtd      = item.quantidade; 
								var itemId   = item.id;
								var itemNome = item.nome; 
								var valor    = item.valor; 

								if(itemId == '-1'){
									alertify.log("Selecione um item antes de adicionar."); 
									return; 
								}

								var object ={
									item_id: itemId, 
									qtd    : qtd,
									old    : true
								}; 

								qtd   = parseInt(qtd); 
								valor = parseFloat(valor); 

								var label = itemNome+" - ("+qtd+"*"+valor+") = R$"+ qtd * valor; 

								total += qtd * valor; 
								$('#valor').text("Valor total: R$ "+ total); 
								$("#lista").append("<span>"+label+"</span>"); 
								itens.push(object);
							}
							
						}); 
					}
				</script>
			</body>
			</html>