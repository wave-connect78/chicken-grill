<?php
    require_once '../../inc/init.php';

    $title = 'Detaille du produit';
    $email = 'chickengrill.argenteuil95@gmail.com';
    $tel = '07 65 45 88 89';
    require_once '../../inc/header.php';

    if (isset($_GET) && !empty($_GET)) {
        $resultat = executeQuery("SELECT * FROM product WHERE product_id = :product_id",array(
            ':product_id' => $_GET['access']
        ));
        $product = $resultat->fetch(PDO::FETCH_ASSOC);
        print_r($product);
    }



?>
<div class="product-detail">
    <div class="map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2620.699014400152!2d2.223922615969044!3d48.94017437929561!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e6669d6a0e16f9%3A0x150fda0abd7d58ee!2s149%20Avenue%20Jean%20Jaur%C3%A8s%2C%2095100%20Argenteuil!5e0!3m2!1sfr!2sfr!4v1625498889869!5m2!1sfr!2sfr"  style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
    <div class="detail">
        <div class="product-img">
            <img src="<?php echo RACINE_SITE.$product['product_img_url'] ?>" alt="<?php echo $product['product_name'] ?>">
        </div>
        <div class="localisation">
            <div class="detail-content">
                <input type="hidden" name="" class="product-id" value="<?php echo $product['product_id']; ?>">
                <input type="hidden" name="" class="product-type" value="<?php echo $product['produit_type']; ?>">
                <h2 class="product-name mb-4"><?php echo $product['product_name'] ?></h2>
                <p class="mb-3"><?php echo $product['product_description'] ?></p>
                <p class="prix">Prix : <span><?php 
                    if ($product['prix_promo'] != 0) {
                        echo $product['prix_promo'];
                    } else {
                        echo $product['prix'];
                    }
                    
                ?></span> €</p>
                <div class="mb-3">
                    <label for="commande-mode" class="form-label">Mode de commande</label>
                    <select name="commande-mode" id="commande-mode" class="form-select commande-mode">
                        <?php 
                        if (isset($_SESSION['cart'])) {
                            if ($_SESSION['cart'][0]['commande_mode'] == 'Sur place') {
                                ?>
                                <option value="Sur place">Sur place</option>
                                <?php
                            }elseif($_SESSION['cart'][0]['commande_mode'] == 'À emporter'){
                                ?>
                                <option value="À emporter">À emporter</option>
                                <?php
                            }else {
                                ?>
                                <option value="À emporter">À emporter</option>
                                <option value="Sur place">Sur place</option>
                                <?php
                            }
                        }else {
                            ?>
                            <option value="À emporter">À emporter</option>
                            <option value="Sur place">Sur place</option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <?php 
                    if ($product['produit_type'] != 'boisson') {
                        ?>
                        <div class="mb-3">
                            <label for="precision" class="form-label">Quelle sauce souhaitez vous</label>
                            <select name="precision" id="precision" class="form-select precision">
                                <option value="pas de sauce">Pas de sauce</option>
                                <option value="Ketchup">Ketchup</option>
                                <option value="Mayonnaise">Mayonnaise</option>
                                <option value="Moutarde">Moutarde</option>
                                <option value="Algérienne">Algérienne</option>
                                <option value="Biggie">Biggie</option>
                                <option value="Barbecue">Barbecue</option>
                                <option value="Fish">Fish</option>
                                <option value="Samouraï">Samouraï</option>
                                <option value="Blanche">Blanche</option>
                                <option value="Poivre">Poivre</option>
                                <option value="Andalouse">Andalouse</option>
                                <option value="Cheezy">Cheezy</option>
                            </select>
                        </div>
                        <?php
                    }
                ?>
                <?php 
                    if ($product['produit_type'] == 'menu' || $product['produit_type'] == 'menu-simple' || $product['produit_type'] == 'menu-doublé') {
                        ?>
                        <div class="mb-3">
                            <label for="choose-boisson" class="form-label">Choisir une boisson</label>
                            <select name="choose-boisson" id="choose-boisson" class="form-select choose-boisson">
                                <option value="Coca">Coca</option>
                                <option value="Coca-cherry">Coca cherry</option>
                                <option value="orangina ">Orangina</option>
                                <option value="schweppes-agrumes">Schweppes agrumes</option>
                                <option value="ici-tea">Ici tea</option>
                                <option value="oasis-tropical">Oasis tropical</option>
                            </select>
                        </div>
                        <?php
                    }
                    if( $product['produit_type'] == 'boisson'){
                        if (str_contains($product['product_name'],'sirop')) {
                            ?>
                            <div class="mb-3">
                                <label for="choose-sirob" class="form-label">Choisir un Sirop</label>
                                <select name="choose-sirob" id="choose-sirob" class="form-select choose-boisson">
                                    <option value="Grenadine">Grenadine</option>
                                    <option value="Melon">Melon</option>
                                    <option value="Pêche">Pêche</option>
                                    <option value="Kiwi">Kiwi</option>
                                    <option value="Menthe">Menthe</option>
                                    <option value="Citron">Citron</option>
                                    <option value="Banane">Banane</option>
                                </select>
                            </div>
                            <?php
                        }elseif (str_contains($product['product_name'],'Canette')) {
                            ?>
                            <div class="mb-3">
                                <label for="choose-canette" class="form-label">Choisir une canette</label>
                                <select name="choose-canette" id="choose-canette" class="form-select choose-boisson">
                                    <option value="Coca">Coca</option>
                                    <option value="Coca-cherry">Coca cherry</option>
                                    <option value="orangina ">Orangina</option>
                                    <option value="schweppes-agrumes">Schweppes agrumes</option>
                                    <option value="ici-tea">Ici tea</option>
                                    <option value="oasis-tropical">Oasis tropical</option>
                                </select>
                            </div>
                            <?php
                        }elseif (str_contains($product['product_name'],'Bouteille')) {
                            ?>
                            <div class="mb-3">
                                <label for="choose-bouteille" class="form-label">Choisir une bouteille</label>
                                <select name="choose-bouteille" id="choose-bouteille" class="form-select choose-boisson">
                                    <option value="bouteille-fanta">Bouteille fanta</option>
                                    <option value="bouteille-cola">Bouteille cola</option>
                                </select>
                            </div>
                            <?php
                        }
                    }
                ?>
                <?php 
                if ($product['stock_statut'] == 'rupture') {
                    echo '<div class="error">Le produit est en rupture de stock</div>';
                }else {
                    ?>
                    <div class="mb-3">
                        <label for="quantite" class="form-label">Quantité</label>
                        <input type="number" class="form-control quantite" id="quantite" min="1" placeholder="Définir une quantité">
                    </div>
                    <?php
                }
                ?>
                <div class="mb-3">
                    <label for="envis" class="form-label" placeholder="Laissez un messgae">Avez vous des envis particulieres</label>
                    <textarea name="envis" id="envis" class="form-control envis"></textarea>
                </div>
            </div>
            <div class="add-to-cart">Ajouter au panier</div>
        </div>
    </div>
    <div class="produit-suggere">
        <h3 class="mb-5 mt-5">Nous vous suggerons aussi</h3>
        <div class="suggestion">
            <?php 
                if ($product['produit_type'] == 'aucun') {
                    ?>
                    <h5 class="mb-4">Choisir aussi une boisson</h5>
                    <?php
                    $result = executeQuery("SELECT * FROM product WHERE produit_type = :produit_type LIMIT 5",array(
                        ':produit_type' => 'boisson'
                    ));
                    ?>
                    <div class="card-content">
                    <?php
                    while ($boisson = $result->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <div class="card"><?php if($boisson['promo'] == 'en-promo') echo '<span>promo</span>' ?><img src="<?php echo RACINE_SITE. $boisson['product_img_url'] ?>" class="card-img-top" alt="<?php echo $boisson['product_name'] ?>'"><div class="card-body"><h5 class="card-title"><?php echo $boisson['product_name'] ?></h5><div class="card-text"><?php if($boisson['prix_promo'] > 0) {echo '<p><s>'.$boisson['prix'].'€</s></p>'; echo '<p>'.$boisson['prix_promo']. '€</p>';} else {echo '<p>'.$boisson['prix'].'€</p>';}?><p></div><a href="?access=<?php echo $boisson['product_id'] ?>" class="btn btn-primary">Choisir egalement</a></div></div>
                        <?php
                    }
                    ?>
                    </div>
                    <?php
                }elseif ($product['produit_type'] == 'boisson') {
                    ?>
                    <h5 class="mb-4">Choisir aussi un produit</h5>
                    <?php
                    $result = executeQuery("SELECT * FROM product WHERE produit_type = :produit_type LIMIT 5",array(
                        ':produit_type' => 'aucun'
                    ));
                    ?>
                    <div class="card-content">
                    <?php
                    while ($boisson = $result->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <div class="card"><?php if($boisson['promo'] == 'en-promo') echo '<span>promo</span>' ?><img src="<?php echo RACINE_SITE. $boisson['product_img_url'] ?>" class="card-img-top" alt="<?php echo $boisson['product_name'] ?>'"><div class="card-body"><h5 class="card-title"><?php echo $boisson['product_name'] ?></h5><div class="card-text"><?php if($boisson['prix_promo'] > 0) {echo '<p><s>'.$boisson['prix'].'€</s></p>'; echo '<p>'.$boisson['prix_promo']. '€</p>';} else {echo '<p>'.$boisson['prix'].'€</p>';}?><p></div><a href="?access=<?php echo $boisson['product_id'] ?>" class="btn btn-primary">Choisir egalement</a></div></div>
                        <?php
                    }
                    ?>
                    </div>
                    <?php
                }elseif ($product['produit_type'] == 'menu') {
                    ?>
                    <h5 class="mb-4">Choisir aussi un complément</h5>
                    <?php
                    $result = executeQuery("SELECT * FROM product WHERE produit_type = :produit_type LIMIT 5",array(
                        ':produit_type' => 'menu-simple'
                    ));
                    ?>
                    <div class="card-content">
                    <?php
                    while ($boisson = $result->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <div class="card"><?php if($boisson['promo'] == 'en-promo') echo '<span>promo</span>' ?><img src="<?php echo RACINE_SITE. $boisson['product_img_url'] ?>" class="card-img-top" alt="<?php echo $boisson['product_name'] ?>'"><div class="card-body"><h5 class="card-title"><?php echo $boisson['product_name'] ?></h5><div class="card-text"><?php if($boisson['prix_promo'] > 0) {echo '<p><s>'.$boisson['prix'].'€</s></p>'; echo '<p>'.$boisson['prix_promo']. '€</p>';} else {echo '<p>'.$boisson['prix'].'€</p>';}?><p></div><a href="?access=<?php echo $boisson['product_id'] ?>" class="btn btn-primary">Choisir egalement</a></div></div>
                        <?php
                    }
                    ?>
                    </div>
                    <?php
                }elseif ($product['produit_type'] == 'menu-doublé') {
                    ?>
                    <h5 class="mb-4">Choisir aussi un complément</h5>
                    <?php
                    $result = executeQuery("SELECT * FROM product WHERE produit_type = :produit_type LIMIT 5",array(
                        ':produit_type' => 'menu-simple'
                    ));
                    ?>
                    <div class="card-content">
                    <?php
                    while ($boisson = $result->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <div class="card"><?php if($boisson['promo'] == 'en-promo') echo '<span>promo</span>' ?><img src="<?php echo RACINE_SITE. $boisson['product_img_url'] ?>" class="card-img-top" alt="<?php echo $boisson['product_name'] ?>'"><div class="card-body"><h5 class="card-title"><?php echo $boisson['product_name'] ?></h5><div class="card-text"><?php if($boisson['prix_promo'] > 0) {echo '<p><s>'.$boisson['prix'].'€</s></p>'; echo '<p>'.$boisson['prix_promo']. '€</p>';} else {echo '<p>'.$boisson['prix'].'€</p>';}?><p></div><a href="?access=<?php echo $boisson['product_id'] ?>" class="btn btn-primary">Choisir egalement</a></div></div>
                        <?php
                    }
                    ?>
                    </div>
                    <?php
                }elseif ($product['produit_type'] == 'menu-simple') {
                    ?>
                    <h5 class="mb-4">Choisir aussi un complément</h5>
                    <?php
                    $result = executeQuery("SELECT * FROM product WHERE produit_type = :produit_type LIMIT 5",array(
                        ':produit_type' => 'menu'
                    ));
                    ?>
                    <div class="card-content">
                    <?php
                    while ($boisson = $result->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <div class="card"><?php if($boisson['promo'] == 'en-promo') echo '<span>promo</span>' ?><img src="<?php echo RACINE_SITE. $boisson['product_img_url'] ?>" class="card-img-top" alt="<?php echo $boisson['product_name'] ?>'"><div class="card-body"><h5 class="card-title"><?php echo $boisson['product_name'] ?></h5><div class="card-text"><?php if($boisson['prix_promo'] > 0) {echo '<p><s>'.$boisson['prix'].'€</s></p>'; echo '<p>'.$boisson['prix_promo']. '€</p>';} else {echo '<p>'.$boisson['prix'].'€</p>';}?><p></div><a href="?access=<?php echo $boisson['product_id'] ?>" class="btn btn-primary">Choisir egalement</a></div></div>
                        <?php
                    }
                    ?>
                    </div>
                    <?php
                }
            ?>
            <div class="dessert">
                <h5 class="mb-4">Nous vous proposons aussi ces desserts</h5>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        let URL = 'http://localhost/chicken-grill/'+'<?php echo $_SESSION['actuelPage']['nom_resto'] ?>';
        $('.add-to-cart').on('click',function(){
            $('.error').remove();
            $('.success').remove();
            let commandeMode = $('.detail-content .commande-mode option').filter(':selected').val();
            let precision = $('.detail-content .precision option').filter(':selected').val();
            let chooseBoisson = $('.detail-content .choose-boisson option').filter(':selected').val();
            let message = $('.detail-content .envis').val();
            let product_type = $('.detail-content .product-type').val();
            let product_name = $('.detail-content .product-name').text();
            let prix = $('.detail-content .prix span').text();
            let product_id = $('.detail-content .product-id').val();
            let quantite = $('.detail-content .quantite').val();
            let data = {postType:'cart',product_id:product_id,product_name:product_name,prix:prix,product_type:product_type,commande_mode:commandeMode,precision:precision,boisson:chooseBoisson,message:message,quantite:quantite};
            console.log(data);
            if (quantite == undefined) {
                $('.localisation').append('<div class="error">Stock en rupture</div>');
            } else if(quantite == ''){
                $('.localisation').append('<div class="error">Veuillez définir une quantité</div>');
            }else{
                $.post('../../inc/controls.php',data,function(res){
                //console.log(res);
                    if (res.resultat) {
                        $('.cart div').text(res.resultat);
                        $('.localisation').append('<div class="success">Le produit a été inséré dans le panier <a href="'+URL+'/cart">Accéder au panier</a></div>');
                    }
                },'json');
            }
        });
    });
</script>

<?php
    require_once '../../inc/footer.php';