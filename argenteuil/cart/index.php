<?php
    require_once '../../inc/init.php';

    $title = 'Panier de commande';
    $contenu = '';
    $somme = 0.00;
    $commande_detail = '';
    $commande_code = 0;
    $email = 'chickengrill.argenteuil95@gmail.com';
    $tel = '06 21 52 65 93';
    if (!isset($_SESSION['actuelPage'])) {
       header('location:https://chicken-grill.fr/');
       exit;
    }
    if (isset($_GET) && !empty($_GET)) {
        unset($_SESSION['cart'][$_GET['session_id']]);
    }
    foreach ($_SESSION['cart'] as $key => $value) {
        $somme = intval($_SESSION['cart'][$key]['quantite']) * floatval($_SESSION['cart'][$key]['prix']) + $somme;
    }

    if (isset($_POST) && !empty($_POST)) {
        //print_r($_POST);
        if (!isOn()) {
            header('location:'.RACINE_SITE.'/'.$_SESSION['actuelPage']['nom_resto'].'/auth');
            exit;
        }else {
            if(isset($_POST['codepromo'])){
                $resultat = executeQuery("SELECT * FROM code_promo WHERE code_name =:code_name AND expiry_date > NOW() AND resto=:resto",array(
                    ':code_name' => $_POST['code_name'],
                    ':resto' => 'argenteuil'
                ));
                if($resultat->rowCount() > 0){
                    $codepromo = $resultat->fetch(PDO::FETCH_ASSOC);
                    $result = executeQuery("SELECT * FROM manage_code_promo WHERE user_id = :user_id AND code_name = :code_name",array(
                            ':user_id' => $_SESSION['user']['user_id'],
                            ':code_name' => $_POST['code_name']
                        ));
                        if($result->rowCount() > 0){
                            $managepromo = $result->fetch(PDO::FETCH_ASSOC);
                            if($codepromo['nb'] == $managepromo['nb']){
                                $message = '<div class="error">Vous avez atteint votre limit d\'utilisation du code promo</div>';
                            }elseif($codepromo['nb'] > $managepromo['nb']){
                                $somme = $somme - ($codepromo['pourcentage'] * $somme / 100);
                                $_SESSION['payment'] = floatPrice($somme);
                                $_SESSION['sale_price'] = floatPrice($somme);
                                $_SESSION['user_promo_nb'] = $managepromo['nb'];
                                $_SESSION['codepromo_update'] = 'update';
                                $_SESSION['code_name'] = $_POST['code_name'];
                                $message = '<div class="success">Code promo accepté</div>';
                            }
                        }else{
                            $somme = $somme - ($codepromo['pourcentage'] * $somme / 100);
                            $_SESSION['payment'] = floatPrice($somme);
                            $_SESSION['sale_price'] = floatPrice($somme);
                            $_SESSION['code_name'] = $_POST['code_name'];
                            $message = '<div class="success">Code promo accepté</div>';
                        }
                }else{
                    $message = '<div class="error">Votre code promo n\'est pas valide. Assurez vous que votre code promo est valide pour le restaurant Chicken grill Argenteuil</div>';
                }
            } else {
                foreach ($_SESSION['cart'] as $key => $value) {
                    if ($key == count($_SESSION['cart'])-1) {
                        $commande_detail .= $_SESSION['cart'][$key]['product_id'].'::'.$_SESSION['cart'][$key]['product_name'].'::'.$_SESSION['cart'][$key]['quantite'].'::'.$_SESSION['cart'][$key]['product_type'].'::'.$_SESSION['cart'][$key]['commande_mode'].'::'.$_SESSION['cart'][$key]['boisson'].'::'.$_SESSION['cart'][$key]['precision'].'::'.$_SESSION['cart'][$key]['message'];
                    } else {
                        $commande_detail .= $_SESSION['cart'][$key]['product_id'].'::'.$_SESSION['cart'][$key]['product_name'].'::'.$_SESSION['cart'][$key]['quantite'].'::'.$_SESSION['cart'][$key]['product_type'].'::'.$_SESSION['cart'][$key]['commande_mode'].'::'.$_SESSION['cart'][$key]['boisson'].'::'.$_SESSION['cart'][$key]['precision'].'::'.$_SESSION['cart'][$key]['message'].'|';
                    }
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
                
                if(isset($_SESSION['sale_price'])){
                    $somme = $_SESSION['sale_price'];
                    if(isset($_SESSION['codepromo_update'])){
                        executeQuery("UPDATE manage_code_promo SET nb = :nb WHERE code_name =:code_name AND user_id =:user_id",array(
                                ':nb' => intval($_SESSION['user_promo_nb']) +1,
                                ':code_name' => $_SESSION['code_name'],
                                ':user_id' => $_SESSION['user']['user_id']
                            ));
                            insertCommande($commande_code,$somme,$commande_detail);
                    }else{
                        executeQuery("INSERT INTO manage_code_promo (user_id,nb,code_name) VALUES(:user_id,:nb,:code_name)",array(
                                ':user_id' => $_SESSION['user']['user_id'],
                                ':nb' => 1,
                                ':code_name' => $_SESSION['code_name']
                            ));
                        insertCommande($commande_code,$somme,$commande_detail);
                    }
                    
                }else{
                    insertCommande($commande_code,$somme,$commande_detail);
                }
            }
        }
    }
    require_once '../../inc/header.php';
    //print_r($_SESSION['cart']);
    
    if (!isset($_SESSION['cart'])) {
        $contenu = '<p>Vous n\'avez pour l\'instant choisi aucun produit. <a href="'.RACINE_SITE.'/'.$_SESSION['actuelPage']['nom_resto'].'/product">Choisir un produit</a></p>';
    }else {
        $contenu .= '<table class="table table-striped">';
        $contenu .= '<tr>
                <th>Nr.</th>
                <th>Nom du produit</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Mode de commande</th>
                <th>Type de produit</th>
                <th>Sauce</th>
                <th>Autre envie</th>
                <th>Boisson</th>
                <th>Actions</th>
            </tr>';

            foreach ($_SESSION['cart'] as $key => $value) {
                $index = intval($key) + 1;
                $contenu .= '<tr>';
                $contenu .= '<td>'.$index.'</td>';
                $contenu .= '<td>'.$_SESSION['cart'][$key]['product_name'].'</td>';
                $contenu .= '<td>'.str_replace('.',',',$_SESSION['cart'][$key]['prix']).'€</td>';
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
            }
            $contenu .= '</table>';
    }

?>
<div class="panier">
    <div class="panier-content">
        <h3 class="mb-5">Vos produits recapitulés</h3>
        <?php echo $contenu; ?>
        <div class="cart-bloc">
            <div class="cart-code-promo">
                <h6 class="mb-4">Code promo</h6>
                <?php echo $message; ?>
                <form method="post">
                    <div class="mb-3">
                        <label for="codename" class="form-label">Entrer le code</label>
                        <input type="text" class="form-control" id="codename" name="code_name" placeholder="CHICKEN-GRILL555">
                    </div>
                    <button class="btn btn-primary" type="submit" name="codepromo">Vérifier</button>
                </form>
            </div>
            <div class="somme-total">
                <h4 class="mb-4" style="color: rgb(14, 107, 49);">Somme total : <p><?php
                    if(isset($_SESSION['payment'])){
                        $somme = str_replace('.',',',$_SESSION['payment']);
                        echo $somme;
                    }else{
                        echo str_replace('.',',',floatPrice($somme));
                    }
                ?> €</p></h4> 
                <?php 
                    if ($somme > 0) {
                       ?>
                       <h5>Chosir un mode de paiement</h5>
                       <select name="precision" id="payment-mode" class="form-select precision">
                            <option value="Payer en ligne">Payer en ligne</option>
                            <option value="Payer sur place">Payer sur place</option>
                        </select>
                       <a href="<?php echo RACINE_SITE.'/'.$_SESSION['actuelPage']['nom_resto'] ?>/commande-validation" class="btn btn-primary byonline mt-4">Payer le montant et valider la commande</a>
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
</div>
<script>
    var session = '<?php isset($_SESSION['user']); ?>';
    var commandeDetail = '<?php isset($_SESSION['user']); ?>';
    $(function(){
        let URL = 'https://chicken-grill.fr/'+'<?php echo $_SESSION['actuelPage']['nom_resto'] ?>'+'/auth';
        let urlConfirmation = 'https://chicken-grill.fr/'+'<?php echo $_SESSION['actuelPage']['nom_resto'] ?>'+'/confirmation';
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
    window.onbeforeunload = function(){
      '<?php unset($_SESSION['payment']); ?>';
    };
</script>
<?php
    require_once '../../inc/footer.php';