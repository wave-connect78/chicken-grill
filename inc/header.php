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
    <link rel="stylesheet" href="<?php echo RACINE_SITE ?>css/style.css">
    <title><?php echo $title; ?></title>
</head>
<body>
    <header>
        <div class="top-navi">
            <div class="contact"></div>
            <div class="social-media"></div>
        </div>
        <div class="navi">
           <div class="logo"></div>
           <div class="navi-content">
                <nav>
                    <a href="#">Nos produits</a>
                    <a href="#">Devenir franchisé</a>
                    <a href="#">A propos de nous</a>
                    <a href="#">Contact</a>
                </nav>
           </div>
           <div class="search"></div>
        </div>
    </header>
    <main>
    </main>
    <footer>
    <div class="footer-top">
    
    </div>
        <div class="follow-us">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum voluptas, tenetur eum omnis voluptatem enim!</p>
        </div>
        <div class="service">
            <p class="print">Imprimer la page</p>
            <p><a href="#">Connexion/Inscription</a></p>
        </div>
        <div class="contact-us">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi, vero! Magnam!</p>
            <p class="adress">Adresse : <span>test</span></p>
            <p class="tel">Téléphone : <span></span></p>
            <p class="email">E-mail : <a href="mailto:test@mail.com">test@mail.com</a></p>
        </div>
    </footer>
    <script src="<?php echo RACINE_SITE ?>js/main.js"></script>
</body>
</html>