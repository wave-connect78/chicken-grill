<?php
    require_once '../../inc/init.php';



    $title = 'Saint-denis produit';
    $email = 'chickengrillsaintdenis@gmail.com';
    $tel = '07 65 45 88 89';
    if(!isset($_SESSION['actuelPage']['nom_resto'])){
        header('location:https://chicken-grill.fr/');
        exit;
    }
    require_once '../../inc/header.php';


?>
<div class="product">
    <div class="img">
        <div class="img-product">
            <div class="img-content-product">
               <div>COMMANDEZ</div>
               <div><span>Restaurant</span><h3>SAINT DENIS</h3></div>
            </div>
        </div>
    </div>
    <div class="product-list">
        <div class="menu">
            <h3>Menu</h3>
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
        <div class="single-product">
            <h3>Produits</h3>
            <div class="single-product-content"></div>
        </div>
        <div class="boisson">
            <h3>Boisson</h3>
            <div class="boisson-content"></div>
        </div>
    </div>
</div>

<script>
    $(function(){
        let URL = 'https://chicken-grill.fr/';
        $(window).on('load',function(){
            $('body').prepend('<div class="load"><div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
            $.post('../../inc/controls.php',{postType:'homeData'},function(res){
                if (res.resultat) {
                    setTimeout(() => {
                        res.resultat.forEach(element => {
                            if (element.produit_type == 'aucun') {
                                if (element.prix_promo != 0) {
                                    $('.single-product-content').prepend('<div class="card"><span>promo</span><img src="'+URL+element.product_img_url+'" class="card-img-top" alt="'+element.product_name+'"><div class="card-body"><h4>'+element.sub_name+'</h4><h5 class="card-title">'+element.product_name+'</h5><div class="card-text"><p><s>'+element.prix.replace('.',',')+' €</s></p><p>'+element.prix_promo.replace('.',',')+' €</p></div><a href="/'+'<?php echo $_SESSION['actuelPage']['nom_resto']; ?>'+'/product-detail/?access='+element.product_id+'" class="btn btn-primary">Découvrir le produit</a></div></div>');
                                } else {
                                    $('.single-product-content').prepend('<div class="card"><img src="'+URL+element.product_img_url+'" class="card-img-top" alt="'+element.product_name+'"><div class="card-body"><h4>'+element.sub_name+'</h4><h5 class="card-title">'+element.product_name+'</h5><div class="card-text"><p>'+element.prix.replace('.',',')+' €<p></div><a href="/'+'<?php echo $_SESSION['actuelPage']['nom_resto']; ?>'+'/product-detail/?access='+element.product_id+'" class="btn btn-primary">Découvrir le produit</a></div></div>');
                                }
                            }
                            if (element.produit_type == "menu") {
                                if (element.prix_promo > 0) {
                                    $('.menu-content').prepend('<div class="card"><span>promo</span><img src="'+URL+element.product_img_url+'" class="card-img-top" alt="'+element.product_name+'"><div class="card-body"><h4>'+element.sub_name+'</h4><h5 class="card-title">'+element.product_name+'</h5><div class="card-text"><p><s>'+element.prix.replace('.',',')+' €</s></p><p>'+element.prix_promo.replace('.',',')+' €</p></div><a href="/'+'<?php echo $_SESSION['actuelPage']['nom_resto']; ?>'+'/product-detail/?access='+element.product_id+'" class="btn btn-primary">Decouvrir le menu</a></div></div>');
                                } else {
                                    $('.menu-content').prepend('<div class="card"><img src="'+URL+element.product_img_url+'" class="card-img-top" alt="'+element.product_name+'"><div class="card-body"><h4>'+element.sub_name+'</h4><h5 class="card-title">'+element.product_name+'</h5><div class="card-text"><p>'+element.prix.replace('.',',')+' €</p></div><a href="/'+'<?php echo $_SESSION['actuelPage']['nom_resto']; ?>'+'/product-detail/?access='+element.product_id+'" class="btn btn-primary">Decouvrir le menu</a></div></div>');
                                }
                            }
                            if (element.produit_type == "menu-simple") {
                                if (element.prix_promo != 0) {
                                    $('.menu-simple-content').prepend('<div class="card"><span>promo</span><img src="'+URL+element.product_img_url+'" class="card-img-top" alt="'+element.product_name+'"><div class="card-body"><h4>'+element.sub_name+'</h4><h5 class="card-title">'+element.product_name+'</h5><div class="card-text"><p><s>'+element.prix.replace('.',',')+' €</s></p><p>'+element.prix_promo.replace('.',',')+' €</p></div><a href="/'+'<?php echo $_SESSION['actuelPage']['nom_resto']; ?>'+'/product-detail/?access='+element.product_id+'" class="btn btn-primary">Decouvrir le menu</a></div></div>');
                                } else {
                                    $('.menu-simple-content').prepend('<div class="card"><img src="'+URL+element.product_img_url+'" class="card-img-top" alt="'+element.product_name+'"><div class="card-body"><h4>'+element.sub_name+'</h4><h5 class="card-title">'+element.product_name+'</h5><div class="card-text"><p>'+element.prix.replace('.',',')+' €</p></div><a href="/'+'<?php echo $_SESSION['actuelPage']['nom_resto']; ?>'+'/product-detail/?access='+element.product_id+'" class="btn btn-primary">Decouvrir le menu</a></div></div>');
                                }
                            }
                            if (element.produit_type == "menu-doublé") {
                                if (element.prix_promo != 0) {
                                    $('.menu-double-content').prepend('<div class="card"><span>promo</span><img src="'+URL+element.product_img_url+'" class="card-img-top" alt="'+element.product_name+'"><div class="card-body"><h4>'+element.sub_name+'</h4><h5 class="card-title">'+element.product_name+'</h5><div class="card-text"><p><s>'+element.prix.replace('.',',')+' €</s></p><p>'+element.prix_promo.replace('.',',')+' €</p></div><a href="/'+'<?php echo $_SESSION['actuelPage']['nom_resto']; ?>'+'/product-detail/?access='+element.product_id+'" class="btn btn-primary">Decouvrir le menu</a></div></div>');
                                } else {
                                    $('.menu-double-content').prepend('<div class="card"><img src="'+URL+element.product_img_url+'" class="card-img-top" alt="'+element.product_name+'"><div class="card-body"><h4>'+element.sub_name+'</h4><h5 class="card-title">'+element.product_name+'</h5><div class="card-text"><p>'+element.prix.replace('.',',')+' €</p></div><a href="/'+'<?php echo $_SESSION['actuelPage']['nom_resto']; ?>'+'/product-detail/?access='+element.product_id+'" class="btn btn-primary">Decouvrir le menu</a></div></div>');
                                }
                            }
                            if (element.produit_type == "boisson") {
                                if (element.prix_promo != 0) {
                                    $('.boisson-content').prepend('<div class="card"><span>promo</span><img src="'+URL+element.product_img_url+'" class="card-img-top" alt="'+element.product_name+'"><div class="card-body"><h4>'+element.sub_name+'</h4><h5 class="card-title">'+element.product_name+'</h5><div class="card-text"><p><s>'+element.prix.replace('.',',')+' €</s></p><p>'+element.prix_promo.replace('.',',')+' €</p></div><a href="/'+'<?php echo $_SESSION['actuelPage']['nom_resto']; ?>'+'/product-detail/?access='+element.product_id+'" class="btn btn-primary">Decouvrir le produit</a></div></div>');
                                } else {
                                    $('.boisson-content').prepend('<div class="card"><img src="'+URL+element.product_img_url+'" class="card-img-top" alt="'+element.product_name+'"><div class="card-body"><h4>'+element.sub_name+'</h4><h5 class="card-title">'+element.product_name+'</h5><div class="card-text"><p>'+element.prix.replace('.',',')+' €</p></div><a href="/'+'<?php echo $_SESSION['actuelPage']['nom_resto']; ?>'+'/product-detail/?access='+element.product_id+'" class="btn btn-primary">Decouvrir le produit</a></div></div>');
                                }
                            }
                        });
                        $('.single-product-content .card').each(function(index){
                            let innerHeight = $(this).find('.card-body h4').outerHeight(true)+$(this).find('.card-body .card-title').outerHeight(true)+$(this).find('.card-body .card-text').outerHeight(true)+$(this).find('.card-body .btn').outerHeight(true);
                            let margin = $(this).find('.card-body').height() - innerHeight
                            $(this).find('.card-body .btn').css({marginTop:margin+'px'});
                        });
                        $('.menu-double-content .card').each(function(index){
                            let innerHeight = $(this).find('.card-body h4').outerHeight(true)+$(this).find('.card-body .card-title').outerHeight(true)+$(this).find('.card-body .card-text').outerHeight(true)+$(this).find('.card-body .btn').outerHeight(true);
                            let margin = $(this).find('.card-body').height() - innerHeight
                            $(this).find('.card-body .btn').css({marginTop:margin+'px'});
                        });
                        $('.boisson-content .card').each(function(index){
                            let innerHeight = $(this).find('.card-body h4').outerHeight(true)+$(this).find('.card-body .card-title').outerHeight(true)+$(this).find('.card-body .card-text').outerHeight(true)+$(this).find('.card-body .btn').outerHeight(true);
                            let margin = $(this).find('.card-body').height() - innerHeight
                            $(this).find('.card-body .btn').css({marginTop:margin+'px'});
                        });
                        $('.menu-simple-content .card').each(function(index){
                            let innerHeight = $(this).find('.card-body h4').outerHeight(true)+$(this).find('.card-body .card-title').outerHeight(true)+$(this).find('.card-body .card-text').outerHeight(true)+$(this).find('.card-body .btn').outerHeight(true);
                            let margin = $(this).find('.card-body').height() - innerHeight
                            $(this).find('.card-body .btn').css({marginTop:margin+'px'});
                        });
                        $('.menu-content .card').each(function(index){
                            let innerHeight = $(this).find('.card-body h4').outerHeight(true)+$(this).find('.card-body .card-title').outerHeight(true)+$(this).find('.card-body .card-text').outerHeight(true)+$(this).find('.card-body .btn').outerHeight(true);
                            let margin = $(this).find('.card-body').height() - innerHeight
                            $(this).find('.card-body .btn').css({marginTop:margin+'px'});
                        });
                        $('.load').remove();
                    }, 3000);
                }
            },'json');
        });
    });
</script>
<?php
    require_once '../../inc/footer.php';