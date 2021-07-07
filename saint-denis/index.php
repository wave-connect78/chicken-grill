<?php
    require_once '../inc/init.php';



    $title = 'Accueil asniers';
    $email = 'chickengrillsaintdenis@gmail.com';
    $tel = '07 65 45 88 89';
    $_SESSION['actuelPage']['nom_resto'] = 'saint-denis';
    $_SESSION['actuelPage']['adresse'] = '67 rue Gabriel Péri 93200 Saint Denis';
    require_once '../inc/header.php';


?>
<div class="asnieres">
    <div class="carousel">
        <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="10000">
                <img src="../assets/about-us.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>First slide label</h5>
                    <p>Some representative placeholder content for the first slide.</p>
                </div>
                </div>
                <div class="carousel-item" data-bs-interval="2000">
                <img src="../assets/about-us.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Second slide label</h5>
                    <p>Some representative placeholder content for the second slide.</p>
                </div>
                </div>
                <div class="carousel-item">
                <img src="../assets/about-us.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Third slide label</h5>
                    <p>Some representative placeholder content for the third slide.</p>
                </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <div class="product-list">
        <div class="single-product">
            <h3>Produits</h3>
            <div class="single-product-content"></div>
        </div>
        <div class="menu">
            <h3>Menu disponible</h3>
            <div class="menu-content"></div>
        </div>
        <div class="menu-simple">
            <h3>Menu simple</h3>
            <div class="menu-simple-content"></div>
        </div>
        <div class="menu-double">
            <h3>Menu doublé</h3>
            <div class="menu-double-content"></div>
        </div>
        <div class="boisson">
            <h3>Boisson</h3>
            <div class="boisson-content"></div>
        </div>
    </div>
</div>

<script>
    $(function(){
        let URL = 'http://localhost/chicken-grill/';
        $(window).on('load',function(){
            $('body').prepend('<div class="load"><div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
            $.post('../inc/controls.php',{postType:'homeData'},function(res){
                if (res.resultat) {
                    setTimeout(() => {
                        res.resultat.forEach(element => {
                            if (element.produit_type == 'aucun') {
                                if (element.prix_promo != 0) {
                                    $('.single-product-content').prepend('<div class="card"><span>promo</span><img src="'+URL+element.product_img_url+'" class="card-img-top" alt="'+element.product_name+'"><div class="card-body"><h5 class="card-title">'+element.product_name+'</h5><div class="card-text"><p><s>'+element.prix+' €</s></p><p>'+element.prix_promo+' €</p></div><a href="product-detail/?access='+element.product_id+'" class="btn btn-primary">Découvrir le produit</a></div></div>');
                                } else {
                                    $('.single-product-content').prepend('<div class="card"><img src="'+URL+element.product_img_url+'" class="card-img-top" alt="'+element.product_name+'"><div class="card-body"><h5 class="card-title">'+element.product_name+'</h5><div class="card-text"><p>'+element.prix+' €<p></div><a href="product-detail/?access='+element.product_id+'" class="btn btn-primary">Découvrir le produit</a></div></div>');
                                }
                            }
                            if (element.produit_type == "menu") {
                                if (element.prix_promo > 0) {
                                    $('.menu-content').prepend('<div class="card"><span>promo</span><img src="'+URL+element.product_img_url+'" class="card-img-top" alt="'+element.product_name+'"><div class="card-body"><h5 class="card-title">'+element.product_name+'</h5><div class="card-text"><p><s>'+element.prix+' €</s></p><p>'+element.prix_promo+' €</p></div><a href="product-detail/?access='+element.product_id+'" class="btn btn-primary">Decouvrir le menu</a></div></div>');
                                } else {
                                    $('.menu-content').prepend('<div class="card"><img src="'+URL+element.product_img_url+'" class="card-img-top" alt="'+element.product_name+'"><div class="card-body"><h5 class="card-title">'+element.product_name+'</h5><div class="card-text"><p>'+element.prix+' €</p></div><a href="product-detail/?access='+element.product_id+'" class="btn btn-primary">Decouvrir le menu</a></div></div>');
                                }
                            }
                            if (element.produit_type == "menu-simple") {
                                if (element.prix_promo != 0) {
                                    $('.menu-simple-content').prepend('<div class="card"><span>promo</span><img src="'+URL+element.product_img_url+'" class="card-img-top" alt="'+element.product_name+'"><div class="card-body"><h5 class="card-title">'+element.product_name+'</h5><div class="card-text"><p><s>'+element.prix+' €</s></p><p>'+element.prix_promo+' €</p></div><a href="product-detail/?access='+element.product_id+'" class="btn btn-primary">Decouvrir le menu</a></div></div>');
                                } else {
                                    $('.menu-simple-content').prepend('<div class="card"><img src="'+URL+element.product_img_url+'" class="card-img-top" alt="'+element.product_name+'"><div class="card-body"><h5 class="card-title">'+element.product_name+'</h5><div class="card-text"><p>'+element.prix+' €</p></div><a href="product-detail/?access='+element.product_id+'" class="btn btn-primary">Decouvrir le menu</a></div></div>');
                                }
                            }
                            if (element.produit_type == "menu-doublé") {
                                if (element.prix_promo != 0) {
                                    $('.menu-double-content').prepend('<div class="card"><span>promo</span><img src="'+URL+element.product_img_url+'" class="card-img-top" alt="'+element.product_name+'"><div class="card-body"><h5 class="card-title">'+element.product_name+'</h5><div class="card-text"><p><s>'+element.prix+' €</s></p><p>'+element.prix_promo+' €</p></div><a href="product-detail/?access='+element.product_id+'" class="btn btn-primary">Decouvrir le menu</a></div></div>');
                                } else {
                                    $('.menu-double-content').prepend('<div class="card"><img src="'+URL+element.product_img_url+'" class="card-img-top" alt="'+element.product_name+'"><div class="card-body"><h5 class="card-title">'+element.product_name+'</h5><div class="card-text"><p>'+element.prix+' €</p></div><a href="product-detail/?access='+element.product_id+'" class="btn btn-primary">Decouvrir le menu</a></div></div>');
                                }
                            }
                            if (element.produit_type == "boisson") {
                                if (element.prix_promo != 0) {
                                    $('.boisson-content').prepend('<div class="card"><span>promo</span><img src="'+URL+element.product_img_url+'" class="card-img-top" alt="'+element.product_name+'"><div class="card-body"><h5 class="card-title">'+element.product_name+'</h5><div class="card-text"><p><s>'+element.prix+' €</s></p><p>'+element.prix_promo+' €</p></div><a href="product-detail/?access='+element.product_id+'" class="btn btn-primary">Decouvrir le produit</a></div></div>');
                                } else {
                                    $('.boisson-content').prepend('<div class="card"><img src="'+URL+element.product_img_url+'" class="card-img-top" alt="'+element.product_name+'"><div class="card-body"><h5 class="card-title">'+element.product_name+'</h5><div class="card-text"><p>'+element.prix+' €</p></div><a href="product-detail/?access='+element.product_id+'" class="btn btn-primary">Decouvrir le produit</a></div></div>');
                                }
                            }
                        });
                        $('.load').remove();
                    }, 3000);
                }
            },'json');
        });
    });
</script>
<?php
    require_once '../inc/footer.php';