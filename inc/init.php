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
    define('STRIPE_EPINAYSEINE_PUBLIC_KEY','pk_test_51JA9QxGuICezOfcTEBWS6nDD5t89vPM2hmNY5hU8sPmPYDVLyW9yo1hRHwTlzdVlNJssFhOLABCtzwo4pTQkcb6p00yCrLDl83');
    define('STRIPE_EPINAYSEINE_API_KEY','sk_test_51JA9QxGuICezOfcTHShzC9pDoxOtoveHwOzlS6tkugQbTaJtQ7FkOTX44dbZfM6wsplIx4fx2RHKPO8Zf9piK4cz00bQisXMkX');
    define('STRIPE_ARGENTEUIL_PUBLIC_KEY','pk_test_51JA9P7LRaPgbMcHQrY1knKEFZtm9y4RK7EYStsTGOgCpd5Li7QdjdGuM4IAHd0cojd8WS8LBFcZ8svuww9BGJJ7500LOUsE8qx');
    define('STRIPE_ARGENTEUIL_API_KEY','sk_test_51JA9P7LRaPgbMcHQxWYewo9pq1wSylp9yrClW5OSZFypag8vNAB6Hg77OHRD3ZHdJEzMC9hHBDC1aZBsoZMyY8n500sgx9yiBo');
    define('STRIPE_ASNIERES_PUBLIC_KEY','pk_test_51JA9JADvCVXadVFUAQJYoxzzyI0sVCpv5BSkll3uZW5frTTIuBNkCa302x9mtSJpo9FtkJaxUFhadlt6MvfMkpu200QpMleQG2');
    define('STRIPE_ASNIERES_API_KEY','sk_test_51JA9JADvCVXadVFUGYD95cG3zkQ4GtnNhgDGqmUfQglEbhdmnduFwa3gza822lWTjBbgpU45GP1d3S6EoW19cD1g00PgQp5Lea');
    define('STRIPE_BEZONS_PUBLIC_KEY','pk_test_51JA9L9GoKyXKcyU8X98D9vmeQdIx4JaFkwplZ7JO7cmznwho6CzSzG4hacaHw7q4YqHp6qMBocbzQU8rLxp8YtYi00at6PlTGP');
    define('STRIPE_BEZONS_API_KEY','sk_test_51JA9L9GoKyXKcyU85X9VEKzkPp66W0r3xPqRfoJAmH2QsZmXq00m45SZSqqgZizK2GGrFtSwISianfuBAuZf1bdv00MoO7NxqH');
    define('STRIPE_SAINTDENIS_PUBLIC_KEY','pk_test_51JA9NRIh23dcKTD04eHuYqlwfGV1FinOHEZElFo0y7YiCMDULpGMpfbwnzI0XOB2taCoeSuZc6eYlucBOYbXhaVR00eahfCFOe');
    define('STRIPE_SAINTDENIS_API_KEY','sk_test_51JA9NRIh23dcKTD0bNwztwHH64vIODzUAYuNHlx2RKe9zKBb39QmyKjm5KIwvkQqyJZpO12ZZmrRqdcrGJLFSYrf006TFLgwpu');
    $title = '';

    require_once 'functions.php';
    