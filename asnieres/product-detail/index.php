<?php
    require_once '../../inc/init.php';

    $title = 'Detaille du produit';

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
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2621.458064098861!2d2.27889911596863!3d48.92571657929418!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e665f7b5db720f%3A0x201404fbe68ad490!2s104%20Rue%20Emile%20Zola%2C%2092600%20Asni%C3%A8res-sur-Seine!5e0!3m2!1sfr!2sfr!4v1624369359799!5m2!1sfr!2sfr" width="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
    <div class="detail">
        <div class="product-img">
            <img src="<?php echo RACINE_SITE.$product['product_img_url'] ?>" alt="<?php echo $product['product_name'] ?>">
        </div>
        <div class="localisation">
            <div class="detail-content">
                <input type="hidden" name="" class="product-id" value="<?php echo $product['product_id']; ?>">
                <input type="hidden" name="" class="product-type" value="<?php echo $product['produit_type']; ?>">
                <h2 class="product-name"><?php echo $product['product_name'] ?></h2>
                <p><?php echo $product['product_description'] ?></p>
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
                        <option value="À emporter">À emporter</option>
                        <option value="Sur place">Sur place</option>
                        <option value="En livraison">En livraison</option>
                    </select>
                </div>
                <?php 
                    if ($product['produit_type'] != 'boisson') {
                        ?>
                        <div class="mb-3">
                            <label for="precision" class="form-label">Précision sur la commande</label>
                            <select name="precision" id="precision" class="form-select precision">
                                <option value="normal">Normal</option>
                                <option value="Pas de sel">Pas de sel</option>
                                <option value="Sonnette en panne">Sonnette en panne</option>
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
                                <option value="fanta">Fanta</option>
                                <option value="cola">Cola</option>
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
                                    <option value="sirob1">Sirob1</option>
                                    <option value="sirob2">Sirob2</option>
                                    <option value="sirob3">Sirob3</option>
                                </select>
                            </div>
                            <?php
                        }elseif (str_contains($product['product_name'],'Canette')) {
                            ?>
                            <div class="mb-3">
                                <label for="choose-canette" class="form-label">Choisir une canette</label>
                                <select name="choose-canette" id="choose-canette" class="form-select choose-boisson">
                                    <option value="canette-fanta">Canette fanta</option>
                                    <option value="canette-cola">Canette cola</option>
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
                if ($product['stock'] == 0) {
                    echo '<div class="error">Le produit est en rupture de stock</div>';
                }else {
                    ?>
                    <div class="mb-3">
                        <label for="quantite" class="form-label">Quantité</label>
                        <input type="number" class="form-control quantite" id="quantite" min="1" max="<?php echo $product['stock'] ?>" placeholder="Définir une quantité">
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
        <h3>Nous vous suggerons aussi</h3>
        <div class="suggestion">
            <?php 
                if ($product['']) {
                    # code...
                }
            ?>
        </div>
    </div>
</div>

<script>
    $(function(){
        let URL = 'http://localhost/chicken-grill/';
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
                        $('.localisation').append('<div class="success">Le produit a été inséré dans le panier <a href="'+URL+'cart">Accéder au panier</a></div>');
                    }
                },'json');
            }
        });
    });
</script>

<?php
    require_once '../../inc/footer.php';