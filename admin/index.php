<?php
    require_once '../inc/init.php';
    $title = 'Gestion du restaurant';
    $product_img_url = '';
    $message = '';
    $contenu = '';
    $commande = '';
    $url = 'http://localhost/chicken-grill/admin/';

    if (!isRestoAsnieresOn() && !isRestoArgenteuilOn() && !isRestoBezonsOn() && !isRestoSaintDenisOn() && !isRestoEpinaySeineOn()) {
        if (isset($_SESSION['actuelPage']['nom_resto'])) {
            header('location:'.RACINE_SITE.$_SESSION['actuelPage']);
            exit;
        }else {
            header('location:'.RACINE_SITE);
            exit;
        }
    }
    require_once '../inc/header.php';
    //print_r($_POST);
    if (isset($_POST) && !empty($_POST)) {
        if (isset($_POST['photo_modifiee'])) {
            $product_img_url = $_POST['photo_modifiee'];
            $path = '../'.$product_img_url;
            if (file_exists ( $path)) {
                echo unlink($path);
            }
            echo unlink($path);
            //print_r($_FILES);
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
            
            executeQuery("REPLACE INTO product (product_id,product_name,product_description,prix,stock,product_img_url,prix_promo,promo,produit_type,date_enregistrement,admin_resto_id) VALUES (:product_id,:product_name,:product_description,:prix,:stock,:product_img_url,:prix_promo,:promo,:produit_type,NOW(),:admin_resto_id)",array(
                ':product_id' => $_POST['product_id'],
                ':product_name' => $_POST['product_name'],
                ':product_description' => $_POST['description'],
                ':prix' => $_POST['prix'],
                ':stock' => $_POST['stock'],
                ':product_img_url' => $product_img_url,
                ':prix_promo' => $prix_promo,
                ':promo' => $promo,
                ':produit_type' => $_POST['produit_type'],
                ':admin_resto_id' => $_SESSION['user']['user_id']
            ));
            if (isset($_POST['promo']) && isset($_POST['prix_promo'])) {
                $message = '<div class="info">Le produit a été modifié avec succes <a href="'.$url.'">Insérer d\'autre produit</a></div>';
            }else {
                $message = '<div class="success">Le produit a été inséré avec succes</div>';
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
    
    $resultat = executeQuery("SELECT * FROM product");
    $nb_row = $resultat->rowCount();
    if ($nb_row > 0) {
        $contenu .= '<table class="table table-striped">';
        $contenu .= '<tr>
                <th>Identifiant du produit</th>
                <th>Nom du produit</th>
                <th>Desciption du produit</th>
                <th>Prix</th>
                <th>Stock</th>
                <th>Photo du produit</th>
                <th>Prix promo</th>
                <th>Action promo</th>
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
    if (isRestoAsnieresOn()) {
        
    }

    function restoData($resto){
        $resultat = executeQuery("SELECT * FROM commande WHERE resto = :resto",array(
            ':resto' => $resto
        ));
        return $resultat;
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
                        <label for="product_name" class="form-label">Nom du produit</label>
                        <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Nom du produit" value="<?php echo $produit_modifie['product_name'] ?? '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label" placeholder="Description du produit">Description du produit</label>
                        <textarea name="description" id="description" class="form-control"><?php echo $produit_modifie['product_description'] ?? '' ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="prix" class="form-label">Prix du produit</label>
                        <input type="text" class="form-control" id="prix" name="prix" placeholder="prix" value="<?php echo $produit_modifie['prix'] ?? '' ?>">
                    </div>
                    <?php 
                        if (isset($produit_modifie)) {
                            ?>
                            <div class="mb-3">
                                <label for="prix_promo" class="form-label">Prix promo</label>
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
                        <label for="stock" class="form-label">Stock du produit</label>
                        <input type="text" class="form-control" id="stock" name="stock" placeholder="stock" value="<?php echo $produit_modifie['stock'] ?? '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="produit_type" class="form-label">Le type de produit</label>
                        <select name="produit_type" id="produit_type" class="form-select">
                            <option value="aucun" <?php if(isset($produit_modifie) && $produit_modifie['produit_type'] == 'aucun') echo 'selected'; ?>>Aucun</option>
                            <option value="menu" <?php if(isset($produit_modifie) && $produit_modifie['produit_type'] == 'menu') echo 'selected'; ?>>Menu</option>
                            <option value="menu-simple" <?php if(isset($produit_modifie) && $produit_modifie['produit_type'] == 'menu-simple') echo 'selected'; ?>>Menu simple</option>
                            <option value="menu-doublé" <?php if(isset($produit_modifie) && $produit_modifie['produit_type'] == 'menu-doublé') echo 'selected'; ?>>Menu doublé</option>
                            <option value="déssert" <?php if(isset($produit_modifie) && $produit_modifie['produit_type'] == 'déssert') echo 'selected'; ?>>Déssert</option>
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
    <div class="commandelist">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Commade Nr.</th>
                    <th>Nom du commandeur</th>
                    <th>Commade code</th>
                    <th>Referentiel de commande</th>
                    <th>Détail de la commande</th>
                    <th>Statut de la commande</th>
                    <th>Date de la commande</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<script>
    $(function(){
        $('.gestion-product').on('click',function(){
            $('.product-data .product').css({display:'block'});
            $('.product-data .commandelist').css({display:'none'});
            if (!$('.gestion-product-navi p:first-child').hasClass('active')) {
                $('.gestion-product-navi p:first-child').addClass('active');
                $('.gestion-product-navi p:last-child').removeClass('active');
            }
        });
        $('.gestion-commande').on('click',function(){
            $('.product-data .product').css({display:'none'});
            $('.product-data .commandelist').css({display:'block'});
            if (!$('.gestion-product-navi p:last-child').hasClass('active')) {
                $('.gestion-product-navi p:last-child').addClass('active');
                $('.gestion-product-navi p:first-child').removeClass('active');
            }
            getCommandeData("asnieres","directAccess");
        });
        setInterval(() => {
            let check = <?php echo isRestoAsnieresOn(); ?>;
            if (check) {
                getCommandeData("asnieres","commande");
            }
        }, 20000);

        $('.commandelist table tbody').on('click','.modifyStatut',function(){
            let referenceId = $(this).parent().parent().find('input').val();
            $.post("../inc/controls.php",{postType:'commandeStatutUpdate',reference_id:referenceId,update:'en-cours'},function(res){
                if (res.resultat == 'ok') {
                    getCommandeData("asnieres","directAccess");
                }
            },'json');
        });
    });
    function getCommandeData(resto,postType){
        $.post("../inc/controls.php",{postType:postType,resto:resto},function(res){
            if (res.resultat) {
                console.log(res.resultat);
                let commandeData;
                for (let index = 0; index < res.resultat.length; index++) {
                    const element = res.resultat[index];
                    let commande = element.commande_detail.split('|');
                    let commandeListe ='';
                    commandeListe += '<ol>';
                    for (let i = 0; i < commande.length; i++) {
                        const el = commande[i].split('::');
                        console.log(el);
                        commandeListe += '<li>Choix';
                        commandeListe += '<ul>';
                        commandeListe += '<li>'+el[1]+' x '+el[2]+'</li>';
                        commandeListe += '<li>Type de produit : '+el[3]+'</li>';
                        commandeListe += '<li>Livraison : '+el[4]+'</li>';
                        commandeListe += '<li>Boisson : '+el[5]+'</li>';
                        commandeListe += '<li>Supplément : '+el[6]+'</li>';
                        commandeListe += '<li>Autre demande : '+el[7]+'</li>';
                        commandeListe += '</ul>';
                        commandeListe += '</li>'
                    }
                    commandeListe += '</ol>';
                    commandeData +='<tr>';
                    commandeData +='<input type="hidden" value="'+element.reference_id+'">';
                    commandeData +='<td>'+(index+1)+'</td>';
                    commandeData +='<td>'+element.nom+'</td>';
                    commandeData +='<td>'+element.commande_code+'</td>';
                    commandeData +='<td>'+element.reference_commande+'</td>';
                    commandeData +='<td>Commande'+commandeListe+'</td>';
                    if (element.commande_statut == 'reçu') {
                        commandeData +='<td style="position:relative;">'+element.commande_statut+' <span class ="recu"></span></td>';
                    }else if(element.commande_statut == 'en-cours'){
                        commandeData +='<td style="position:relative;">'+element.commande_statut+' <span class ="encour"></span></td>';
                    }else{
                        commandeData +='<td style="position:relative;>'+element.commande_statut+' <span class ="livre"></span></td>';
                    }
                    
                    commandeData +='<td>'+element.commande_date+'</td>';
                    if (element.commande_statut == 'reçu') {
                        commandeData +='<td><button class="btn btn-primary modifyStatut">En cours</button></td>';
                    } else {
                        commandeData +='<td></td>';
                    }
                    
                    commandeData +='</tr>';

                }
                $('.commandelist table tbody tr').remove();
                $('.commandelist table tbody').append(commandeData);
            }
        },'json');

    }
</script>
<?php
    require_once '..//inc/footer.php';