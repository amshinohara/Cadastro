<?php
$msg = "";
if (isset($_GET["msg"])){
    $msg = $_GET["msg"];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Login</title>
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
                                        <a class="nav-link" href="index.php">Login</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="form.php">Formulário de Cadastro</a>
                                    </li>
                                </ul>
                            </div> 
                        </nav>    
                    </div>
                    <h2 id="formulario">Login</h2>
                    <form class="needs-validation" novalidate action="process_login.php" method="post">
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label col-form-label-sm">E-mail</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control form-control-sm"  name="email" id="email" placeholder="Digite seu email" value="<?php echo isset($_COOKIE['email']) ? $_COOKIE['email'] : ''; ?>" required>
                                <div class="valid-feedback">
                                    Tudo certo!
                                </div>
                                <div class="invalid-feedback">
                                    Verifique o preenchimento do campo e-mail.
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="senha" class="col-sm-2 col-form-label col-form-label-sm">Senha</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input type="password" class="form-control form-control-sm" name="senha" id="senha" placeholder="Digite sua Senha" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="olho" style="cursor: pointer;" onclick="toggleSenhaVisibility()">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <div class="valid-feedback">
                                        Tudo certo!
                                    </div>
                                    <div class="invalid-feedback">
                                        Digite sua Senha
                                    </div>
                                </div>
                                <div>
                                    <input type="checkbox" id="lembrar" name="lembrar">
                                    <label for="lembrar">Salvar dados de acesso</label>
                                </div> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10 offset-sm-2">
                                <button type="submit" class="btn btn-primary my-1">Enviar</button>
                                <p><a href="form.php">Cadastrar novo usuário</a></p>
                            </div>
                            <div class="col-sm-10 offset-sm-2">
                                <p style="color:red; background:moccasin;">
                                    <?php echo $msg; ?>
                                </p>
                            </div>
                        </div>
                    </form>
                </article>
            </section>
            <footer class="row">
                <div class="col-sm-4">
                    <p>&copy; Copyright <span id="ano"></span></p>
                </div>
            </footer>
        </div>
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
            var senhaInput = document.getElementById('senha');
            var olhoIcon = document.getElementById('olho');

            function toggleSenhaVisibility() {
                if (senhaInput.type === 'password') {
                    senhaInput.type = 'text';
                    olhoIcon.innerHTML = '<i class="fa fa-eye-slash" aria-hidden="true"></i>';
                } else {
                    senhaInput.type = 'password';
                    olhoIcon.innerHTML = '<i class="fa fa-eye" aria-hidden="true"></i>';
                }
            }
        </script>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <noscript>Atualize seu navegador</noscript>
    </body>
</html>