<?php
    require_once 'boot.php';

    $translado = new \Expando\TransladoPackage\Translado();
    $translado->setToken($_SESSION['translado_token'] ?? null);
    $translado->setUrl($_SESSION['client_data']['translado_url']);
    if ($translado->isTokenExpired()) {
        $translado->refreshToken($_SESSION['client_data']['client_id'], $_SESSION['client_data']['client_secret']);
        if ($translado->isLogged()) {
            $_SESSION['translado_token'] = $translado->getToken();
        }
    }

    if (!$translado->isLogged()) {
        die('Translator is not logged');
    }

    try {
        $response = $translado->listConnections();

        echo 'Connections count: ' . count($response->getConnections()) . '<br />';
        echo 'Status: ' . $response->getStatus() . '<br />';
        echo '-----------------------------<br />';

        echo '<ul>';
        foreach ($response->getConnections() as $connection) {
            echo '<li><strong>Connection ID:</strong> ' . $connection->getConnectionId() . ', <strong>Title:</strong> ' . $connection->getTitle() . ', <strong>Icu:</strong> ' . $connection->getIcu() . ', <strong>Type:</strong> ' . ($connection->getType() ?: '--') . '</li>';
        }
        echo '</ul>';
    }
    catch (\Expando\TransladoPackage\Exceptions\TransladoException $e) {
        die($e->getMessage());
    }
