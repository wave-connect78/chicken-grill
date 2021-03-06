<?php
    require_once 'init.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="google-signin-client_id" content="366921049100-m2mu5boo6movj36oddda02g00m8glb5h.apps.googleusercontent.com">
    <meta name="google-signin-scope" content="profile email">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="text/html; charset=UTF-8; X-Content-Type-Options=nosniff" http-equiv="Content-Type" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo RACINE_SITE ?>/inc/css/style.css">
    <link rel="stylesheet" href="<?php echo RACINE_SITE ?>/inc/css/loading.css">
    <link rel="stylesheet" href="<?php echo RACINE_SITE ?>/inc/css/toggle.css">
    <link rel="stylesheet" href="<?php echo RACINE_SITE ?>/inc/css/animation.css">
    <link rel="stylesheet" href="<?php echo RACINE_SITE ?>/inc/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo RACINE_SITE ?>/inc/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Calligraffitti&display=swap" rel="stylesheet">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v11.0&appId=2027066680767202&autoLogAppEvents=1" nonce="nae1fbIF"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <title><?php echo $title; ?></title>
</head>
<body>
    <header>
        <div class="top-navi">
            <div class="top-navi-content">
                <div class="contact">
                    <p><i class="fas fa-envelope"></i> Email : <a href="mailto:<?php echo $email ?>"> Chicken grill <?php echo $_SESSION['actuelPage']['nom_resto']; ?></a></p>
                    <p><i class="fas fa-phone-alt"></i> T??l??phone : <span> <?php echo $tel; ?></span></p>
                </div>
                <div class="social-media">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.instagram.com/chickengrill95/"><i class="fab fa-instagram"></i></a>
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
                <div class="logo"><a href="https://chicken-grill.fr/"><img src="<?php echo RACINE_SITE ?>/assets/logo.png" alt="chicken grill"></a></div>
                <div class="navi-content">
                    <nav>
                        <a href="<?php 
                            if (isset($_SESSION['actuelPage'])) {
                                echo RACINE_SITE.'/'.$_SESSION['actuelPage']['nom_resto'];
                            }else{
                                echo RACINE_SITE;
                            }
                        ?>/home">Accueil</a>
                        <a href="<?php 
                            if (isset($_SESSION['actuelPage'])) {
                                echo RACINE_SITE.'/'.$_SESSION['actuelPage']['nom_resto'];
                            }else{
                                echo RACINE_SITE;
                            }
                        ?>/product">Nos produits</a>
                        <!--<a href="#">Devenir franchis??</a>-->
                        <!--<a href="#">Notre catalogue 
                            <i class="fas fa-sort-down"></i>
                            <div class="categorie">
                                <a href="#">R??tisserie</a>
                                <a href="#">Accompagnement</a>
                                <a href="#">Burger</a>
                                <a href="#">Desserts</a>
                            </div>
                        </a>-->
                        <a href="<?php 
                            if (isset($_SESSION['actuelPage'])) {
                                echo RACINE_SITE.'/'.$_SESSION['actuelPage']['nom_resto'].'/qui-sommes-nous';
                            } else {
                                echo RACINE_SITE;
                            }
                        ?>">Qui sommes-nous</a>
                        <a href="<?php 
                            if (isset($_SESSION['actuelPage'])) {
                                echo RACINE_SITE.'/'.$_SESSION['actuelPage']['nom_resto'].'/franchise';
                            } else {
                                echo RACINE_SITE;
                            }
                        ?>">Devenir franchis??</a>
                        <a href="<?php 
                            if (isset($_SESSION['actuelPage'])) {
                                echo RACINE_SITE.'/'.$_SESSION['actuelPage']['nom_resto'].'/contact';
                            } else {
                                echo RACINE_SITE;
                            }
                        ?>">Contact</a>
                    </nav>
                </div>
                <div class="search">
                    <div class="search-bloc">
                        <i class="fas fa-search"></i>
                        <div class="search-content">
                            <input type="search" class="form-control" id="search" name="search" placeholder="Rechercher des produits">
                            <input type="submit" class="startsearch btn btn-primary" value="Rechercher">
                        </div>
                        <div class="filter">
                            <ul></ul>
                        </div>
                    </div>
                    <div class="cart">
                        <div><?php 
                            if (isset($_SESSION['cart'])) {
                                echo count($_SESSION['cart']);
                            }else {
                                echo '0';
                            }
                        ?></div>
                        <a href="<?php
                            if (isset($_SESSION['actuelPage'])) {
                                echo RACINE_SITE.'/'.$_SESSION['actuelPage']['nom_resto'].'/cart';
                            } else {
                                echo RACINE_SITE;
                            }
                        ?>"><i class="fas fa-shopping-basket"></i></a>
                    </div>
                    <a href="<?php
                        if (isset($_SESSION['actuelPage'])) {
                            echo RACINE_SITE.'/'.$_SESSION['actuelPage']['nom_resto'].'/auth';
                        } else {
                            echo RACINE_SITE;
                        }
                    ?>" class="<?php 
                        if(isOn()){ echo userOn;}
                    ?>"><i class="far fa-user"></i></a>
                </div>
            </div>
        </div>
    </header>
    <main>
