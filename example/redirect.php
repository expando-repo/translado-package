<?php

use Expando\TransladoPackage\Exceptions\LoginException;

require_once 'boot.php';

if (($_POST['send'] ?? null) || ($_GET['code'] ?? null)) {

    if (($_POST['send'] ?? null)) {
        $_SESSION['client_data'] = $_POST;
    }

    try {
        $login = new \Expando\TransladoPackage\Login(
            $_SESSION['client_data']['client_id'],
            $_SESSION['client_data']['client_secret'],
            $_SESSION['client_data']['redirect_url'],
            $_SESSION['client_data']['translado_url']
        );
        $login->addScope('products');
        //$login->addScope('connections');
        $token = $login->getToken();
    } catch (LoginException $e) {
        die($e->getMessage());
    }

    if ($token !== null)
    {
        // save to session for example
        $_SESSION['translator_token'] = $token;
        header('Location: index.php');
    }
}

?>

<form method="post">
    <div>
        <label>
            Translado URL<br />
            <input type="text" name="translado_url" value="http://connector.local"  />
        </label>
    </div>
    <div>
        <label>
            Client ID<br />
            <input type="text" name="client_id" value=""  />
        </label>
    </div>
    <div>
        <label>
            Client secret<br />
            <input type="text" name="client_secret" value=""  />
        </label>
    </div>
    <div>
        <label>
            Redirect URL<br />
            <input type="text" name="redirect_url" value="http://translado-package.local/redirect.php"  />
        </label>
    </div>
    <div>
        <input type="submit" name="send" value="send" />
    </div>
</form>
