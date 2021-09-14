<?php
    require_once '../../inc/init.php';

    $title = 'Qui sommes-nous';
    $email = 'chickengrill.argenteuil95@gmail.com';
    $tel = '06 21 52 65 93';
    if(!isset($_SESSION['actuelPage'])){
        header('location:https://chicken-grill.fr/');
        exit;
    }
    require_once '../../inc/header.php';

?>
<div class="about-us">
    <h1 class="mb-5 mt-5">À propos de chicken grill</h1>
    <div class="about-us-content">
        <div class="text-content">
            <h3 class="mb-5 mt-5">Qui sommes-nous</h3>
            <p>D’inspiration brésilienne le poulet grillé à plat assure une cuisson lente homogène pour un fondant mémorable, une coloration et un crousty parfait.<br>Grand amateur de poulet grillé, nous souhaitions apporter plus de goût à un poulet fondant et parfumé aux épices des 4 coins du monde.</p>
            <p>Chicken Grill s’est fondé en 2015 avec comme leitmotiv plaisir, saveurs uniques, produit frais et tradition.</p> 
            <p>Pour cela, nous nous sommes entourés de professionnels engagés et rigoureux tant dans la qualité des produits, un approvisionnement régulier afin d’assurer la fraîcheur des denrées alimentaires et respectueuses de l’environnement.</p>
            <p>Chicken Grill c’est aussi un spectacle à chaque instant que nous mettons en scène en toute transparence.<br>La cuisson et la sortie de four au vu de tous réjouissant les petits et les grands.</p>
            <p>Chicken Grill le vrai goût épicé.<br>Tester, c’est l’adopter.</p>
        </div>
        <div class="img">
            <video width="100%" controls autoplay muted>
              <source src="../../audio/video-chicken-grill.mov" type="video/mp4">
              Your browser does not support the video tag.
            </video>
        </div>
    </div>
</div>
<?php
    require_once '../../inc/footer.php';