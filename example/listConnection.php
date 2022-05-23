<?php
    require_once 'boot.php';

    $translado = new \Expando\TransladoPackage\Translado();
    $translado->setToken($_SESSION['translator_token'] ?? null);
    $translado->setUrl($_SESSION['client_data']['translado_url']);
    if ($translado->isTokenExpired()) {
        $translado->refreshToken($_SESSION['client_data']['client_id'], $_SESSION['client_data']['client_secret']);
        if ($translado->isLogged()) {
            $_SESSION['translator_token'] = $translado->getToken();
        }
    }

    if (!$translado->isLogged()) {
        die('Translator is not logged');
    }

    try {
        $response = $translado->listConnections();
    }
    catch (\Expando\TransladoPackage\Exceptions\TransladoException $e) {
        die($e->getMessage());
    }

    echo 'Status: ' . $response->getStatus() . '<br />';
