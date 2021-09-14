<?php
    require_once '../inc/init.php';
    $title = 'Gestion du restaurant';
    $product_img_url = '';
    $message = '';
    $contenu = '';
    $commande = '';
    $stockState = '';
    $nbcommande = 0;
    $url = 'https://chicken-grill.fr/admin/';

    if (!isRestoAsnieresOn() && !isRestoArgenteuilOn() && !isRestoBezonsOn() && !isRestoSaintDenisOn() && !isRestoEpinaySeineOn() && !isSuperAdminOn()) {
        if (isset($_SESSION['actuelPage']['nom_resto'])) {
            header('location:'.RACINE_SITE.'/'.$_SESSION['actuelPage']);
            exit;
        }else {
            header('location:https://chicken-grill.fr');
            exit;
        }
    }
    require_once '../inc/header.php';
    if (isset($_POST) && !empty($_POST)) {
        if (isset($_POST['rupture'])) {
            executeQuery("INSERT INTO manage_stock (product_id,stock_statut,resto) VALUES(:product_id,:stock_statut,:resto)",array(
                ':product_id' => $_POST['product_id'],
                ':stock_statut' => 'rupture',
                ':resto' => $_POST['resto']
            ));
            $message = '<div class="info">Le produit est maintenant en rupture <a href="'.$url.'">Insérer d\'autre produit</a></div>';
        }elseif (isset($_POST['stock'])) {
            executeQuery("DELETE FROM manage_stock WHERE product_id = :product_id AND resto = :resto",array(
                ':resto' => $_POST['resto'],
                ':product_id' => $_POST['product_id']
            ));
            $message = '<div class="info">Le produit est de nouveau en stock <a href="'.$url.'">Insérer d\'autre produit</a></div>';
        }else{
            if (isset($_POST['photo_modifiee'])) {
                if (!empty($_FILES['photo']['name'])) {
                    $product_img_url = $_POST['photo_modifiee'];
                    $path = '../'.$product_img_url;
                    if (file_exists ( $path)) {
                        echo unlink($path);
                    }
                }else{
                    $product_img_url = $_POST['photo_modifiee'];
                }
                //echo unlink($path);
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
                
                executeQuery("REPLACE INTO product (product_id,product_name,sub_name,product_description,prix,product_img_url,prix_promo,promo,produit_type,date_enregistrement,admin_resto_id) VALUES (:product_id,:product_name,:sub_name,:product_description,:prix,:product_img_url,:prix_promo,:promo,:produit_type,NOW(),:admin_resto_id)",array(
                    ':product_id' => $_POST['product_id'],
                    ':product_name' => $_POST['product_name'],
                    ':sub_name' => $_POST['cname'],
                    ':product_description' => $_POST['description'],
                    ':prix' => $_POST['prix'],
                    ':product_img_url' => $product_img_url,
                    ':prix_promo' => $prix_promo,
                    ':promo' => $promo,
                    ':produit_type' => $_POST['produit_type'],
                    ':admin_resto_id' => $_SESSION['user']['user_id']
                ));
                if (isset($_POST['promo']) && isset($_POST['prix_promo'])) {
                    $message = '<div class="info">Le produit a été modifié avec succès <a href="'.$url.'">Insérer d\'autre produit</a></div>';
                }else {
                    $message = '<div class="success">Le produit a été inséré avec succès</div>';
                }
                
            }else {
                $message = '<div class="error">Rassurez vous que tous les champs sont remplis et réessayez</div>';
            }
        }
    }
    if(isset($_GET)){
        if (isset($_GET['product_id']) && !empty($_GET['product_id'])) {
            if (isset($_GET['action']) && $_GET['action'] == 'delete') {
                executeQuery("DELETE FROM product WHERE product_id = :product_id",array(':product_id' => $_GET['product_id']));
                $message = '<div class="info">Suppression du produit c\'est effectué</div>';
            }else{
                $result = executeQuery("SELECT p.product_id,p.product_name,p.sub_name,p.product_description,p.prix,m.stock_statut,p.product_img_url,p.prix_promo,p.promo,p.produit_type,p.date_enregistrement FROM product p LEFT JOIN manage_stock m ON p.product_id = m.product_id WHERE p.product_id = :product_id",array(':product_id' => $_GET['product_id']));
                $produit_modifie = $result->fetch(PDO::FETCH_ASSOC);
            }
            //debug($membre_modifie);
        }elseif(isset($_GET['codepromo_id']) && !empty($_GET['codepromo_id'])){
            if(isset($_GET['action']) && $_GET['action'] == 'delete'){
                executeQuery("DELETE FROM code_promo WHERE code_promo_id = :codepromo_id",array(':codepromo_id' => $_GET['codepromo_id']));
                $message = '<div class="info">Suppression du code promo effectué</div>';
            }
        }
    }
    
    
    
    $resultat = executeQuery("SELECT p.product_id,p.product_name,p.sub_name,p.product_description,p.prix,m.stock_statut,m.resto,p.product_img_url,p.prix_promo,p.promo,p.produit_type,p.date_enregistrement FROM product p LEFT JOIN manage_stock m ON p.product_id = m.product_id");
    $nb_row = $resultat->rowCount();
    if ($nb_row > 0) {
        $contenu .= '<table class="table table-striped">';
        $contenu .= '<tr>
                <th>Nom du produit</th>
                <th>Nom complémentaire</th>
                <th>Description du produit</th>
                <th>Prix</th>
                <th>Stock</th>
                <th>Photo du produit</th>
                <th>Prix promo</th>
                <th>Action promo</th>
                <th>Type de produit</th>
                <th>Date d\'enregistrement</th>
                <th>Actions</th>
            </tr>';
            while ($produit = $resultat->fetch(PDO::FETCH_ASSOC)) {
                //print_r($produit);
                $contenu .= '<tr>';
                $contenu .= '<td>'.$produit['product_name'].'</td>';
                $contenu .= '<td>'.$produit['sub_name'].'</td>';
                $contenu .= '<td>'.$produit['product_description'].'</td>';
                $contenu .= '<td>'.$produit['prix'].'</td>';
                
                if(isRestoAsnieresOn()){
                    if($produit['resto'] == 'asnieres'){
                        if($produit['stock_statut'] == 'rupture'){
                            $contenu .= '<td>'.$produit['stock_statut'].'</td>';
                        }else{
                            $contenu .= '<td>Stock</td>';
                        }
                    }else{
                        $contenu .= '<td>Stock</td>';
                    }
                }elseif(isRestoArgenteuilOn()){
                    if($produit['resto'] == 'argenteuil'){
                        if($produit['stock_statut'] == 'rupture'){
                            $contenu .= '<td>'.$produit['stock_statut'].'</td>';
                        }else{
                            $contenu .= '<td>Stock</td>';
                        }
                    }else{
                        $contenu .= '<td>Stock</td>';
                    }
                }elseif(isRestoBezonsOn()){
                    if($produit['resto'] == 'bezons'){
                        if($produit['stock_statut'] == 'rupture'){
                            $contenu .= '<td>'.$produit['stock_statut'].'</td>';
                        }else{
                            $contenu .= '<td>Stock</td>';
                        }
                    }else{
                        $contenu .= '<td>Stock</td>';
                    }
                }elseif(isRestoSaintDenisOn()){
                    if($produit['resto'] == 'saint-denis'){
                        if($produit['stock_statut'] == 'rupture'){
                            $contenu .= '<td>'.$produit['stock_statut'].'</td>';
                        }else{
                            $contenu .= '<td>Stock</td>';
                        }
                    }else{
                        $contenu .= '<td>Stock</td>';
                    }
                }elseif(isRestoEpinaySeineOn()){
                    if($produit['resto'] == 'epinay-seine'){
                        if($produit['stock_statut'] == 'rupture'){
                            $contenu .= '<td>'.$produit['stock_statut'].'</td>';
                        }else{
                            $contenu .= '<td>Stock</td>';
                        }
                    }else{
                        $contenu .= '<td>Stock</td>';
                    }
                }
                    
                
                
                $contenu .= '<td><img src="../'.$produit['product_img_url'].'" style="width:80px;"></td>';
                $contenu .= '<td>'.$produit['prix_promo'].'</td>';
                $contenu .= '<td>'.$produit['promo'].'</td>';
                $contenu .= '<td>'.$produit['produit_type'].'</td>';
                $contenu .= '<td>'.$produit['date_enregistrement'].'</td>';
                $contenu .= '<td>';
                    $contenu .= '<a href="?product_id='.$produit['product_id'].'"> <i class="fas fa-cog"></i></a>';
                    $contenu .= '<a href="?product_id='.$produit['product_id'].'&action=delete" onclick="return confirm(\'Êtes vous certains de vouloir supprimer ce produit?\')"> <i class="fas fa-trash-alt"></i></a>';
                $contenu .= '</td>';
            $contenu .= '</tr>';
                //debug($membre);
            }
            $contenu .= '</table>';
    }
    
?>

<div class="codepromoover">
    <div class="codepromo">
        <form method="post">
            <div class="mb-3">
                <label for="codename" class="form-label">Définir un code</label>
                <input type="text" class="form-control" id="codename" name="code_name" placeholder="CHICKEN-GRILL555">
            </div>
            <div class="mb-3">
                <label for="pourcentage" class="form-label">Pourcentage de réduction</label>
                <input type="text" class="form-control" id="pourcentage" name="pourcentage" placeholder="5">
            </div>
            <div class="mb-3">
                <label for="nb" class="form-label">Définir le nombre d'utilisation du code promo</label>
                <input type="number" class="form-control" id="nb" name="pourcentage" placeholder="2" min="1">
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date d'expiration du code</label>
                <input type="date" class="form-control" id="date" name="date" placeholder="02/08/2021" min="<?php echo date("Y-m-d",strtotime("+1 day")); ?>">
            </div>
            <div class="form-button">
                <button type="submit" class="btn btn-primary saveCode">Enregistrer le code</button>
                <button class="btn btn-primary reset">Annuler</button>
            </div>
        </form>
    </div>
</div>
       
<div class="blocfiltre">
     <div class="bloccontentfiltre">
         <form method="post">
            <div class="mb-3">
                <label for="startdate" class="form-label">Définir une date de départ</label>
                <input type="date" class="form-control" id="startdate" name="startdate" placeholder="02/05/2020" max="<?php echo date("Y-m-d"); ?>">
            </div>
            <div class="mb-3">
                <label for="enddate" class="form-label">Définir une date de fin</label>
                <input type="date" class="form-control" id="enddate" name="enddate" placeholder="02/05/2020" max="<?php echo date("Y-m-d"); ?>">
            </div>
            <div class="form-button">
                <button type="submit" class="btn btn-primary send">Envoyer</button>
                <button class="btn btn-primary reset">Annuler</button>
            </div>
        </form>
     </div>
</div>
<div class="product-data">
    <?php 
        if (isRestoAsnieresOn() || isRestoArgenteuilOn() || isRestoBezonsOn() || isRestoSaintDenisOn() || isRestoEpinaySeineOn()) {
            $resultat = executeQuery("SELECT * FROM switch WHERE resto = :resto",array(
               ':resto' => $_SESSION['actuelPage']['nom_resto'] 
            ));
            $switch = $resultat->fetch(PDO::FETCH_ASSOC);
            ?>
            <label class="switch">
              <input type="checkbox" <?php if($switch['switch_state'] == 'on') echo 'checked class="on"'; else echo 'class="off"' ?>>
              <div class="slider <?php if($switch['switch_state'] == 'on') echo 'on'; else echo 'off'?> round"></div>
            </label>
            <?php
        }
    ?>
    <h2>Bienvenu dans le backoffice chicken grill</h2>
    <p class="info text-center">Si vous n'êtes pas administrateur, nous vous prions de ne rien modifier sur cette page et vous déconnecter en vous rendant simplement sur la page profil ou cliquer simplement <a href="/<?php echo $_SESSION['actuelPage']['nom_resto']?>/profil">ici</a>.</p>
    <?php 
        if(isSuperAdminOn()){
            ?>
            <h4 class="text-center">Données statistique du restaurant chicken grill</h4>
            <?php
        }else{
             ?>
            <h4 class="text-center">Gestion des produits et réception des commandes</h4>
            <?php
        }
        
    ?>
    
    <div class="gestion-product-navi">
        <nav class="nav nav-tabs">
            <?php 
                if(isSuperAdminOn()){
                    ?>
                    <p class="client nav-link active">Gestion des clients</p>
                    <p class="stat nav-link">Données statistiques de la boutique</p>
                    <?php
                }else{
                    ?>
                    <p class="gestion-product nav-link active">Gestion des produits</p>
                    <p class="gestion-commande nav-link">Gestion des commandes</p>
                    <p class="historique-commande nav-link">Historique des commandes</p>
                    <p class="client nav-link">Gestion des clients</p>
                    <p class="code nav-link">Gestion des codes promos</p>
                    <?php
                }
            ?>
        </nav>
    </div>
    <div class="product">
        <?php 
            if(isRestoAsnieresOn() || isRestoArgenteuilOn() || isRestoBezonsOn() || isRestoSaintDenisOn() || isRestoEpinaySeineOn()){
                ?>
                    <div class="product-table">
                        <h4 class="mb-4">Liste des produits</h4>
                        <div class="product-table-top">
                            <h6 class="mb-4">Nombre de produit actuellement enregistré <?php echo $nb_row; ?></h6>
                            <div class="btn btn-primary createpromocode">Créer un code promo</div>
                        </div>
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
                                   <a href="<?php echo RACINE_SITE ?>/admin">Retour à l'insertion du produit</a>
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
                                    <label for="product_name" class="form-label">Nom du produit*</label>
                                    <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Nom du produit" value="<?php echo $produit_modifie['product_name'] ?? '' ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="cname" class="form-label">Nom complémentaire (facultatif)</label>
                                    <input type="text" class="form-control" id="cname" name="cname" placeholder="Nom complémentaire" value="<?php echo $produit_modifie['sub_name'] ?? '' ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label" placeholder="Description du produit">Description du produit*</label>
                                    <textarea name="description" id="description" class="form-control"><?php echo $produit_modifie['product_description'] ?? '' ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="prix" class="form-label">Prix du produit*</label>
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
                                                <option value="hors-promo" <?php if($produit_modifie['promo'] == 'hors-promo') echo 'selected'; ?>>Mettre hors promo</option>
                                                <option value="en-promo" <?php if($produit_modifie['promo'] == 'en-promo') echo 'selected'; ?>>Mettre en promotion</option>
                                            </select>
                                        </div>
                                        <?php
                                    }
                                ?>
                                <div class="mb-3">
                                    <label for="produit_type" class="form-label">Le type de produit*</label>
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
                                    <label for="photo" class="form-label">Photo du produit*</label>
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
                                <?php 
                                    if (isset($produit_modifie) && $produit_modifie['stock_statut'] == '') {
                                        ?>
                                        <form action="" method="post">
                                            <input type="hidden" name= "product_id" value="<?php echo $produit_modifie['product_id'];?>">
                                            <?php 
                                                if(isRestoAsnieresOn()){
                                                    ?>
                                                    <input type="hidden" name= "resto" value="asnieres">
                                                    <?php
                                                }elseif(isRestoArgenteuilOn()){
                                                    ?>
                                                    <input type="hidden" name= "resto" value="argenteuil">
                                                    <?php
                                                }elseif(isRestoBezonsOn()){
                                                    ?>
                                                    <input type="hidden" name= "resto" value="bezons">
                                                    <?php
                                                }elseif(isRestoSaintDenisOn()){
                                                    ?>
                                                    <input type="hidden" name= "resto" value="saint-denis">
                                                    <?php
                                                }elseif(isRestoEpinaySeineOn()){
                                                    ?>
                                                    <input type="hidden" name= "resto" value="epinay-seine">
                                                    <?php
                                                }
                                            ?>
                                            <input type="submit" class="btn btn-primary" value="Mettre le produit en rupture de stock" name="rupture">
                                        </form>
                                        <?php
                                    }
                                    if (isset($produit_modifie) && $produit_modifie['stock_statut'] == 'rupture') {
                                        ?>
                                        <form action="" method="post">
                                            <input type="hidden" name= "product_id" value="<?php echo $produit_modifie['product_id'];?>">
                                            <?php 
                                                if(isRestoAsnieresOn()){
                                                    ?>
                                                    <input type="hidden" name= "resto" value="asnieres">
                                                    <?php
                                                }elseif(isRestoArgenteuilOn()){
                                                    ?>
                                                    <input type="hidden" name= "resto" value="argenteuil">
                                                    <?php
                                                }elseif(isRestoBezonsOn()){
                                                    ?>
                                                    <input type="hidden" name= "resto" value="bezons">
                                                    <?php
                                                }elseif(isRestoSaintDenisOn()){
                                                    ?>
                                                    <input type="hidden" name= "resto" value="saint-denis">
                                                    <?php
                                                }elseif(isRestoEpinaySeineOn()){
                                                    ?>
                                                    <input type="hidden" name= "resto" value="epinay-seine">
                                                    <?php
                                                }
                                            ?>
                                            <input type="submit" class="btn btn-primary" value="Réaprovisionner le produit" name="stock">
                                        </form>
                                        <?php
                                    }
                                ?>
                            </div>
                        </form>
                    </div>
                <?php
            }
        ?>
    </div>
    <div class="commandelist">
        <div class="nbcommande">Nous avons <span></span> nouvelle commande</div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Commade Nr.</th>
                    <th>Nom du commandeur</th>
                    <th>Commande code</th>
                    <th>Référentiel de commande</th>
                    <th>Détail de la commande</th>
                    <th>Prix</th>
                    <th>Mode de paiement</th>
                    <th>Statut de la commande</th>
                    <th>Date de la commande</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <div class="commandehistorique">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nr. commande</th>
                    <th>Nom</th>
                    <th>Réference de commande</th>
                    <th>Détail de la commande</th>
                    <th>Prix</th>
                    <th>Statut de la commande</th>
                    <th>Date de la commande</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <div class="gestion-client">
        <button class="btn btn-primary" onClick="exportTableToExcel('fichier-client')">Excel</button>
        <button class="btn btn-primary" onClick="exportTableToCSV('fichier-client.csv')">CSV</button>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nr.</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Statut</th>
                    <th>Email vérifié</th>
                    <th>Nombre de commande réalisée</th>
                    <th>Date d'enregistrement</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <div class="donnee-statistique">
        <div class="stat-content">
            <div class="stfiltre">Filtrer par période <i class="fas fa-sliders-h"></i></div>
            <div class="item"><canvas class="stNb"></canvas><div class="nbcommande"></div></div>
            <hr>
            <div class="item"><div class="paiementcaisse"></div><canvas class="stPC"></canvas></div>
            <hr>
            <div class="item"><canvas class="stPO"></canvas><div class="paiementoline"></div></div>
            <hr>
            <div class="item"><div class="sommetotal"></div><canvas class="stST"></canvas></div>
        </div>
        <div class="totaux"></div>
    </div>
    <div class="promocode">
        <div class="code-content">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nr.</th>
                        <th>Nom du code</th>
                        <th>Pourcentage de réduction</th>
                        <th>Nombre d'utilisation</th>
                        <th>Date d'expiration</th>
                        <th>Nom du restaurant</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<script>
    let count = 0;
    let rowIndex = 0;
    let chartArray = [];
    $(function(){
        $('.code').on('click',function(){
            $('.product-data .product').css({display:'none'});
            $('.product-data .commandelist').css({display:'none'});
            $('.product-data .commandehistorique').css({display:'none'});
            $('.product-data .gestion-client').css({display:'none'});
            $('.product-data .donnee-statistique').css({display:'none'});
            $('.product-data .promocode').css({display:'block'});
            $('.client').removeClass('active');
            $(this).removeClass('active');
            $('.gestion-commande').removeClass('active');
            $('.historique-commande').removeClass('active');
            $(this).addClass('active');
            $('.stat').removeClass('active');
            $('.gestion-product').removeClass('active');
            getPromocodeData();
        });
        $('.stat').on('click',function(){
            $('.product-data .product').css({display:'none'});
            $('.product-data .commandelist').css({display:'none'});
            $('.product-data .commandehistorique').css({display:'none'});
            $('.product-data .gestion-client').css({display:'none'});
            $('.product-data .donnee-statistique').css({display:'block'});
            $('.client').removeClass('active');
            $(this).removeClass('active');
            $('.gestion-commande').removeClass('active');
            $('.historique-commande').removeClass('active');
            $(this).addClass('active');
            $('.code').removeClass('active');
            $('.product-data .promocode').css({display:'none'});
            $('.gestion-product').removeClass('active');
            getStat('',0,0);
        });
        $('.gestion-product').on('click',function(){
            $('.product-data .product').css({display:'block'});
            $('.product-data .commandelist').css({display:'none'});
            $('.product-data .commandehistorique').css({display:'none'});
            $('.product-data .gestion-client').css({display:'none'});
            $('.product-data .donnee-statistique').css({display:'none'});
             $('.client').removeClass('active');
             $('.stat').removeClass('active');
            $(this).removeClass('active');
            $('.gestion-commande').removeClass('active');
            $('.historique-commande').removeClass('active');
            $(this).addClass('active');
            $('.code').removeClass('active');
            $('.product-data .promocode').css({display:'none'});
        });
        $('.gestion-commande').on('click',function(){
            $('.product-data .product').css({display:'none'});
            $('.product-data .commandelist').css({display:'block'});
            $('.product-data .commandehistorique').css({display:'none'});
            $('.product-data .gestion-client').css({display:'none'});
            $('.product-data .donnee-statistique').css({display:'none'});
             $('.stat').removeClass('active');
             $('.client').removeClass('active');
            $(this).removeClass('active');
            $('.gestion-product').removeClass('active');
            $('.historique-commande').removeClass('active');
            $(this).addClass('active');
            $('.code').removeClass('active');
            $('.product-data .promocode').css({display:'none'});
            if ('<?php echo isRestoAsnieresOn(); ?>') {
                getCommandeData("asnieres","directAccess","");
            }else if ('<?php echo isRestoArgenteuilOn(); ?>') {
                getCommandeData("argenteuil","directAccess","");
            }else if('<?php echo isRestoBezonsOn(); ?>'){
                getCommandeData("bezons","directAccess","");
            }else if ('<?php echo isRestoSaintDenisOn(); ?>') {
                getCommandeData("saint-denis","directAccess","");
            }else if('<?php echo isRestoEpinaySeineOn(); ?>'){
                getCommandeData("epinay-seine","directAccess","");
            }
        });
        $('.historique-commande').on('click',function(){
            $('.product-data .product').css({display:'none'});
            $('.product-data .commandelist').css({display:'none'});
            $('.product-data .commandehistorique').css({display:'block'});
            $('.product-data .gestion-client').css({display:'none'});
            $('.product-data .donnee-statistique').css({display:'none'});
             $('.stat').removeClass('active');
             $('.client').removeClass('active');
            $(this).removeClass('active');
            $('.gestion-product').removeClass('active');
            $('.gestion-commande').removeClass('active');
            $(this).addClass('active');
            $('.code').removeClass('active');
            $('.product-data .promocode').css({display:'none'});
            if ('<?php echo isRestoAsnieresOn(); ?>') {
                getCommandeHistoryData('asnieres',0);
            }else if ('<?php echo isRestoArgenteuilOn(); ?>') {
                getCommandeHistoryData('argenteuil',0);
            }else if('<?php echo isRestoBezonsOn(); ?>'){
                getCommandeHistoryData('bezons',0);
            }else if ('<?php echo isRestoSaintDenisOn(); ?>') {
                getCommandeHistoryData('saint-denis',0);
            }else if('<?php echo isRestoEpinaySeineOn(); ?>'){
                getCommandeHistoryData('epinay-seine',0);
            }
        });
        $('.client').on('click',function(){
            $('.product-data .product').css({display:'none'});
            $('.product-data .commandelist').css({display:'none'});
            $('.product-data .commandehistorique').css({display:'none'});
            $('.product-data .gestion-client').css({display:'block'});
            $('.product-data .donnee-statistique').css({display:'none'});
            $(this).removeClass('active');
            $('.gestion-product').removeClass('active');
            $('.gestion-commande').removeClass('active');
            $('.historique-commande').removeClass('active');
            $(this).addClass('active');
            $('.stat').removeClass('active');
            $('.code').removeClass('active');
            $('.product-data .promocode').css({display:'none'});
            getClientData(0);
        });
        setInterval(() => {
            if ('<?php echo isRestoAsnieresOn(); ?>') {
                getCommandeData("asnieres","commande","");
            }else if ('<?php echo isRestoArgenteuilOn(); ?>') {
                getCommandeData("argenteuil","commande","");
            }else if('<?php echo isRestoBezonsOn(); ?>'){
                getCommandeData("bezons","commande","");
            }else if ('<?php echo isRestoSaintDenisOn(); ?>') {
                getCommandeData("saint-denis","commande","");
            }else if('<?php echo isRestoEpinaySeineOn(); ?>'){
                getCommandeData("epinay-seine","commande","");
            }
        }, 60000);

        $('.commandelist table tbody').on('click','.modifyStatut',function(){
            let code = $(this).parent().parent().find('input').val();
            $.post("../inc/controls.php",{postType:'commandeStatutUpdate',code:code,update:'en-préparation'},function(res){
                if (res.resultat == 'ok') {
                    if ('<?php echo isRestoAsnieresOn(); ?>') {
                        if(count > 0){
                            count = count - 1;
                        }
                        getCommandeData("asnieres","directAccess","update");
                    }else if ('<?php echo isRestoArgenteuilOn(); ?>') {
                        if(count > 0){
                            count = count - 1;
                        }
                        getCommandeData("argenteuil","directAccess","update");
                    }else if('<?php echo isRestoBezonsOn(); ?>'){
                        if(count > 0){
                            count = count - 1;
                        }
                        getCommandeData("bezons","directAccess","update");
                    }else if ('<?php echo isRestoSaintDenisOn(); ?>') {
                        if(count > 0){
                            count = count - 1;
                        }
                        getCommandeData("saint-denis","directAccess","update");
                    }else if('<?php echo isRestoEpinaySeineOn(); ?>'){
                        if(count > 0){
                            count = count - 1;
                        }
                        getCommandeData("epinay-seine","directAccess","update");
                    }
                }
            },'json');
        });
        $('.commandelist table tbody').on('click','.finprepa',function(){
            let code = $(this).parent().parent().find('input').val();
            $.post("../inc/controls.php",{postType:'commandeStatutUpdate',code:code,update:'fini'},function(res){
                if (res.resultat == 'ok') {
                    if ('<?php echo isRestoAsnieresOn(); ?>') {
                        getCommandeData("asnieres","directAccess","");
                    }else if ('<?php echo isRestoArgenteuilOn(); ?>') {
                        getCommandeData("argenteuil","directAccess","");
                    }else if('<?php echo isRestoBezonsOn(); ?>'){
                        getCommandeData("bezons","directAccess","");
                    }else if ('<?php echo isRestoSaintDenisOn(); ?>') {
                        getCommandeData("saint-denis","directAccess","");
                    }else if('<?php echo isRestoEpinaySeineOn(); ?>'){
                        getCommandeData("epinay-seine","directAccess","");
                    }
                }
            },'json');
        });
        $('.commandelist table tbody').on('click','.plivre',function(){
            let code = $(this).parent().parent().find('input').val();
            $.post("../inc/controls.php",{postType:'commandeStatutUpdateLivre',code:code,update:'livré'},function(res){
                if (res.resultat == 'ok') {
                    if ('<?php echo isRestoAsnieresOn(); ?>') {
                        getCommandeData("asnieres","directAccess","");
                    }else if ('<?php echo isRestoArgenteuilOn(); ?>') {
                        getCommandeData("argenteuil","directAccess","");
                    }else if('<?php echo isRestoBezonsOn(); ?>'){
                        getCommandeData("bezons","directAccess","");
                    }else if ('<?php echo isRestoSaintDenisOn(); ?>') {
                        getCommandeData("saint-denis","directAccess","");
                    }else if('<?php echo isRestoEpinaySeineOn(); ?>'){
                        getCommandeData("epinay-seine","directAccess","");
                    }
                }
            },'json');
        });
        $('.commandehistorique').on('click','.moreData',function(){
            let i = 0;
            $('.commandehistorique table tbody tr').each(function(){
                i++;
            });
            $('.commandehistorique .moreData').remove();
            if ('<?php echo isRestoAsnieresOn(); ?>') {
                getCommandeHistoryData('asnieres',i);
            }else if ('<?php echo isRestoArgenteuilOn(); ?>') {
                getCommandeHistoryData('argenteuil',i);
            }else if('<?php echo isRestoBezonsOn(); ?>'){
                getCommandeHistoryData('bezons',i);
            }else if ('<?php echo isRestoSaintDenisOn(); ?>') {
                getCommandeHistoryData('saint-denis',i);
            }else if('<?php echo isRestoEpinaySeineOn(); ?>'){
                getCommandeHistoryData('epinay-seine',i);
            }
        });
        $('.gestion-client').on('click','.moreClientData',function(){
            let i = 0;
            $('.moreClientData').remove();
            $('.gestion-client table tbody tr').each(function(){
                i++;
            });
            getClientData(i);
            rowIndex = i;
        });
        
        $('.createpromocode').on('click',function(e){
           $('.codepromoover').css({display:'flex'});
        });
        $('.codepromoover form').on('submit',function(e){
            e.preventDefault();
            let date = $('.codepromo #date').val();
            let codename = $('.codepromo #codename').val();
            let pourcentage = $('.codepromo #pourcentage').val();
            let nb = $('.codepromo #nb').val();
            if(date == '' || codename == '' || pourcentage ==''|| nb == ''){
                alert('Rassurez vous que tous les champs sont remplis');
            }else{
                let data = '';
                if ('<?php echo isRestoAsnieresOn(); ?>') {
                    data= {postType:'codepromo',code_name:codename,pourcentage:pourcentage,expiry_date:date,resto:'asnieres',nb:nb};
                }else if ('<?php echo isRestoArgenteuilOn(); ?>') {
                    data= {postType:'codepromo',code_name:codename,pourcentage:pourcentage,expiry_date:date,resto:'argenteuil',nb:nb};
                }else if('<?php echo isRestoBezonsOn(); ?>'){
                    data= {postType:'codepromo',code_name:codename,pourcentage:pourcentage,expiry_date:date,resto:'bezons',nb:nb};
                }else if ('<?php echo isRestoSaintDenisOn(); ?>') {
                    data= {postType:'codepromo',code_name:codename,pourcentage:pourcentage,expiry_date:date,resto:'saint-denis',nb:nb};
                }else if('<?php echo isRestoEpinaySeineOn(); ?>'){
                    data= {postType:'codepromo',code_name:codename,pourcentage:pourcentage,expiry_date:date,resto:'epinay-seine',nb:nb};
                }
                
                $.post("../inc/controls.php",data,function(res){
                    if(res.resultat == 'codeNameError'){
                        alert('Le code que vous avez saisi est déja utilisé. Veillez saisir un autre');
                    }else{
                        $('.codepromo #date').val('');
                        $('.codepromo #codename').val('');
                        $('.codepromo #prix').val('');
                        $('.codepromoover').css({display:'none'});
                    }
                },'json');
            }
        });
        $('.reset').on('click',function(e){
            e.preventDefault();
            $('.codepromoover').css({display:'none'});
        });
        $(window).on('load',function(){
            if('<?php echo isSuperAdminOn() ?>'){
                getClientData(0);
                $('.gestion-client').css({display:'block'});
            }
        });
        $('.stfiltre').on('click',function(){
            $('.blocfiltre').css({display:'flex'});
        });
        $('.blocfiltre .send').on('click',function(e){
            let startdate = $('.blocfiltre #startdate').val();
            let enddate = $('.blocfiltre #enddate').val();
            e.preventDefault();
            if(startdate == '' || enddate == ''){
                alert('Rassurer vous que tous les champs sont remplis!');
            }else{
                if(startdate > enddate){
                    alert('La date de depart ne doit pas être supérieur à la date de fin');
                }else{
                    chartArray.forEach(el => el.destroy());
                    getStat('filtre',startdate,enddate);
                    $('.blocfiltre').css({display:'none'});
                }
            }
        });
    });
    function getPromocodeData(){
        $('body').prepend('<div class="load"><div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
        $('.promocode .code-content table tbody tr').remove();
        $('.promocode .code-content .info').remove();
        let data = '';
        if ('<?php echo isRestoAsnieresOn(); ?>') {
            data= {postType:'codepromo',resto:'asnieres'};
        }else if ('<?php echo isRestoArgenteuilOn(); ?>') {
            data= {postType:'codepromo',resto:'argenteuil'};
        }else if('<?php echo isRestoBezonsOn(); ?>'){
            data= {postType:'codepromo',resto:'bezons'};
        }else if ('<?php echo isRestoSaintDenisOn(); ?>') {
            data= {postType:'codepromo',resto:'saint-denis'};
        }else if('<?php echo isRestoEpinaySeineOn(); ?>'){
            data= {postType:'codepromo',resto:'epinay-seine'};
        }
        let table = '';
        $.post("../inc/controls.php",data,function(res){
            setTimeout(() => {
                if(res.resultat){
                    for (let i = 0; i < res.resultat.length; i++) {
                        table+='<tr>';
                        table+='<td>'+(i+1)+'</td>';
                        table+='<td>'+res.resultat[i].code_name+'</td>';
                        table+='<td>'+res.resultat[i].pourcentage+'</td>';
                        table+='<td>'+res.resultat[i].nb+'</td>';
                        table+='<td>'+res.resultat[i].expiry_date+'</td>';
                        table+='<td>'+res.resultat[i].resto+'</td>';
                        table+='<td><a href="?codepromo_id='+res.resultat[i].code_promo_id+'&action=delete" onclick="return confirm(\'Êtes vous certains de vouloir supprimer ce code promo?\')"> <i class="promodelete fas fa-trash-alt"></i></a></td>';
                        table+='</tr>';
                    }
                    
                    $('.promocode .code-content table tbody').prepend(table);
                }else{
                    $('.promocode .code-content').append('<div class="info">Pas de code promo actuellement enregistré!</div>'); 
                }
                $('.load').remove();
            },1500);
        },'json');
    }
    function getStat(filtre,startdate,enddate){
        let dataNb = '';
        let dataPC = '';
        let dataPO = '';
        let dataST = '';
        let dataTT = '';
        let data1 = '';
        let data2 = '';
        let data3 = '';
        let data4 = '';
        let data5 = '';
        if(filtre == ''){
            data1 = {postType:'nbCommande'};
            data2 = {postType:'prixCaisse'};
            data3 = {postType:'onlinePayment'};
            data4 = {postType:'sommetatal'};
            data5 = {postType:'totaux'};
        }else{
            data1 = {postType:'nbCommande',startdate:startdate,enddate:enddate};
            data2 = {postType:'prixCaisse',startdate:startdate,enddate:enddate};
            data3 = {postType:'onlinePayment',startdate:startdate,enddate:enddate};
            data4 = {postType:'sommetatal',startdate:startdate,enddate:enddate};
            data5 = {postType:'totaux',startdate:startdate,enddate:enddate};
        }
        $('body').prepend('<div class="load"><div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
        $('.donnee-statistique .stat-content .item .statitem').remove();
        $('.donnee-statistique .totaux .statitem').remove();
        let date = new Date();
        let aDate = formattedDate(date);
        $.post("../inc/controls.php",data1,function(res){
            let stDataLabel = [];
            let stData = [];
            if(filtre == ''){
                dataNb += '<div class="statitem"><h5 class="mt-5 mb-5">Nombre de commande par restaurant allant jusqu\'au '+aDate+'</h5><ol class="list-group list-group-numbered">';
            }else{
                dataNb += '<div class="statitem"><h5 class="mt-5 mb-5">Nombre de commande par restaurant allant du ' +startdate+' au '+enddate+ '</h5><ol class="list-group list-group-numbered">';
            }
            if(res.resultat){
                for (let i = 0; i < res.resultat.length; i++) {
                    stDataLabel.push(res.resultat[i].resto);
                    stData.push(res.resultat[i].nbCommande);
                    dataNb += '<li class="list-group-item d-flex justify-content-between align-items-start"><div class="ms-2 me-auto"><div class="fw-bold">Restaurant</div>'+res.resultat[i].resto+'</div><span class="badge bg-primary rounded-pill">'+res.resultat[i].nbCommande+'</span>';
                    dataNb += '</li>';
                }
                dataNb += '</ol></div>';
                var canvas = document.querySelector('.donnee-statistique .stat-content .item .stNb').getContext('2d');
                addChart('Nombre de commande par restaurant',stDataLabel,stData,canvas);
                $('.donnee-statistique .stat-content .item .nbcommande').append(dataNb);
            }else{
                dataNb = '<div class="info statitem">Pas commande correspondant à la période du '+startdate+' au '+enddate+'</div>';
                $('.donnee-statistique .stat-content .item .nbcommande').append(dataNb);
            }      
        },'json');
        $.post("../inc/controls.php",data2,function(res){
            let stDataLabel = [];
            let stData = [];
            if(filtre == ''){
                dataPC += '<div class="statitem"><h5 class="mt-5 mb-5">Chiffre d\'affaire pour les paiement en caisse par restaurant allant jusqu\'au '+aDate+'</h5><ol class="list-group list-group-numbered">';
            }else{
                dataPC += '<div class="statitem"><h5 class="mt-5 mb-5">Chiffre d\'affaire pour les paiement en caisse par restaurant allant du ' +startdate+' au '+enddate+ '</h5><ol class="list-group list-group-numbered">';
            }
            if(res.resultat){
                for (let i = 0; i < res.resultat.length; i++) {
                    stDataLabel.push(res.resultat[i].resto);
                    stData.push(res.resultat[i].prix);
                    dataPC += '<li class="list-group-item d-flex justify-content-between align-items-start"><div class="ms-2 me-auto"><div class="fw-bold">Restaurant</div>'+res.resultat[i].resto+'</div><span class="badge bg-primary rounded-pill">'+parseFloat(res.resultat[i].prix).toFixed(2).replace('.',',')+' €</span>';
                    dataPC += '</li>';
                }
                dataPC += '</ol></div>';
                var canvas = document.querySelector('.donnee-statistique .stat-content .item .stPC').getContext('2d');
                addChart('Paiement en caisse par restaurant',stDataLabel,stData,canvas);
                $('.donnee-statistique .stat-content .item .paiementcaisse').append(dataPC);
            }else{
                dataPC = '<div class="info statitem">Pas de paiement en caisse pour la période du '+startdate+' au '+enddate+'</div>';
                $('.donnee-statistique .stat-content .item .paiementcaisse').append(dataPC);
            } 
        },'json');
        $.post("../inc/controls.php",data3,function(res){
            let stDataLabel = [];
            let stData = [];
            if(filtre == ''){
                dataPO += '<div class="statitem"><h5 class="mt-5 mb-5">Chiffre d\'affaire pour les paiement en ligne par restaurant allant jusqu\'au '+aDate+'</h5><ol class="list-group list-group-numbered">';
            }else{
                dataPO += '<div class="statitem"><h5 class="mt-5 mb-5">Chiffre d\'affaire pour les paiement en ligne par restaurant allant du ' +startdate+' au '+enddate+ '</h5><ol class="list-group list-group-numbered">';
            }
            if(res.resultat){
                for (let i = 0; i < res.resultat.length; i++) {
                    stDataLabel.push(res.resultat[i].resto);
                    stData.push(res.resultat[i].prix);
                    dataPO += '<li class="list-group-item d-flex justify-content-between align-items-start"><div class="ms-2 me-auto"><div class="fw-bold">Restaurant</div>'+res.resultat[i].resto+'</div><span class="badge bg-primary rounded-pill">'+parseFloat(res.resultat[i].prix).toFixed(2).replace('.',',')+' €</span>';
                    dataPO += '</li>';
                }
                dataPO += '</ol></div>';
                var canvas = document.querySelector('.donnee-statistique .stat-content .item .stPO').getContext('2d');
                addChart('Paiement en ligne par restaurant',stDataLabel,stData,canvas);
                $('.donnee-statistique .stat-content .item .paiementoline').append(dataPO);
            }else{
                dataPO = '<div class="info statitem">Pas de paiement en ligne pour la période du '+startdate+' au '+enddate+'</div>';
                $('.donnee-statistique .stat-content .item .paiementoline').append(dataPO);
            } 
        },'json');
        $.post("../inc/controls.php",data4,function(res){
            let stDataLabel = [];
            let stData = [];
            if(filtre == ''){
                dataST += '<div class="statitem"><h5 class="mt-5 mb-5">Chiffre d\'affaire pour les ventes enregistrées par restaurant allant jusqu\'au '+aDate+'</h5><ol class="list-group list-group-numbered">';
            }else{
                dataST += '<div class="statitem"><h5 class="mt-5 mb-5">Chiffre d\'affaire pour les ventes enregistrées par restaurant allant du ' +startdate+' au '+enddate+ '</h5><ol class="list-group list-group-numbered">';
            }
            if(res.resultat){
                for (let i = 0; i < res.resultat.length; i++) {
                    stDataLabel.push(res.resultat[i].resto);
                    stData.push(res.resultat[i].prix);
                    dataST += '<li class="list-group-item d-flex justify-content-between align-items-start"><div class="ms-2 me-auto"><div class="fw-bold">Restaurant</div>'+res.resultat[i].resto+'</div><span class="badge bg-primary rounded-pill">'+parseFloat(res.resultat[i].prix).toFixed(2).replace('.',',')+' €</span>';
                    dataST += '</li>';
                }
                dataST += '</ol></div>';
                var canvas = document.querySelector('.donnee-statistique .stat-content .item .stST').getContext('2d');
                addChart('Ventes enregistrées par restaurant',stDataLabel,stData,canvas);
                $('.donnee-statistique .stat-content .item .sommetotal').append(dataST);
            }else{
                dataST = '<div class="info statitem">Pas de vente pour la période du '+startdate+' au '+enddate+'</div>';
                $('.donnee-statistique .stat-content .item .sommetotal').append(dataST);
            }
        },'json');
        $.post("../inc/controls.php",data5,function(res){
            if(filtre == ''){
                dataTT += '<div class="statitem"><h5 class="mt-5 mb-5">Chiffre d\'affaire réalisé allant jusqu\'au '+aDate+'</h5>';
            }else{
                dataTT += '<div class="statitem"><h5 class="mt-5 mb-5">Chiffre d\'affaire réalisé allant du ' +startdate+' au '+enddate+ '</h5>';
            }
            if(res.resultat){
                for (let i = 0; i < res.resultat.length; i++) {
                    if(res.resultat[i].prix != '' && res.resultat[i].prix != undefined && res.resultat[i].prix > 0){
                        dataTT += '<p class="tt">'+parseFloat(res.resultat[i].prix).toFixed(2).replace('.',',')+' €</p>';
                    }else{
                        dataTT += '<p class="tt">0 €</p>';
                    }
                }
                dataTT += '</div>';
                setTimeout(() => {
                    $('.donnee-statistique .totaux').append(dataTT);
                    $('.load').remove();
                },1500);
            }else{
                dataTT = '<div class="info statitem">Pas de chiffre d\'affaire réalisé pour la période du '+startdate+' au '+enddate+'</div>';
                setTimeout(() => {
                    $('.donnee-statistique .totaux').append(dataTT);
                    $('.load').remove();
                },1500);
            }
        },'json');
    }
    function formattedDate(d) {
      return [d.getDate(), d.getMonth()+1, d.getFullYear()]
          .map(n => n < 10 ? `0${n}` : `${n}`).join('/');
    }
    function getClientData($limit){
        $('body').prepend('<div class="load"><div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
        let table = '';
        $('.commandehistorique table tbody tr').each(function(){
            rowIndex++;
        });
        $('.moreClientData').remove();
        $.post("../inc/controls.php",{postType:'clientData',limit:$limit},function(res){
            setTimeout(() => {
                if(res.resultat){
                    for (let i = 0; i < res.resultat.length; i++) {
                        rowIndex++;
                        table += '<tr>';
                        table += '<td>'+(rowIndex)+'</td>';
                        table += '<td>'+res.resultat[i].nom+'</td>';
                        table += '<td>'+res.resultat[i].email+'</td>';
                        table += '<td>'+res.resultat[i].tel+'</td>';
                        table += '<td>'+res.resultat[i].statut+'</td>';
                        if(res.resultat[i].verify == 0 && (res.resultat[i].user_google_id != null || res.resultat[i].user_facebook_id != null)){
                            table += '<td>Oui</td>';
                        }else if(res.resultat[i].verify == 1){
                            table += '<td>Oui</td>';
                        }else if(res.resultat[i].verify == 0 && (res.resultat[i].user_google_id == null || res.resultat[i].user_facebook_id == null)){
                            table += '<td>Non</td>';
                        }
                        //table += '<td>'+res.resultat[i].verify+'</td>';
                        table += '<td>'+res.resultat[i].nbCommande+'</td>';
                        table += '<td>'+res.resultat[i].date_enregistrement+'</td>';
                        table += '</tr>';
                    }
                    $('.gestion-client table tbody').append(table);
                    $('.gestion-client').append('<button class="btn btn-primary moreClientData">Avoir plus de client</button>');
                }else{
                    $('.gestion-client').append('<p class="info">Vous avez atteind le nombre maximal de client stocker dans la base de donnée</p>');
                    $('.moreClientData').remove();
                }
                $('.load').remove();
            },2000);
        },'json');
    }
    function getCommandeHistoryData(resto,limit){
        $('body').prepend('<div class="load"><div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
        let table = '';
        let rowIndex = 0;
        $('.commandehistorique table tbody tr').each(function(){
            rowIndex++;
        });
        $.post("../inc/controls.php",{postType:'historyData',resto:resto,limit:limit},function(res){
            setTimeout(() => {
                if(res.resultat){
                    let commandeList = '';
            
                        for (let i = 0; i < res.resultat.length; i++) {
                            table += '<tr>';
                            const element = res.resultat[i];
                            
                            if (element.commande_detail.includes('|')) {
                                let commande = element.commande_detail.split('|');
                                commandeList += '<ol>';
                                for (let j = 0; j < commande.length; j++) {
                                    const ele = commande[j];
                                    if (ele != '') {
                                        const el = ele.split("::");
                                        commandeList += '<li> Choix';
                                        commandeList += '<ul>';
                                        commandeList += '<li>'+el[1]+' x '+el[2]+'</li>';
                                        commandeList += '</ul>';
                                        commandeList += '</li>';
                                    }
                                    //console.log(ele);
                                }
                                commandeList += '</ol>';
                            }else{
                                let commande = element.commande_detail.split('::');
                                commandeList += '<ol>';
                                commandeList += '<li> Choix';
                                commandeList += '<ul>';
                                commandeList += '<li>'+commande[1]+' x '+commande[2]+'</li>';
                                commandeList += '</ul>';
                                commandeList += '</li>';
                                commandeList += '</ol>';
                                //console.log(commandeList);
                            }
                            rowIndex++;
                            table += '<td>'+(rowIndex)+'</td>';
                            table += '<td>'+element.nom+'</td>';
                            table += '<td>'+element.reference_commande+'</td>';
                            table += '<td> Commande'+commandeList+'</td>';
                            table += '<td>'+element.prix+' €</td>';
                            if (element.commande_statut == 'reçu') {
                                table +='<td style="position:relative;">'+element.commande_statut+'<span class ="recu"></span></td>';
                            }else if(element.commande_statut == 'en-préparation'){
                                table +='<td style="position:relative;">'+element.commande_statut+'<span class ="preparation"></span></td>';
                            }else if(element.commande_statut == 'fini'){
                                table +='<td style="position:relative;">'+element.commande_statut+'<span class ="fini"></span></td>';
                            }else{
                                table +='<td style="position:relative;">'+element.commande_statut+'<span class ="livre"></span></td>';
                            }
                            table += '<td>'+element.commande_date+'</td>';
                            table += '</tr>';
                            commandeList = '';
                        }
                        $('.commandehistorique table tbody').append(table);
                        $('.commandehistorique').append('<button class="btn btn-primary moreData">Avoir plus de resultat</button>');
                }else{
                    $('.commandehistorique').append('<p class="info">Il n\'y a plus de commande dans la base de donnée</p>');
                }
                $('.load').remove();
            },2000);
            
        },'json');
    }
    function getCommandeData(resto,postType,setting){
        var count = 0;
        $.post("../inc/controls.php",{postType:postType,resto:resto},function(res){
            if (res.resultat) {
                //console.log(res.resultat);
                let commandeData;
                let commandeListe ='';
                for (let index = 0; index < res.resultat.length; index++) {
                    const element = res.resultat[index];
                    if (element.commande_detail.includes('|')) {
                        let commande = element.commande_detail.split('|');
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
                            commandeListe += '<li>Sauce : '+el[6]+'</li>';
                            commandeListe += '<li>Autre demande : '+el[7]+'</li>';
                            commandeListe += '</ul>';
                            commandeListe += '</li>';
                        }
                        commandeListe += '</ol>';
                    } else {
                        const el = element.commande_detail.split('::');
                        commandeListe += '<ol>';
                        commandeListe += '<li>Choix';
                        commandeListe += '<ul>';
                        commandeListe += '<li>'+el[1]+' x '+el[2]+'</li>';
                        commandeListe += '<li>Type de produit : '+el[3]+'</li>';
                        commandeListe += '<li>Livraison : '+el[4]+'</li>';
                        commandeListe += '<li>Boisson : '+el[5]+'</li>';
                        commandeListe += '<li>Sauce : '+el[6]+'</li>';
                        commandeListe += '<li>Autre demande : '+el[7]+'</li>';
                        commandeListe += '</ul>';
                        commandeListe += '</li>';
                        commandeListe += '</ol>';
                    }
                    
                    commandeData +='<tr>';
                    commandeData +='<input type="hidden" value="'+element.commande_code+'">';
                    commandeData +='<td>'+(index+1)+'</td>';
                    commandeData +='<td>'+element.nom+'</td>';
                    commandeData +='<td>'+element.commande_code+'</td>';
                    commandeData +='<td style="font-weight:700;">'+element.reference_commande+'</td>';
                    commandeData +='<td>Commande'+commandeListe+'</td>';
                    commandeData +='<td style="font-weight:700;">'+element.prix+' €</td>';
                    if (element.reference_id == 'PAIEMENT EN CAISSE') {
                        commandeData +='<td style="color: darkred; font-weight:700;">'+element.reference_id+'</td>';
                    } else {
                        commandeData +='<td style="color: rgb(14, 107, 49); font-weight:700;">PAIEMENT EFFECTUE EN LIGNE</td>';
                    }
                    if (element.commande_statut == 'reçu') {
                        count++;
                        commandeData +='<td style="position:relative;">'+element.commande_statut+' <span class ="recu"></span></td>';
                    }else if(element.commande_statut == 'en-préparation'){
                        commandeData +='<td style="position:relative;">'+element.commande_statut+' <span class ="preparation"></span></td>';
                    }else if(element.commande_statut == 'fini'){
                        commandeData +='<td style="position:relative;">'+element.commande_statut+' <span class ="fini"></span></td>';
                    }else{
                        commandeData +='<td style="position:relative;>'+element.commande_statut+' <span class ="livre"></span></td>';
                    }
                    
                    commandeData +='<td>'+element.commande_date+'</td>';
                    if (element.commande_statut == 'reçu') {
                        commandeData +='<td>Lancer la préparation<br> de la commande<button class="btn btn-primary modifyStatut">Débuter la préparation</button></td>';
                    } else if (element.commande_statut == 'en-préparation') {
                        commandeData +='<td>Terminer la préparation<br> de la commande<button class="btn btn-primary finprepa">Terminer la préparation</button></td>';
                    }else if (element.commande_statut == 'fini') {
                        commandeData +='<td>Définir la commande<br> comme livré<button class="btn btn-primary plivre">Marquer comme livré</button></td>';
                    }
                    
                    commandeData +='</tr>';
                    commandeListe = '';

                }
                $('.commandelist table tbody tr').remove();
                $('.commandelist table tbody').append(commandeData);
                $('.commandelist .nbcommande span').text(count);
                if(count > 0 && setting == ""){
                    $("body .audio audio").remove();
                    $('.commandelist .nbcommande span').addClass('anima');
                    $("<audio></audio>").attr({ 
                		'src':'/audio/alert-commande.mp3', 
                		'volume':0.4,
                		'autoplay':'autoplay'
                	}).appendTo("body .audio");
                	$("body .audio audio").on('ended',function(event){
                	    $('.commandelist .nbcommande span').removeClass('anima');
                	});
                }else{
                    $('body').prepend('<div class="load"><div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
                    setTimeout(() => {
                         $('.load').remove();
                    },2000);
                }
            }else{
                if(count > 0){
                    $("body .audio audio").remove();
                    $('.commandelist .nbcommande span').addClass('anima');
                    $("<audio></audio>").attr({ 
                		'src':'/audio/alert-commande.mp3', 
                		'volume':0.4,
                		'autoplay':'autoplay'
                	}).appendTo("body .audio");
                	$("body .audio audio").on('ended',function(event){
                	    $('.commandelist .nbcommande span').removeClass('anima');
                	});
                }
            }
        },'json');

    }
    function addChart(title,labelData,dataset,domEl){
        Chart.defaults.font.size = 30;
        Chart.defaults.font.family = "'Cormorant', serif";
        Chart.defaults.font.weight = 700;
        var myChart = new Chart(domEl, {
            type: 'line',
            data: {
                labels: labelData,
                datasets: [{
                    label: title,
                    data: dataset,
                    backgroundColor: [
                        'rgba(255, 169, 30, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 159, 64, 0.6)'
                    ],
                    borderColor: [
                        'rgba(255, 169, 30, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    title: {
                        font: {
                            size: 28,
                            family:"'Cormorant', serif",
                            weight: 700
                        }
                    }
                }
            }
        });
        chartArray.push(myChart);
    }
</script>
<?php
    require_once '../inc/footer.php';