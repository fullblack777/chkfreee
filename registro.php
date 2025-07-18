
<?php

error_reporting(0);
ignore_user_abort();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastro</title>
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
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Cadastro</h2>
                    </div>
                    <div class="card-body">
                        <form action="registroApi.php" method="post">
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
                            <button type="submit" class="btn btn-primary btn-block">Cadastrar</button>
                        </form>
                        <p class="mt-3 text-center">Já tem cadastro? <a href="login?accessKey=dedf0fcff631caf4b5d5164191020f6e14e5e69c">Faça o seu login!</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            <?php
            if (isset($_GET['error'])) {
                $error = $_GET['error'];
                if ($error === 'empty') {
                    echo "toastr.error('Usuário e senha devem ser preenchidos.');";
                } elseif ($error === 'user_exists') {
                    echo "toastr.error('Usuário já existe. Escolha outro nome de usuário.');";
                }
            }
            ?>
        });
    </script>
</body>
</html>