<?php
    require_once 'boot.php';
    unset($_SESSION['translado_token']);
    unset($_SESSION['client_data']);
    header('Location: index.php');
