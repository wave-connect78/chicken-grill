<?php
    require_once 'init.php';
    $title = 'Chicken grill';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo RACINE_SITE ?>inc/css/style.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <title><?php echo $title; ?></title>
</head>
<body>
    <header>
        <div class="top-navi">
            <div class="top-navi-content">
                <div class="contact">
                    <p><i class="fas fa-envelope"></i> Email : <a href="mailto:test@mail.com"> test@mail.com</a></p>
                    <p><i class="fas fa-phone-alt"></i> Téléphone : <span> 012 56 89 87 45</span></p>
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
            <div class="navi-bloc">
                <div class="logo"><a href="<?php echo RACINE_SITE; ?>"><img src="../photos/logo.png" alt="chicken grill"></a></div>
                <div class="navi-content">
                        <nav>
                            <a href="#">Nos produits</a>
                            <a href="#">Devenir franchisé</a>
                            <a href="#">Notre catalogue</a>
                            <a href="#">Contact</a>
                        </nav>
                </div>
            </div>
           <div class="search"></div>
        </div>
    </header>
    <main>
    </main>
    <footer>
        <div class="footer-top">
            <div class="follow-us">
                <h4>Suivez nous</h4>
                <div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum voluptas, tenetur eum omnis voluptatem enim!</p>
                    <div class="social-media">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-pinterest"></i></a>
                        <a href="#"><i class="fas fa-rss"></i></a>
                    </div>
                </div>
            </div>
            <div class="service">
                <h4>Mes services</h4>
                <div>
                    <p class="print">Imprimer la page</p>
                    <p><a href="#">Connexion/Inscription</a></p>
                </div>
            </div>
            <div class="contact-us">
                <h4>Nous contacter</h4>
                <div>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi, vero! Magnam!</p>
                    <p class="adress"><i class="fas fa-map-marker-alt"></i>Adresse : <span>25 rue test </span></p>
                    <p class="tel"><i class="fas fa-phone-alt"></i>Téléphone : <span>012 52 45 65 89</span></p>
                    <p class="email"><i class="fas fa-envelope"></i>E-mail : <a href="mailto:test@mail.com">test@mail.com</a></p>
                </div>
            </div>
        </div>
        <hr>
        <div class="footer-bottom">
            <div class="copyright">
                <p>&copy;Copyright <?php echo date('Y'); ?></p>
            </div>
            <div class="payment">
                <img src="../photos/paypal.png" alt="paypal">
                <img src="../photos/visa.png" alt="visa card">
                <img src="../photos/maestro.png" alt="maestro card">
            </div>
        </div>
    </footer>
    <script src="<?php echo RACINE_SITE ?>inc/js/main.js"></script>
</body>
</html>