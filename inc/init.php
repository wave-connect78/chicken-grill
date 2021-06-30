<?php
    $pdo = new PDO('mysql:host=localhost;dbname=chicken-grill',
    'root', 
    '', 
    array( 
        PDO::ATTR_ERRMODE => PDO:: ERRMODE_WARNING,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    ));
    
    session_start();

    define('RACINE_SITE','/chicken-grill/');
    define('STRIPE_PUBLIC_KEY','pk_test_51J7LvEGmpSPcezX39MNC50iR9dYSZVCMiXpiDHpchXWcc2PeCbhweI5TfwSIQjVk7j6N9SJExAUaAzeV3n2GBusw00i34jq0eK');
    define('STRIPE_API_KEY','sk_test_51J7LvEGmpSPcezX3GAXZZVQtRTnaIpqhTfLE5oalQb8INFqaxukl957KRCj19YFaT8iyaX4VmXTxHs7MPix87IqR00LryP9MgL');
    $title = '';

    require_once 'functions.php';
    