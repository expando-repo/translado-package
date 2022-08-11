<?php
    require_once 'boot.php';

    if (empty($_SESSION['client_data'])) {
        header('Location: redirect.php');
        exit;
    }

    $translado = new \Expando\TransladoPackage\Translado();
    $translado->setToken($_SESSION['translado_token'] ?? null);
    $translado->setUrl($_SESSION['client_data']['translado_url']);
    if ($translado->isTokenExpired()) {
        $translado->refreshToken($_SESSION['client_data']['client_id'], $_SESSION['client_data']['client_secret']);
        if ($translado->isLogged()) {
            $_SESSION['translado_token'] = $translado->getToken();
        }
    }
?>

<?php if (!$translado->isLogged()) { ?>
    <a href="redirect.php">Login (get token)</a>
<?php } else { ?>
    <ul>
        <li><a href="addProduct.php">add/update product</a></li>
        <li><a href="listProducts.php">list products</a></li>
        <li><a href="changesProducts.php">changes products</a></li>
        <li><a href="getProduct.php">get product</a></li>
        <li><a href="commitProduct.php">commit product</a></li>
        <li><a href="deleteProduct.php">delete product</a></li>
        <li><a href="listConnection.php">list connections</a></li>
        <li></li>
        <li><a href="logout.php">logout (delete token)</a></li>
    </ul>
<?php } ?>
