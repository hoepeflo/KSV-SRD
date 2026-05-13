<?php
// Sichere Session-Cookie-Parameter setzen
$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
  || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => $secure,
    'httponly' => true,
    'samesite' => 'Lax'
]);
// Session starten, falls nicht bereits gestartet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


