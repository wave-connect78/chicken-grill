<?php
    require_once '../../inc/init.php';



    $title = 'Accueil epinay-seine';
    $email = 'chickengrill.93800@gmail.com';
    $tel = '09 53 36 02 12';
    $_SESSION['actuelPage']['nom_resto'] = 'epinay-seine';
    $_SESSION['actuelPage']['adresse'] = '27 impasse du noyer bossu 93800 Epinay sur seine';
    require_once '../../inc/header.php';

?>

<div class="home">
    <div class="carousel">
        <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active" data-interval="10000">
                    <img src="../../assets/acceuil-slide1.jpeg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block other">
                        <h3>COMMANDEZ VOTRE</h3>
                        <h4>MENU</h4>
                        <a href="/<?php echo $_SESSION['actuelPage']['nom_resto']; ?>/product" class="btn btn-primary">Commandez</a>
                    </div>
                </div>
                <div class="carousel-item" data-interval="10000">
                    <img src="../../assets/riz_thai_poulet.png" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block restoname">
                        <div>CHICKEN GRILL</div>
                        <div><h3>EPINAY-SEINE</h3></div>
                        <p>le vrai goût épicé</p>
                        <a href="/<?php echo $_SESSION['actuelPage']['nom_resto']; ?>/product" class="btn btn-primary">Découvrir</a>
                    </div>
                </div>
                <div class="carousel-item" data-interval="10000">
                    <img src="../../assets/chicken-grill-home.png" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <div class="cryptage">
        <div class="ssl">
            <img src="../../assets/ssl.png"/>
            <h4>Paiement sécurisé</h4>
            <p>Cryptage SSL pour des<br>paiements sécurisés<br>Carte bancaire</p>
        </div>
        <div class="collect">
            <img src="../../assets/collect.png"/>
            <h4>Click & collect</h4>
            <p>Commandez en ligne et récupérez<br>votre repas dans votre point de vente</p>
        </div>
    </div>
    <div class="home-content">
        <div class="bloc-content1">
            <div class="left-bloc">
                <h3>Chicken</h3>
                <p>Notre incontournable poulet fondant et parfumé<br>au épices, sera ravir vos papilles</p>
                <a href="/<?php echo $_SESSION['actuelPage']['nom_resto']; ?>/product" class="btn btn-primary">Découvrir</a>
            </div>
            <div class="right-bloc">
                <img src ="../../assets/poulet_entier.JPG" class="home-img1" />
            </div>
        </div>
        <div class="bloc-content2">
            <div class="left-bloc">
                <img src ="../../assets/riz_thai_poulet.png" class="home-img2"/>
            </div>
            <div class="right-bloc">
                <h3>Notre coup de coeur</h3>
                <p>Venez dégustez une délicieuse cuisse de poulet grillé<br>accompagné de son riz thaï au goût sucré</p>
                <a href="/<?php echo $_SESSION['actuelPage']['nom_resto']; ?>/product" class="btn btn-primary">Découvrir</a>
            </div>
        </div>
        <div class="bloc-content1">
            <div class="left-bloc">
                <h3>Notre touche sucrée</h3>
                <p>ne restez pas sur votre faim, cédez pour<br>un tiramisu oréo</p>
                <a href="/<?php echo $_SESSION['actuelPage']['nom_resto']; ?>/product" class="btn btn-primary">Découvrir</a>
            </div>
            <div class="right-bloc">
                <img src ="../../assets/tiramisu.jpg" class="home-img3"/>
            </div>
        </div>
    </div>
    <div class="text">
        <p>D’inspiration brésilienne le poulet grillé à plat assure une cuisson lente homogène pour un fondant mémorable, une coloration et un crousty parfait.<br>Grand amateur de poulet grillé, nous souhaitions apporter plus de goût à un poulet fondant et parfumé aux épices des 4 coins du monde.</p>
        <p>Chicken Grill s’est fondé en 2015 avec comme leitmotiv plaisir, saveurs uniques, produit frais et tradition.</p>
        <p>Pour cela, nous nous sommes entourés de professionnels engagés et rigoureux tant dans la qualité des produits, un approvisionnement régulier afin d’assurer la fraîcheur des denrées alimentaires et respectueuses de l’environnement.</p>
        <p>Chicken Grill c’est aussi un spectacle à chaque instant que nous mettons en scène en toute transparence.<br>La cuisson et la sortie de four au vu de tous réjouissant les petits et les grands.</p>
    </div>
</div>

<?php
    require_once '../../inc/footer.php';