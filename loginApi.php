<?php
session_start();
error_reporting(0);

date_default_timezone_set('America/Sao_Paulo');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $filename = "5ddd2e45147066c4399b5fcd4cb63e68.json";
    
    $username = $_POST["username"];
    $password = $_POST["password"];
    
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
        header("Location: login?errocaptcha=true");
        exit();
    }
    
    $data = file_exists($filename) ? json_decode(file_get_contents($filename), true) : [];
    $loginSuccess = false;

    foreach ($data as &$user) {
        if ($user["username"] === $username && password_verify($password, $user["password"])) {
            if ($user["status"] === "Active" && isset($user["expirationDate"]) && strtotime($user["expirationDate"]) >= time()) {
                $user["lastLogin"] = date("Y-m-d H:i:s");
                file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
                
                $_SESSION["expirationDate"] = $user["expirationDate"];
                
                if ($user["ip"] !== $_SERVER["REMOTE_ADDR"]) {
                    header("Location: login?blocked=true");
                    exit();
                }
                
                $_SESSION["username"] = $user["username"];
                $loginSuccess = true;
                break;
            } else if ($user["status"] !== "Active") {
                header("Location: login.php?banned_user=true");
                exit();
            } else {
                header("Location: login?expired=true");
                exit();
            }
        }
    }
    
    if ($loginSuccess) {
        $_SESSION["expirationDate"] = $user["expirationDate"];

        $_SESSION["lastLogin"] = $user["lastLogin"];

        header("Location: login?success=true");
    } else {
        header("Location: login?error=true");
    }
}
?>