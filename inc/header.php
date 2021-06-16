<?php
    require_once 'init.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo RACINE_SITE ?>inc/css/style.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <title><?php echo $title; ?></title>
</head>
<body>
    <header>
        <div class="top-navi">
            <div class="top-navi-content">
                <div class="contact">
                    <p><i class="fas fa-envelope"></i> Email : <a href="mailto:test@mail.com"> test@mail.com</a></p>
                    <p><i class="fas fa-phone-alt"></i> Téléphone : <span>01 71 67 75 41</span></p>
                </div>
                <div class="social-media">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-pinterest"></i></a>
                    <a href="#"><i class="fas fa-rss"></i></a>
                </div>
            </div>
        </div>
        <div class="navi">
            <div class="menu-burger">
                <span class="menu">MENU</span>
                <div class="burger-icon">
                    <div class="burger"></div>
                    <div class="burger"></div>
                    <div class="burger"></div>
                </div>
            </div>
            <div class="navi-bloc">
                <div class="logo"><a href="<?php echo RACINE_SITE; ?>"><img src="../photos/logo.png" alt="chicken grill"></a></div>
                <div class="navi-content">
                    <nav>
                        <a href="#">Nos produits</a>
                        <a href="#">Devenir franchisé</a>
                        <!--<a href="#">Notre catalogue 
                            <i class="fas fa-sort-down"></i>
                            <div class="categorie">
                                <a href="#">Rôtisserie</a>
                                <a href="#">Accompagnement</a>
                                <a href="#">Burger</a>
                                <a href="#">Desserts</a>
                            </div>
                        </a>-->
                        <a href="#">Qui sommes-nous</a>
                        <a href="#">Contact</a>
                    </nav>
                </div>
                <div class="search">
                    <div class="search-bloc">
                        <i class="fas fa-search"></i>
                        <div class="search-content">
                            <input type="search" class="form-control" id="search" name="search" placeholder="Rechercher des produits">
                        </div>
                    </div>
                    <i class="fas fa-shopping-basket"></i>
                    <a href="<?php RACINE_SITE ?>../auth"><i class="far fa-user"></i></a>
                </div>
            </div>
        </div>
    </header>
    <main>
