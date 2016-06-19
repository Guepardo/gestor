<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.2.3/foundation.min.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/motion-ui/1.1.1/motion-ui.min.css" />

	<style type="text/css">
		#box-login{
			margin-top:30px;
			background: #fefefe;
			border: solid 1px #8a8a8a;
			border-radius: 3px;
		}

		#direitos{
			text-align:center;
		}

		#logo img{
			display: inline-block;
			text-align: center; 
		}

		#bloqueado{
			margin-top:20px;
		}

	</style>
</head>
<body>
	

	<div class="row">
		<!-- BoxLogin-->
		<div id="box-login" class="medium-3 medium-centered columns">
			<form data-abide novalidate>
				<!-- logo marca do software -->
				<div id="logo" class="row">
					<div class="medium-12 columns">
						<img src="https://upload.wikimedia.org/wikipedia/commons/a/ab/Logo_TV_2015.png" alt="logo do software/empresa" />
					</div>		
				</div>

				<div class="row">
					<div class="medium-12 columns">
						<label>Login
							<input type="text" name="login" placeholder="login" required >
							<span class="form-error">Este campo é obrigatório.</span>
						</label>
					</div>		
				</div>

				<div class="row">
					<div class="medium-12 columns">
						<label>Senha
							<input type="password" name="senha" required>
							<span class="form-error">Este campo é obrigatório.</span>
						</label>
					</div>		
				</div>

				<div class="row">
					<div class="medium-12 columns">
						<button type="submit" class="button expanded">Login</button>
					</div>		
				</div>

				<!-- Seção de direitos -->
				<div id="direitos" class="row">
					<div class="medium-12 columns">
						<small><i>Allyson Maciel 2016</i></small>
					</div>			
				</div>

			</form>
		</div>
		<!-- BoxLogin-->
	</div>

	<div id="bloqueado" class="row">
		<!-- BoxLogin-->
		<div class="medium-3 medium-centered columns <?php echo (!$this->session->flashdata('bloqueado'))? "hide": ""; ?>">
			<div class="callout alert text-justify">
				<p>Você não tem permissão para utilizar essa função. Por favor, efetue o login.</p>
			</div>
		</div>
		<!-- BoxLogin-->
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.2.3/foundation.min.js"></script>
	<script src="https://cdn.rawgit.com/alertifyjs/alertify.js/v1.0.10/dist/js/alertify.js"></script>
	<script type="text/javascript">
		$(document).foundation();

		$(document).ready(function(){
			$(document)
			.on("formvalid.zf.abide", function(ev,form) {
				var data = $(form).serializeArray();

				$.post('a/autenticar', data)
				.done(function(data){
					data = JSON.parse(data); 

					if(data.status)
						window.location.href = "home";  
					else
						alertify.error(data.msg); 
				}); 
			})
			.on("submit", function(ev){ev.preventDefault();});			
		}); 
	</script>
</body>
</html>