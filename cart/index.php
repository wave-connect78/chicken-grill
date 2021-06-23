<?php
    require_once '../inc/init.php';

    $title = 'Panier de commande';
    $contenu = '';
    $somme = 0.00;

    if (isset($_GET) && !empty($_GET)) {
        unset($_SESSION['cart'][$_GET['session_id']]);
    }

    require_once '../inc/header.php';
    //print_r($_SESSION['cart']);
    
    if (!isset($_SESSION['cart'])) {
        $contenu = '<p>Vous n\'avez pour l\'instant choisi aucun produit. <a href="">Choisir un produit</a></p>';
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
                $contenu .= '<td>'.$_SESSION['cart'][$key]['precision'].'</td>';
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
            <h4>Somme total : <p><?php echo $somme;?> €</p></h4>
            <a href="" class="btn btn-primary">Valider la commande</a>
        </div>
    </div>
</div>
<?php
    require_once '../inc/footer.php';