<?php
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: #343a40;
            color: white;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            background-color: #222;
            border: none;
            border-radius: 10px;
        }
        .card-header {
            background-color: #343a40;
            border-bottom: none;
            color: white;
        }
        .form-control {
            background-color: #343a40;
            color: white;
            border: 1px solid #555;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Login</h2>
                    </div>
                    <div class="card-body">
<?php
if (isset($_GET["error"])) {
    echo '<div class="alert alert-danger text-center" role="alert">Usuário ou senha incorretos.</div>';
} elseif (isset($_GET["success"]) && $_GET["success"] == "true") {
    echo '<div class="alert alert-success text-center" role="alert">Login realizado com sucesso!</div>';
    echo '<script>
        setTimeout(function() {
            window.location.href = "checker?accessKey=dedf0fcff631caf4b5d5164191020f6e14e5e69c";
        }, 5000);
    </script>';
} elseif (isset($_GET["expired"]) && $_GET["expired"] == "true") {
    echo '<div class="alert alert-warning text-center" role="alert">Acesso expirado - Contate o @PladixOficial para renovar!</div>';
} elseif (isset($_GET["blocked"]) && $_GET["blocked"] == "true") {
    echo '<div class="alert alert-danger text-center" role="alert">O acesso só pode ser usado pelo IP registrante.</div>';
} elseif (isset($_GET["errocaptcha"]) && $_GET["errocaptcha"] == "true") {
    echo '<div class="alert alert-danger text-center" role="alert">reCaptcha está inválido!</div>';
} elseif (isset($_GET["banned_user"]) && $_GET["banned_user"] == "true") {
    echo '<div class="alert alert-danger text-center" role="alert">Usuário banido, contate o suporte!</div>';
}
?>

                        <form action="loginApi.php" method="post">
                            <div class="form-group">
                                <label for="username">Usuário:</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Senha:</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <p class="text-center">
                                <div class="g-recaptcha" data-sitekey="6LfjytknAAAAAPrC6WnaQnUSlv95vkqb73G4m6Vo"></div>
                            </p>
                            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                        </form>
                        <p class="text-center mt-3">Ainda não tem cadastro? <a href="registro?accessKey=dedf0fcff631caf4b5d5164191020f6e14e5e69c">Faça o seu cadastro!</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>