<?php 

if(isset($_GET["error_menssagens"])){
    $error_menssagens= $_GET["error_menssagens"];
}
else{
    $error_menssagens = "";
}

if(isset($_GET["nome"])){
    $nome = $_GET["nome"];
}
else{
    $nome = "";
}

if(isset($_GET["email"])){
    $email = $_GET["email"];
}
else{
    $email = "";
}

if(isset($_GET["senha"])){
    $senha = $_GET["senha"];
}
else{
    $senha = "";
}

if(isset($_GET["confirmar_senha"])){
    $confirmar_senha = $_GET["confirmar_senha"];
}
else{
    $confirmar_senha = "";
}

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Formulário de Cadastro</title>
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
                    <h2 id="formulario">Formulário de Cadastro</h2>
                    <p style="color:red; background:moccasin;">
                    <?php 
                    echo $error_menssagens;
                    ?></p>
                    <form class="needs-validation" novalidate action="recebe_dados.php" method="post" oninput='confirmar_senha.setCustomValidity(confirmar_senha.value != senha.value ? "Os campos de senha e confirmação de senha não conferem" : "")'>
                        <div class="form-group row">
                            <label for="nome" class="col-sm-2 col-form-label col-form-label-sm">Nome*</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control form-control-sm" name="nome" id="nome" placeholder="Digite seu nome" required minlength="3" maxlength="50" value="<?php echo $nome ?>">
                                <div class="valid-feedback">
                                    Tudo certo!
                                </div>
                                <div class="invalid-feedback">
                                    O campo nome deve conter entre 3 e 50 caracteres.
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label col-form-label-sm">E-mail*</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control form-control-sm"  name="email" id="email" placeholder="Digite seu email" required value="<?php echo $email ?>">
                                <div class="valid-feedback">
                                    Tudo certo!
                                </div>
                                <div class="invalid-feedback">
                                    Verifique o preenchimento do campo e-mail.
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="senha" class="col-sm-2 col-form-label col-form-label-sm">Senha*</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input type="password" class="form-control form-control-sm" name="senha" id="senha" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!-*,@<>;:?=_,+])(?!.*(.)\1{1}).{8,}" placeholder="Digite sua Senha" required value="<?php echo $senha ?>">                                              
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
                            <label for="confirmar_senha" class="col-sm-2 col-form-label col-form-label-sm">Confirmação de Senha*</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input type="password" class="form-control form-control-sm" name="confirmar_senha" id="confirmar_senha" placeholder="Confirme sua Senha" required value="<?php echo $confirmar_senha ?>">
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
                                <p class="aviso">* Campos Obrigatórios.</p>
                                <a href="index.php">Voltar</a></p>
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
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <noscript>Atualize seu navegador</noscript>
    </body>
</html>