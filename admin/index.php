<?php
    require_once '../inc/init.php';
    $title = 'Gestion du restaurant';
    $product_img_url = '';
    $message = '';
    $contenu = '';
    $url = 'http://localhost/chicken-grill/admin/';
    require_once '../inc/header.php';

    print_r($_POST);
    if (isset($_POST) && !empty($_POST)) {
        if (isset($_POST['photo_modifiee'])) {
            $product_img_url = $_POST['photo_modifiee'];
        }
        if (!empty($_FILES['photo']['name'])) {
            $file_name = uniqid().'_'.$_FILES['photo']['name'];
            $product_img_url = 'photos/img-product/'.$file_name;
            copy($_FILES['photo']['tmp_name'],'../'.$product_img_url);
        }
        if(!empty($_POST['product_name']) && !empty($_POST['description']) && !empty($_POST['prix']) && !empty($product_img_url)) {
            $prix_promo = 0.00;
            $promo = 'hors-promo';
            if (isset($_POST['promo']) && isset($_POST['prix_promo'])) {
                $prix_promo = $_POST['prix_promo'];
                $promo = $_POST['promo'];
            }
            
            if (isRestoAsnieresOn()) {
                executeQuery("REPLACE INTO product (product_id,product_name,product_description,prix,product_img_url,prix_promo,promo,resto_secteur,produit_type,date_enregistrement,admin_resto_id) VALUES (:product_id,:product_name,:product_description,:prix,:product_img_url,:prix_promo,:promo,:resto_secteur,:produit_type,NOW(),:admin_resto_id)",array(
                    ':product_id' => $_POST['product_id'],
                    ':product_name' => $_POST['product_name'],
                    ':product_description' => $_POST['description'],
                    ':prix' => $_POST['prix'],
                    ':product_img_url' => $product_img_url,
                    ':prix_promo' => $prix_promo,
                    ':promo' => $promo,
                    ':resto_secteur' => 'asnieres',
                    ':produit_type' => $_POST['produit_type'],
                    ':admin_resto_id' => $_SESSION['user']['user_id']
                ));
                if (isset($_POST['promo']) && isset($_POST['prix_promo'])) {
                    $message = '<div class="info">Le produit a été modifié avec succes <a href="'.$url.'">Insérer d\'autre produit</a></div>';
                }else {
                    $message = '<div class="success">Le produit a été inséré avec succes</div>';
                }
            }
        }else {
            $message = '<div class="error">Rassurez vous que tous les champs sont remplis et ressayez</div>';
        }
    }
    if (isset($_GET['product_id']) && !empty($_GET['product_id'])) {
        if (isset($_GET['action']) && $_GET['action'] == 'delete') {
            executeQuery("DELETE FROM product WHERE product_id = :product_id",array(':product_id' => $_GET['product_id']));
            $message = '<div class="info">Suppression du produit c\'est éffectué</div>';
        }else{
            $result = executeQuery("SELECT * FROM product WHERE product_id = :product_id",array(':product_id' => $_GET['product_id']));
            $produit_modifie = $result->fetch(PDO::FETCH_ASSOC);
        }
        //debug($membre_modifie);
    }
    if (isRestoAsnieresOn()) {
        $resultat = executeQuery("SELECT * FROM product WHERE resto_secteur = 'asnieres'");
        $nb_row = $resultat->rowCount();
        if ($nb_row > 0) {
            $contenu .= '<table class="table table-striped">';
            $contenu .= '<tr>
                    <th>Identifiant du produit</th>
                    <th>Nom du produit</th>
                    <th>Desciption du produit</th>
                    <th>Prix</th>
                    <th>Photo du produit</th>
                    <th>Prix promo</th>
                    <th>Action promo</th>
                    <th>Secteur</th>
                    <th>Type de produit</th>
                    <th>Date d\'enregistrement</th>
                    <th>Admin resto</th>
                    <th>Actions</th>
                </tr>';
                while ($produit = $resultat->fetch(PDO::FETCH_ASSOC)) {
                    $contenu .= '<tr>';
                    foreach ($produit as $key => $value) {
                        if ($key == 'product_img_url') {
                            $contenu .= '<td><img src="../'.$value.'" style="width:80px;"></td>';
                        }else {
                            $contenu .= '<td>'.$value.'</td>';
                        }
                    }
                    $contenu .= '<td>';
                        $contenu .= '<a href="?product_id='.$produit['product_id'].'"> <i class="fas fa-cog"></i></a>';
                        $contenu .= '<a href="?product_id='.$produit['product_id'].'&action=delete" onclick="return confirm(\'Êtes vous certains de vouloir supprimer cette ce produit?\')"> <i class="fas fa-trash-alt"></i></a>';
                    $contenu .= '</td>';
                $contenu .= '</tr>';
                    //debug($membre);
                }
                $contenu .= '</table>';
        }
    }
?>
<div class="product-data">
    <h2>Gestion des produits et reception des commandes</h2>
    <div class="gestion-product-navi">
        <nav class="nav nav-tabs">
            <p class="gestion-product nav-link active">Gestion des produits</p>
            <p class="gestion-commande nav-link">Gestion des commandes</p>
        </nav>
    </div>
    <div class="product">
        
        <div class="product-table">
            <h4>Liste des produits</h4>
            <h6>Nombre de produit actuellement enregistré <?php echo $nb_row; ?></h6>
            <?php echo $contenu;?>
        </div>
        <div class="insert-product-data">
            <div class="bloc-title">
                <h4><?php if (isset($produit_modifie)) {
                echo 'Modification du produit';
                }else{echo 'Insérer un produit dans la base de donnée';} ?></h4>
                <?php 
                    if (isset($produit_modifie)) {
                       ?>
                       <a href="<?php echo RACINE_SITE ?>admin">Retour à l'insertion du produit</a>
                       <?php
                    }
                ?>
            </div>
            <?php echo $message; ?>
            <form action="" method="post" enctype ="multipart/form-data">
                <div class="left">
                    <div class="mb-3">
                        <input type="hidden" name="product_id" value="<?php echo $produit_modifie['product_id'] ?? 0 ?>">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Nom du produit</label>
                        <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Nom du produit" value="<?php echo $produit_modifie['product_name'] ?? '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label" placeholder="Description du produit">Description du produit</label>
                        <textarea name="description" id="description" class="form-control"><?php echo $produit_modifie['product_description'] ?? '' ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Prix du produit</label>
                        <input type="text" class="form-control" id="prix" name="prix" placeholder="prix" value="<?php echo $produit_modifie['prix'] ?? '' ?>">
                    </div>
                    <?php 
                        if (isset($produit_modifie)) {
                            ?>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Prix promo</label>
                                <input type="text" class="form-control" id="prix_promo" name="prix_promo" placeholder="prix de promotion" value="<?php echo $produit_modifie['prix_promo'] ?? '' ?>">
                            </div>
                            <?php
                        }
                    ?>
                </div>
                <div class="right">
                    <?php 
                        if (isset($produit_modifie)) {
                            ?>
                            <div class="mb-3">
                                <label for="promo" class="form-label">Action sur le produit</label>
                                <select name="promo" id="promo" class="form-select">
                                    <option value="hors-promo" <?php if($produit_modifie['promo'] == 'hors-promo') echo 'selected'; ?>>Hors promo</option>
                                    <option value="en-promo" <?php if($produit_modifie['promo'] == 'en-promo') echo 'selected'; ?>>Mettre en promotion</option>
                                </select>
                            </div>
                            <?php
                        }
                    ?>
                    <div class="mb-3">
                        <label for="produit_type" class="form-label">Le type de produit</label>
                        <select name="produit_type" id="produit_type" class="form-select">
                            <option value="aucun" <?php if(isset($produit_modifie) && $produit_modifie['produit_type'] == 'aucun') echo 'selected'; ?>>Aucun</option>
                            <option value="menu" <?php if(isset($produit_modifie) && $produit_modifie['produit_type'] == 'menu') echo 'selected'; ?>>Menu</option>
                            <option value="menu-simple" <?php if(isset($produit_modifie) && $produit_modifie['produit_type'] == 'menu-simple') echo 'selected'; ?>>Menu simple</option>
                            <option value="menu-doublé" <?php if(isset($produit_modifie) && $produit_modifie['produit_type'] == 'menu-doublé') echo 'selected'; ?>>Menu doublé</option>
                            <option value="boisson" <?php if(isset($produit_modifie) && $produit_modifie['produit_type'] == 'boisson') echo 'selected'; ?>>Boisson</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="photo" class="form-label">Photo du produit</label>
                        <input class="form-control" type="file" id="formFile" name = "photo" id="photo">
                        <?php 
                        if (isset($produit_modifie['product_img_url'])) {
					        echo '<input type="hidden" name="photo_modifiee" id="photo_modifiee" value="'.$produit_modifie['product_img_url'].'">';
                        }
                        ?>
                    </div>
                    <button type="submit" class="btn btn-primary"><?php if (isset($produit_modifie)) {
                        echo 'Modifier le produit';
                    }else{echo 'Insérer le produit';} ?></button>
                </div>
            </form>
        </div>
    </div>
    <div class="commande">
    
    </div>
</div>

<script>
    $(function(){
        $('.gestion-product').on('click',function(){
            $('.product-data .product').css({display:'block'});
            $('.product-data .commande').css({display:'none'});
            if (!$('.gestion-product-navi p:first-child').hasClass('active')) {
                $('.gestion-product-navi p:first-child').addClass('active');
                $('.gestion-product-navi p:last-child').removeClass('active');
            }
        });
        $('.gestion-commande').on('click',function(){
            $('.product-data .product').css({display:'none'});
            $('.product-data .commande').css({display:'block'});
            if (!$('.gestion-product-navi p:last-child').hasClass('active')) {
                $('.gestion-product-navi p:last-child').addClass('active');
                $('.gestion-product-navi p:first-child').removeClass('active');
            }
        });
    });
</script>
<?php
    require_once '..//inc/footer.php';