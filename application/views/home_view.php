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
			height: 140px;
			overflow-y: scroll;
		}

		ul{
			font-size: 10px;
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

	<!-- Funções -->
	<div class="row">
		<div class="medium-12 columns">
			<h3>Visão geral</h3>
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
									$retorno .= $item->nome."-(".$item->valor."*".$item->quantidade.") = R$". $item->valor * $item->quantidade; 
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
						<button class="button tiny">Função</button>
						<button class="button tiny">Função</button>
						<button class="button tiny">Função</button>
						<button class="button tiny">Função</button>
					</div>
				</div>
			</div>
			<!-- Mesa 1 -->
			<?php } ?> 
		</div>


		<!-- Overview -->

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.2.3/foundation.min.js"></script>
		<script type="text/javascript">
			$(document).foundation();
		</script>
	</body>
	</html>