<?php

session_start();
date_default_timezone_set('America/Sao_Paulo');

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$filename = "5ddd2e45147066c4399b5fcd4cb63e68.json";
$data = file_exists($filename) ? json_decode(file_get_contents($filename), true) : [];

$username = $_SESSION["username"];

if (!isset($data["expirationDate"])) {
    // die("Acesso não disponível para o usuário $username.");
}

$expirationDateStr = $data["expirationDate"];
$expirationDate = strtotime($expirationDateStr);

if ($expirationDate === false) {
    // die("Erro na conversão da data de expiração.");
}

if ($expirationDate < time()) {
    $expira = date("Y-m-d H:i:s", $expirationDate);
    // die("Acesso expirado em $expira, contate o @PladixOficial para renovar seu acesso.");
}

$lastLogin = isset($data["lastLogin"]) ? $data["lastLogin"] : "Nunca realizado";

?>
