<?php
    require_once '../../inc/init.php';
    $title = 'Confirmation de la commande';
    $email = 'chickengrillsaintdenis@gmail.com';
    $tel = '07 65 45 88 89';
    require_once '../../inc/header.php';


?>
<div class="confirmation">
    <?php 
        if (isset($_SESSION['confirmation'])) {

            ?>
            <div class="confirmation-content">
                <?php 
                    if ($_SESSION['confirmation']['reference_id'] == 'payment') {
                        ?>
                         <h2 class="mb-4">Confirmation de votre paiement et de votre commande</h2>
                        <?php
                    } else {
                        ?>
                         <h2  class="mb-4">Confirmation de votre commande</h2>
                        <?php
                    }
                    
                ?>
               
                <p>Ceux si est la preuve de votre commande</p>
                <h4  class="mb-4">Information relative à la commande</h4>
                <?php 
                    if ($_SESSION['confirmation']['reference_id'] == 'payment') {
                        ?>
                        <p>Le paiement c'est fait en ligne</p>
                        <?php
                    } else {
                        ?>
                        <p>Le paiement : <?php echo $_SESSION['confirmation']['reference_id'] ?></p>
                        <?php
                    }
                    
                ?>
                <p>La commande est receptionnée au nom de : <?php echo $_SESSION['user']['nom'] ?></p>
                <p>Votre code commande : <?php echo $_SESSION['confirmation']['commande_code'] ?></p>
                <p>L'identifiant de commande a présenter pour receptionner votre commande : <?php echo $_SESSION['confirmation']['reference_commande'] ?></p>
                <?php 
                    if ($_SESSION['confirmation']['reference_id'] == 'payment') {
                        ?>
                        <p style="color: rgb(14, 107, 49);">Le montant reçu est de : <?php echo $_SESSION['confirmation']['prix'] ?> €</p>
                        <?php
                    } else {
                        ?>
                        <p>Le montant à payer est de : <?php echo $_SESSION['confirmation']['prix'] ?> €</p>
                        <?php
                    }
                    
                ?>
                <p>Reception de la commande au restaurant chicken grill de : <?php echo $_SESSION['actuelPage']['adresse'] ?></p>
                <p>Vous pouvez faire une capture d'ecran dans le cas ou vous avez des difficultés à retenir</p>
                <?php 
                    if ($_SESSION['confirmation']['reference_id'] != 'payment') {
                        ?>
                        <p>N'oublier pas de valider le paiement au guichet</p>
                        <?php
                    } 
                    
                ?>
                <p>A bientôt !</p>
            </div>
            <?php
        }else {
            header('location:'.RACINE_SITE.$_SESSION['actuelPage']);
        }
    ?>
    
</div>
<?php
    require_once '../../inc/footer.php';