<?php
session_start();
error_reporting(0);
ignore_user_abort();

date_default_timezone_set('America/Sao_Paulo');

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $filename = "5ddd2e45147066c4399b5fcd4cb63e68.json";

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $recaptchaSecretKey = "6LfjytknAAAAAJgOmRx0aYYk34A6wW3bcCBtgL7G";
    $recaptchaResponse = $_POST["g-recaptcha-response"];
    $recaptchaUrl = "https://www.google.com/recaptcha/api/siteverify";
    $recaptchaData = array(
        "secret" => $recaptchaSecretKey,
        "response" => $recaptchaResponse
    );
    $recaptchaOptions = array(
        "http" => array(
            "header" => "Content-type: application/x-www-form-urlencoded\r\n",
            "method" => "POST",
            "content" => http_build_query($recaptchaData)
        )
    );
    $recaptchaContext = stream_context_create($recaptchaOptions);
    $recaptchaResult = file_get_contents($recaptchaUrl, false, $recaptchaContext);
    $recaptchaResult = json_decode($recaptchaResult);

    if (!$recaptchaResult->success) {
        $errors[] = "reCaptcha está inválido!";
    }

    if (empty($username) || empty($password)) {
        $errors[] = "Usuário e senha devem ser preenchidos.";
    }

    $data = file_exists($filename) ? json_decode(file_get_contents($filename), true) : [];

    foreach ($data as $user) {
        if ($user["username"] === $username) {
            $errors[] = "Usuário já existe. Escolha outro nome de usuário.";
            break;
        }
        
        if ($user["ip"] === $_SERVER["REMOTE_ADDR"]) {
            $errors[] = "Este dispositivo já foi usado, tente com um diferente.";
            break;
        }
    }

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

date_default_timezone_set('America/Sao_Paulo');
        $ip = $_SERVER["REMOTE_ADDR"];
        $creationDate = date("Y-m-d H:i:s");
        $expirationDate = date("Y-m-d H:i:s", strtotime("+1 day", strtotime($creationDate)));

        $newUser = [
            "username" => $username,
            "password" => $hashedPassword,
            "ip" => $ip,
            "creationDate" => $creationDate,
            "expirationDate" => $expirationDate,
            "lastLogin" => "",
            "status" => "Active"
        ];

        $data[] = $newUser;

        file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));

        header("Location: login?accessKey=dedf0fcff631caf4b5d5164191020f6e14e5e69c");
        exit();
    }
}
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
                        <?php
                        foreach ($errors as $error) {
                            echo "<div class='alert alert-danger text-center' role='alert'>$error</div>";
                        }
                        ?>
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
        });
    </script>
</body>
</html>