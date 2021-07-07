<?php
    require_once '../../inc/init.php';

    $title = 'Panier de commande';
    $contenu = '';
    $somme = 0.00;
    $commande_detail = '';
    $commande_code = 0;
    $email = 'chickengrill.argenteuil95@gmail.com';
    $tel = '07 65 45 88 89';
    if (!isset($_SESSION['actuelPage'])) {
       header('location:'.RACINE_SITE);
       exit;
    }
    if (isset($_GET) && !empty($_GET)) {
        unset($_SESSION['cart'][$_GET['session_id']]);
    }

    if (isset($_POST) && !empty($_POST)) {
        print_r($_POST);
        if (!isOn()) {
            header('location:'.RACINE_SITE.$_SESSION['actuelPage']['nom_resto'].'/auth');
            exit;
        }else {
            if (!isset($_SESSION['cart'])) {
                $contenu = '<p>Vous n\'avez pour l\'instant choisi aucun produit. <a href="'.RACINE_SITE.$_SESSION['actuelPage']['nom_resto'].'">Choisir un produit</a></p>';
            } else {
                foreach ($_SESSION['cart'] as $key => $value) {
                    if ($key == count($_SESSION['cart'])-1) {
                        $commande_detail .= $_SESSION['cart'][$key]['product_id'].'::'.$_SESSION['cart'][$key]['product_name'].'::'.$_SESSION['cart'][$key]['quantite'].'::'.$_SESSION['cart'][$key]['product_type'].'::'.$_SESSION['cart'][$key]['commande_mode'].'::'.$_SESSION['cart'][$key]['boisson'].'::'.$_SESSION['cart'][$key]['precision'].'::'.$_SESSION['cart'][$key]['message'];
                    } else {
                        $commande_detail .= $_SESSION['cart'][$key]['product_id'].'::'.$_SESSION['cart'][$key]['product_name'].'::'.$_SESSION['cart'][$key]['quantite'].'::'.$_SESSION['cart'][$key]['product_type'].'::'.$_SESSION['cart'][$key]['commande_mode'].'::'.$_SESSION['cart'][$key]['boisson'].'::'.$_SESSION['cart'][$key]['precision'].'::'.$_SESSION['cart'][$key]['message'].'|';
                    }
                    $somme = intval($_SESSION['cart'][$key]['quantite']) * floatval($_SESSION['cart'][$key]['prix']) + $somme;
                }
                while (1) {
                    $randomNumber = rand(1000, 10000);
                    $resultat = executeQuery("SELECT * FROM commande WHERE commande_code =:commande_code",array(
                        ':commande_code' => $randomNumber
                    ));
        
                    if ($resultat->rowCount() < 1) {
                        $commande_code = $randomNumber;
                        break;
                    } 
                    
                }
                executeQuery("INSERT INTO commande(reference_id,user_id,commande_code,commande_detail,reference_commande,commande_statut,prix,resto,commande_date) VALUES(:reference_id,:user_id,:commande_code,:commande_detail,:reference_commande,:commande_statut,:prix,:resto,NOW())",array(
                    ':reference_id' => 'PAIEMENT EN CAISSE',
                    ':user_id' => $_SESSION['user']['user_id'],
                    ':commande_code' => $commande_code,
                    ':commande_detail' => $commande_detail,
                    ':reference_commande' => $commande_code.'-'.strtolower(str_replace(" ","_",$_SESSION['user']['nom'])),
                    ':commande_statut' => 'reçu',
                    ':prix' => $somme,
                    ':resto' => $_SESSION['actuelPage']['nom_resto']
                ));
                $_SESSION['confirmation']['reference_id'] = 'PAIEMENT EN CAISSE';
                $_SESSION['confirmation']['commande_code'] = $commande_code;
                $_SESSION['confirmation']['prix'] = $somme;
                $_SESSION['confirmation']['reference_commande'] = $commande_code.'-'.strtolower(str_replace(" ","_",$_SESSION['user']['nom']));
                $_SESSION['confirmation']['resto'] = $_SESSION['actuelPage']['adresse'];
                unset($_SESSION['cart']);
                header('location:../confirmation');
                exit;
            }
        }
    }
    require_once '../../inc/header.php';
    //print_r($_SESSION['cart']);
    
    if (!isset($_SESSION['cart'])) {
        $contenu = '<p>Vous n\'avez pour l\'instant choisi aucun produit. <a href="'.RACINE_SITE.$_SESSION['actuelPage']['nom_resto'].'">Choisir un produit</a></p>';
    }else {
        $contenu .= '<table class="table table-striped">';
        $contenu .= '<tr>
                <th>Nr.</th>
                <th>Nom du produit</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Mode de commande</th>
                <th>Type de produit</th>
                <th>Detail sur le produit</th>
                <th>Autre envie</th>
                <th>Boisson</th>
                <th>Actions</th>
            </tr>';

            foreach ($_SESSION['cart'] as $key => $value) {
                $index = intval($key) + 1;
                $contenu .= '<tr>';
                $contenu .= '<td>'.$index.'</td>';
                $contenu .= '<td>'.$_SESSION['cart'][$key]['product_name'].'</td>';
                $contenu .= '<td>'.$_SESSION['cart'][$key]['prix'].'€</td>';
                $contenu .= '<td>'.$_SESSION['cart'][$key]['quantite'].'</td>';
                $contenu .= '<td>'.$_SESSION['cart'][$key]['commande_mode'].'</td>';
                $contenu .= '<td>'.$_SESSION['cart'][$key]['product_type'].'</td>';
                if (!isset($_SESSION['cart'][$key]['precision'])) {
                    $contenu .= '<td></td>';
                } else {
                    $contenu .= '<td>'.$_SESSION['cart'][$key]['precision'].'</td>';
                }
                $contenu .= '<td>'.$_SESSION['cart'][$key]['message'].'</td>';
                if (!isset($_SESSION['cart'][$key]['boisson'])) {
                    $contenu .= '<td></td>';
                }else{
                    $contenu .= '<td>'.$_SESSION['cart'][$key]['boisson'].'</td>';
                }
                $contenu .= '<td><a href="?session_id='.$key.'" onclick="return confirm(\'Êtes vous certains de vouloir supprimer ce produit du panier?\')">Supprimer<a/></td>';
                $contenu .= '</tr>';

                $somme = intval($_SESSION['cart'][$key]['quantite']) * floatval($_SESSION['cart'][$key]['prix']) + $somme;
                //print_r($_SESSION['cart'][$key]['product_name']);
                //print_r($value);
            }
            $contenu .= '</table>';
    }

?>
<div class="panier">
    <div class="panier-content">
        <h3 class="mb-5">Vos produits recapitulés</h3>
        <?php echo $contenu; ?>
        <div class="somme-total">
            <h4 style="color: rgb(14, 107, 49);">Somme total : <p><?php echo $somme;?> €</p></h4>
            <?php 
                if ($somme > 0) {
                   ?>
                   <h5>Chosir un mode de paiement</h5>
                   <select name="precision" id="payment-mode" class="form-select precision" style="width:30%">
                        <option value="Payer en ligne">Payer en ligne</option>
                        <option value="Payer sur place">Payer sur place</option>
                    </select>
                   <a href="<?php echo RACINE_SITE.$_SESSION['actuelPage']['nom_resto'] ?>/commande-validation" class="btn btn-primary byonline mt-4">Payer le montant et valider la commande</a>
                   <form action="" method="post" class="send-commande">
                       <input type="hidden" name="hidden" value="test">
                        <button type="submit" class="btn btn-primary mt-4">Valider la commande</button>
                   </form>
                   <?php
                }
            ?>
        </div>
    </div>
</div>
<script>
    var session = '<?php isset($_SESSION['user']); ?>';
    var commandeDetail = '<?php isset($_SESSION['user']); ?>';
    $(function(){
        let URL = 'http://localhost/chicken-grill/'+'<?php echo $_SESSION['actuelPage']['nom_resto'] ?>'+'/auth';
        let urlConfirmation = 'http://localhost/chicken-grill/'+'<?php echo $_SESSION['actuelPage']['nom_resto'] ?>'+'/confirmation';
        $('#payment-mode').on('change',function(){
            if ($('#payment-mode option:selected').val() == 'Payer sur place') {
                $('.panier .send-commande').css({display:'block'});
                $('.panier .byonline').css({display:'none'});
            } else {
                $('.panier .send-commande').css({display:'none'});
                $('.panier .byonline').css({display:'block'});
            }
        });
    });
</script>
<?php
    require_once '../../inc/footer.php';