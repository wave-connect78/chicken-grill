<?php
    require_once 'init.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="google-signin-client_id" content="407013073336-8mh7bsb5jjfr7vm5oet31j5j71opj6vf.apps.googleusercontent.com">
    <meta name="google-signin-scope" content="profile email">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo RACINE_SITE ?>inc/css/style.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v11.0&appId=2027066680767202&autoLogAppEvents=1" nonce="nae1fbIF"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://js.stripe.com/v3/"></script>
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
                <div class="logo"><a href="<?php echo RACINE_SITE; ?>"><img src="<?php echo RACINE_SITE ?>assets/logo.png" alt="chicken grill"></a></div>
                <div class="navi-content">
                    <nav>
                        <a href="<?php 
                            if (isset($_SESSION['actuelPage'])) {
                                echo RACINE_SITE.$_SESSION['actuelPage']['nom_resto'];
                            }else{
                                echo RACINE_SITE;
                            }
                        ?>">Nos produits</a>
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
                        <a href="<?php echo RACINE_SITE ?>qui-sommes-nous">Qui sommes-nous</a>
                        <a href="#">Contact</a>
                    </nav>
                </div>
                <div class="search">
                    <?php 
                        if (isRestoAsnieresOn() || isRestoArgenteuilOn() || isRestoBezonsOn() || isRestoSaintDenisOn() || isRestoEpinaySeineOn()) {
                            ?>
                            <a href="<?php echo RACINE_SITE ?>admin"><i class="fas fa-cogs"></i></a>
                            <?php
                        }
                    ?>
                    <div class="search-bloc">
                        <i class="fas fa-search"></i>
                        <div class="search-content">
                            <input type="search" class="form-control" id="search" name="search" placeholder="Rechercher des produits">
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
                        <a href="<?php echo RACINE_SITE ?>cart"><i class="fas fa-shopping-basket"></i></a>
                    </div>
                    <a href="<?php echo RACINE_SITE ?>auth"><i class="far fa-user"></i></a>
                </div>
            </div>
        </div>
    </header>
    <main>
