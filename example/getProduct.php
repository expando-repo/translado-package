<?php

    use Expando\TransladoPackage\Request\ProductRequest;
    use Expando\TransladoPackage\Request\VariantRequest;

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

    if ($_POST['send'] ?? null) {
        try {
            $response = $translado->getProduct($_POST['connection_id'], $_POST['product_id']);
        }
        catch (\Expando\TransladoPackage\Exceptions\TransladoException $e) {
            die($e->getMessage());
        }

        echo '<strong>Title:</strong> ' . $response->getTitle() . '<br />';
        echo '<strong>Description:</strong> ' . $response->getDescription() . '<br />';
        echo '<strong>Status:</strong> ' . $response->getStatus() . '<br />';
        echo '<strong>Message:</strong> ' . $response->getMessage() . '<br />';
        echo '<strong>Change ID:</strong> ' . $response->getChangeId() . '<br />';
        echo '-----------------------------<br />';
    }
?>

<form method="post">
    <div>
        <label>
            Connection ID<br />
            <input type="text" name="connection_id" value="<?php echo $_POST['connection_id'] ?? null ?>"  />
        </label>
    </div>
    <div>
        <label>
            Product ID<br />
            <input type="text" name="product_id" value="<?php echo $_POST['product_id'] ?? null ?>"  />
        </label>
    </div>
    <div>
        <input type="submit" name="send" value="send" />
    </div>
</form>
