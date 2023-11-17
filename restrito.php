<?php 
require_once("autentica.php");
require_once("conecta.php");

$msg = "";
if (isset($_GET["msg"])){
    $msg = $_GET["msg"];
}

$msg2 = "";
if (isset($_GET["msg2"])){
    $msg2 = $_GET["msg2"];
}

if(isset($_GET["error_menssagens"])){
    $error_menssagens= $_GET["error_menssagens"];
}
else{
    $error_menssagens = "";
}

$id = "";
if(!isset($_SESSION))
	session_start();
$id = $_SESSION['id_usuario'];

try {
	$stmt = $conn->prepare("SELECT * FROM `usuarios` WHERE `id` = :id");
	$stmt->bindParam("id",$id);
	$stmt->execute();

	$res = $stmt->fetchAll();
	
	if(count($res) > 0) {	
		foreach ($res as $row) {
			$nome = $row['nome'];
			$email = $row['email'];
			$senha = $row['senha'];
		}
  }
  else {
      header("Location:index.php");
  }

} catch(PDOException $e) {
  // echo "Connection failed: " . $e->getMessage();
}

$conn = null;
$stmt = null;

?>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Área do Usuário</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <style>
            #container {
                background: white;
                display:none;
            }

            .button {
              background-color: #4CAF50;
              border: none;
              color: white;
              padding: 15px 32px;
              text-align: center;
              text-decoration: none;
              display: inline-block;
              font-size: 16px;
              margin: 4px 2px;
              cursor: pointer;
            }
        </style>
    </head>
    <body>
        <div class="container mx-auto bg-light mt-1 w-90">
            <section class="row">
                <article class="col-12">
					<div class="col-12">
                        <nav class="navbar navbar-expand-md navbar-light">
	                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#conteudoNavbarSuportado" aria-controls="conteudoNavbarSuportado" aria-expanded="false">
	                            <span class="navbar-toggler-icon"></span>
	                        </button>
	                        <div class="collapse navbar-collapse" id="conteudoNavbarSuportado">
	                            <ul class="navbar-nav mx-auto">
	                                <li class="nav-item">
	                                    <a class="nav-link" href="restrito.php">Área do Usuário</a>
	                                </li>
	                                <li class="nav-item">
	                                    <a class="nav-link" href="sair.php">Logout</a>
	                                </li>
	                            </ul>
	                        </div> 
                        </nav>    
                    </div>
                    <p style="color:red; background:moccasin;">
                    <?php 
                    echo $error_menssagens;
                    ?></p>
                    <p style="color:red; background:moccasin;">
                    	<?php echo $msg; ?>
                    	<?php echo $msg2; ?>
                	</p>
                    <div class="col-12">
						<h5 class="text-center">Área do Usuário.</h5>
						<h5 class="text-center">Bem-Vindo <?= $nome ?></h5>
					</div>
					<div class="col-10 offset-sm-2" id="alterarNome">
						<p style="cursor: pointer;"><a href="#" class="link-underline-primary">Clique aqui para alterar seu nome.</a></p>
					</div>
					<form class="needs-validation" novalidate action="altera_dados.php" method="post" id="formNome" style="display: none;">
						<div class="form-group row">
							<label for="nome" class="col-sm-2 col-form-label col-form-label-sm">Novo Nome</label>
							<div class="col-sm-10">
								<input type="text" class="form-control form-control-sm" name="nome" id="nome" placeholder="Digite seu nome" minlength="3" maxlength="50" value="<?php echo $nome ?>" required>
								<div class="valid-feedback">
									Tudo certo!
								</div>
								<div class="invalid-feedback">
									O campo nome deve conter entre 3 e 50 caracteres.
								</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-10 offset-sm-2">
								<button type="submit" class="btn btn-primary my-1">Enviar</button>
							</div>
						</div>
					</form>
					<div class="col-10 offset-sm-2" id="alterarSenha">
						<p style="cursor: pointer;"><a href="#" class="link-underline-primary">Clique aqui para alterar sua senha.</a></p>
					</div>
					<form class="needs-validation" novalidate action="altera_dados.php" method="post" oninput='confirmar_senha.setCustomValidity(confirmar_senha.value != senha.value ? "Os campos de senha e confirmação de senha não conferem" : "")' id="formSenha" style="display: none;">
						<div class="form-group row">
							<label for="senha" class="col-sm-2 col-form-label col-form-label-sm">Nova Senha</label>
							<div class="col-sm-10">
								<div class="input-group">
									<input type="password" class="form-control form-control-sm" name="senha" id="senha" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!-*,@<>;:?=_,+])(?!.*(.)\1{1}).{8,}" placeholder="Nova Senha" required>
									<div class="input-group-append">
                                        <span class="input-group-text" id="olhoSenha" style="cursor: pointer;" onclick="toggleSenhaVisibility('senha', 'olhoSenha')">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </span>
                                    </div>
									<div class="valid-feedback">
										Tudo certo!
									</div>
									<div class="invalid-feedback">
										A senha deve conter no mínimo 8 dígitos com letras maiúsculas e minúsculas, números, caracteres especiais e não conter sequências.
									</div>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label for="confirmar_senha" class="col-sm-2 col-form-label col-form-label-sm">Confirmação de Senha</label>
							<div class="col-sm-10">
								<div class="input-group">
									<input type="password" class="form-control form-control-sm" name="confirmar_senha" id="confirmar_senha" placeholder="Confirme sua Senha" required>
									<div class="input-group-append">
                                        <span class="input-group-text" id="olhoConfirmarSenha" style="cursor: pointer;" onclick="toggleSenhaVisibility('confirmar_senha', 'olhoConfirmarSenha')">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </span>
                                    </div>
									<div class="valid-feedback">
										Tudo certo!
									</div>
									<div class="invalid-feedback">
										Campo confirmação de senha e o campo senha não conferem.
									</div>
                                </div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-10 offset-sm-2">
								<button type="submit" class="btn btn-primary my-1">Enviar</button>
							</div>
						</div>
					</form>
					<div class="container">
	                    <div class="form-group row">             
					        <div class="col-sm-10 offset-sm-2">
					            <a href="sair.php" class="btn btn-info" role="button">Logout</a>
					        </div>	 	
					    </div>
						<div class="form-group row">
						    <div class="col-sm-10 offset-sm-2">
						        <a href="#" class="btn btn-danger" role="button" id="btn-excluir-conta">Excluir sua Conta*</a>
						    </div>
						    <div class="col-sm-10 offset-sm-2">
						        <p id="mensagem-cuidado">*Ao clicar neste botão sua conta será excluída e todos os seus dados serão apagados.</p>
						    </div>
						</div>
					</div>
				</article>
			</section>
			<footer class="row">
				<div class="col-sm-4">
					<p>&copy; Copyright <span id="ano"></span></p>
				</div>
			</footer>
		</div>
		<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
		<script>
		    $(document).ready(function () {
		        $("#btn-excluir-conta").click(function () {
		            if (confirm("Tem certeza de que deseja excluir sua conta? Esta ação é irreversível.")) {
		                window.location.href = "excluir.php";
		            } else {
		                return false;
		            }
		        });
		    });
		</script>
        <script>
        	(function () {
                'use strict';
                window.addEventListener('load', function() {
                    var forms = document.getElementsByClassName("needs-validation");
                    var validation = Array.prototype.filter.call(forms, function(form) {
                        form.addEventListener("submit", function(event) {
                            if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                            } 
                            form.classList.add("was-validated");
                        }, false);
                    });
            }, false);
            })();
            document.getElementById('ano').textContent = new Date().getFullYear();
        </script>
		<script>
			function toggleFormVisibility(formId) {
				var form = document.getElementById(formId);

				if (form.style.display === 'none' || form.style.display === '') {
					form.style.display = 'block';
				} else {
					form.style.display = 'none';
				}
			}

			document.getElementById('alterarNome').addEventListener('click', function() {
				toggleFormVisibility('formNome');
			});

			document.getElementById('alterarSenha').addEventListener('click', function() {
				toggleFormVisibility('formSenha');
			});
        </script>
        <script>
            function toggleSenhaVisibility(id, olhoId) {
                var senhaInput = document.getElementById(id);
                var olhoIcon = document.getElementById(olhoId);

                if (senhaInput.type === 'password') {
                    senhaInput.type = 'text';
                    olhoIcon.innerHTML = '<i class="fa fa-eye-slash" aria-hidden="true"></i>';
                } else {
                    senhaInput.type = 'password';
                    olhoIcon.innerHTML = '<i class="fa fa-eye" aria-hidden="true"></i>';
                }
            }
        </script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <noscript>Atualize seu navegador</noscript>
    </body>
</html>