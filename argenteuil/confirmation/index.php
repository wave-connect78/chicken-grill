<?php
    require_once '../../inc/init.php';
    $title = 'Confirmation de la commande';
    $email = 'chickengrill.argenteuil95@gmail.com';
    $tel = '06 21 52 65 93';
    if(!isset($_SESSION['actuelPage'])){
        header('location:https://chicken-grill.fr/');
        exit;
    }
    $nb = '';
    $msg = '';
    if (isset($_SESSION['confirmation'])) {
        $from = $email;
        $to = $_SESSION['user']['email'];
        if ($_SESSION['confirmation']['reference_id'] != 'payment') {
            $subject = 'Confirmation de votre commande';
            $prix = '<p style="color: rgb(252, 61, 3);">Le montant à payer est de : '.str_replace('.',',',$_SESSION['confirmation']['prix']).'€</p>';
            $nb = '<p style="color: rgb(252, 61, 3);">N\'oublier pas de valider le paiement au guichet</p>';
            $message = '<h3>Merci pour votre commande</h3><p>Cet email est la confirmation que nous avons reçu votre commande et que nous la préparons. 
            Nous vous conseillons de vous connectez à votre compte personnelle sur <a href="https://chicken-grill.fr">chicken-grill.fr</a> afin de vérifier le statut de votre commande.</p><h4>Informations importantes</h4>
            <p>Vous devez présenter ces informations à la caisse afin que votre commande soit identifiée.</p><p>La commande est receptionnée au nom de : '.$_SESSION['user']['nom'].'</p>
            <p>L\'identifiant de commande à présenter pour receptionner votre commande : '.$_SESSION['confirmation']['reference_commande'].'</p>'.$prix.'
            <p>Réception de la commande au restaurant chicken grill de : '.$_SESSION['actuelPage']['adresse'].'</p>'.$nb.'<p>À bîentôt</p> <p>Chicken grill Argenteuil</p><p>'.$tel.'</p>';
            if(sendMail($from,$to,$subject,$message,true,'','')){
                $msg = '<p class="info">Un e-mail de confirmation de commande vous a été envoyé à votre adresse email.</p>';
            }
        }else{
            $msg = '<p class="info">'.$_SESSION['confirmation']['email'].'</p>';
        }
        
    }
    
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
               
                <p>Ceux-ci est la preuve de votre commande</p>
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
                <p>L'identifiant de commande à présenter pour receptionner votre commande : <?php echo $_SESSION['confirmation']['reference_commande'] ?></p>
                <?php 
                    if ($_SESSION['confirmation']['reference_id'] == 'payment') {
                        ?>
                        <p style="color: rgb(14, 107, 49);">Le montant reçu est de : <?php echo str_replace('.',',',$_SESSION['confirmation']['prix']) ?> €</p>
                        <?php
                    } else {
                        ?>
                        <p style="color: rgb(252, 61, 3);">Le montant à payer est de : <?php echo str_replace('.',',',$_SESSION['confirmation']['prix']) ?> €</p>
                        <?php
                    }
                    
                ?>
                <p>Réception de la commande au restaurant chicken grill de : <?php echo $_SESSION['actuelPage']['adresse'] ?></p>
                <p>Vous pouvez faire une capture d'écran dans le cas où vous avez des difficultés à retenir</p>
                <?php 
                    if ($_SESSION['confirmation']['reference_id'] != 'payment') {
                        ?>
                        <p>N'oublier pas de valider le paiement au guichet</p>
                        <?php
                    } 
                    echo $msg;
                ?>
                <p>À bientôt !</p>
            </div>
            <?php
        }else {
            header('location:'.RACINE_SITE.'/'.$_SESSION['actuelPage']);
        }
    ?>
    
</div>
<?php
    require_once '../../inc/footer.php';