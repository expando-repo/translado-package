<?php

    use Expando\TransladoPackage\Request\ProductRequest;
    use Expando\TransladoPackage\Request\VariantRequest;

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

    if ($_POST['send'] ?? null) {
        try {
            $response = $translado->commitProductRequest($_POST['change_id']);
        }
        catch (\Expando\TransladoPackage\Exceptions\TransladoException $e) {
            die($e->getMessage());
        }

        echo 'Response: ' . ($response ? 'true' : 'false');

    }
?>

<form method="post">
    <div>
        <label>
            Change ID<br />
            <input type="text" name="change_id" value="<?php echo $_POST['change_id'] ?? null ?>"  />
        </label>
    </div>
    <div>
        <input type="submit" name="send" value="send" />
    </div>
</form>
