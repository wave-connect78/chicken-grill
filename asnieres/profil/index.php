<?php
    require_once '../../inc/init.php';

    if(!isset($_SESSION['actuelPage'])){
        header('location:https://chicken-grill.fr/');
        exit;
    }else{
       if (!isOn()) {
            header('location:'.RACINE_SITE.'/'.$_SESSION['actuelPage']['nom_resto'].'/auth');
            exit;
        } 
    }
    $title = 'Profil';
    $email = 'chickengrill.asnieres@gmail.com';
    $tel = '01 47 28 04 60';
    
    if(isset($_GET) && !empty($_GET)){
        if($_GET['action'] == 'out'){
            unset($_SESSION['user']);
            header('location:/'.$_SESSION['actuelPage']['nom_resto'].'/auth');
            exit;
        }
    }
    require_once '../../inc/header.php';

?>
<?php 
    if ($_SESSION['user']['statut'] == 'client') {
        ?>
        <div class="profil">
            <div class="profil-content">
                <h3 class="mb-4">Bienvenu dans votre espace personnel</h3>
                <p class="mb-6">Vous êtes connecté en tant que <?php echo $_SESSION['user']['nom'] ?></p>
                <div class="profil-navigation">
                    <div class="item adresse">
                        <div>
                            <i class="fas fa-map-marked-alt"></i>
                            <p>Définir une adresse de livraison</p>
                        </div>
                    </div>
                    <div class="item commande">
                        <div>
                            <i class="fas fa-shopping-bag"></i>
                            <p>Voir mes commandes réalisées</p>
                        </div>
                    </div>
                    <div class="item livraison">
                        <div>
                            <i class="fas fa-route"></i>
                            <p>Suivre mes commandes en cour de livraison</p>
                        </div>
                    </div>
                    <div class="item offre">
                        <div>
                            <i class="fab fa-buffer"></i>
                            <p>Les offres du moment</p>
                        </div>
                    </div>
                    <div class="item paramettre">
                        <div>
                            <i class="fas fa-cog"></i></i>
                            <p>Paramétrer votre compte</p>
                        </div>
                    </div>
                    <?php 
                        if ($_SESSION['user']['user_google_id'] != '') {
                            ?>
                            <div class="item googlebtn">
                                <div>
                                    <i class="fas fa-sign-out-alt"></i>
                                    <p>Me deconnecter</p>
                                </div>
                            </div>
                            <?php
                        }elseif ($_SESSION['user']['user_facebook_id'] != '') {
                            ?>
                            <div class="item facebookbtn">
                                <div>
                                    <i class="fas fa-sign-out-alt"></i>
                                    <p>Me deconnecter</p>
                                </div>
                            </div>
                            <?php
                        }else{
                            ?>
                            <div class="item">
                                <div>
                                    <i class="fas fa-sign-out-alt"></i><br>
                                    <a href="?action=out">Me deconnecter</a>
                                </div>
                            </div>
                            <?php
                        }
                    ?>
                </div>
                <div class="delivrary-adresse">
                    <h3 class="mt-4 mb-4">Définir une adresse de livraison pour vos différentes commandes</h3>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="nom_complet" class="form-label">Nom complet</label>
                            <input type="text" class="form-control" id="nom_complet" name="nom_complet" placeholder="Nom complet comme indiqué sur la boite aux lettres">
                        </div>
                        <div class="mb-3">
                            <label for="adresse" class="form-label">Numéro et adresse</label>
                            <input type="text" class="form-control" id="adresse" name="adresse" placeholder="Numéro de rue et adresse">
                        </div>
                        <div class="mb-3">
                            <label for="ville" class="form-label">La ville</label>
                            <input type="text" class="form-control" id="ville" name="ville" placeholder="La ville ou voulez être livré">
                        </div>
                        <div class="mb-3">
                            <label for="cp" class="form-label">Le code postal</label>
                            <input type="text" class="form-control" id="cp" name="cp" placeholder="Le code postal de votre ville de livraison">
                        </div>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </form>
                </div>
                <div class="relise-order">
                    
                </div>
                <div class="delivrary-order">
                        livraison
                </div>
                <div class="offer">
                    <div class="offer-content"></div>
                </div>
                <div class="setting">
                    <div class="setting-tel">
                        <h3 class="mb-5">Ajouter ou changer de numéro de téléphone</h3>
                        <?php echo $messageTel; ?>
                        <form method="post" class="mb-5">
                            <div class="mb-3 tel">
                                <label for="tel" class="form-label">Votre numéro de téléphone</label>
                                <input type="text" class="form-control" id="tel" name="tel" placeholder="Ajouter ou changer de numéro de téléphone">
                            </div>
                            <button type="submit" class="btn btn-primary">Ajouter/Modifier</button>
                        </form>
                    </div>
                    <?php 
                        if($_SESSION['user']['user_facebook_id'] == '' && $_SESSION['user']['user_google_id'] == ''){
                            ?>
                            <hr>
                            <div class="setting-mail">
                                <h3 class="mb-5 mt-5">Changer votre adresse mail</h3>
                                <form method="post" class="mb-5">
                                    <div class="mb-3 email">
                                        <label for="email" class="form-label">Votre adresse mail</label>
                                        <input type="text" class="form-control" id="email" name="email" placeholder="Changer votre adresse mail">
                                    </div>
                                    <div class="mb-3 cemail">
                                        <label for="email" class="form-label">Confirmé votre adresse mail</label>
                                        <input type="text" class="form-control" id="cemail" name="cemail" placeholder="Confirmé votre adresse mail">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Changer</button>
                                </form>
                            </div>
                            <hr>
                            <div class="setting-mdp">
                                <h3 class="mb-5 mt-5">Changer votre mot de passe</h3>
                                <form method="post" class="mb-5">
                                    <div class="mb-3 mdp">
                                        <label for="mdp" class="form-label">Nouveau mot de passe</label>
                                        <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Nouveau mot de passe">
                                    </div>
                                    <div class="mb-3 cmdp">
                                        <label for="cmdp" class="form-label">Confirmation du mot de passe</label>
                                        <input type="password" class="form-control" id="cmdp" name="cmdp" placeholder="Confirmation du mot de passe">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Changer</button>
                                </form>
                            </div>
                            <?php
                        }
                    ?>
                </div>
            </div>
        </div>
        <?php
    } else {
        if(isRestoAsnieresOn() && $_SESSION['actuelPage']['nom_resto'] != 'asnieres' || isRestoArgenteuilOn() && $_SESSION['actuelPage']['nom_resto'] != 'argenteuil' || isRestoBezonsOn() && $_SESSION['actuelPage']['nom_resto'] != 'bezons' || isRestoSaintDenisOn() && $_SESSION['actuelPage']['nom_resto'] != 'saint-denis' || isRestoEpinaySeineOn() && $_SESSION['actuelPage']['nom_resto'] != 'epinay-seine'){
            ?>
                <div style="text-align:center;margin:50px auto;">
                    <p>Vous n'êtes pas au bon endroit. Veillez vous déconnecter ou vous sérez déconnecter automatiquement</p>
                    <a href="?action=out" class="btn btn-primary">Se déconnecter</a>
                </div>
            <?php
        }else{
            ?>
                <div style="text-align:center;margin:50px auto;">
                    <p>Vous n'êtes pas client mais certainement administrateur. Pour consulter vos archivres (gestion des produits,commandes enregistrées), référez vous au backoffice</p>
                    <a href="?action=out" class="btn btn-primary">Se déconnecter</a>
                    <a href="/admin" class="btn btn-primary">Rejoindre le backoffice</a>
                </div>
            <?php
        }
    }
    
?>


<script>
    let URL = 'https://chicken-grill.fr/';
    function onLoad() {
        gapi.load('auth2', function() {
            gapi.auth2.init();
        });
    }
    $(function(){
        $('.profil .adresse').on("click",function(){
            $('.profil .delivrary-adresse').css({display:'block'});
            $('.profil .relise-order').css({display:'none'});
            $('.profil .delivrary-order').css({display:'none'});
            $('.profil .offer').css({display:'none'});
            $('.profil .setting').css({display:'none'});
        });
        $('.profil .commande').on("click",function(){
             $('.profil .relise-order table').remove();
            $('.profil .relise-order p').remove();
            $('.profil .relise-order').css({display:'block'});
            $('.profil .delivrary-adresse').css({display:'none'});
            $('.profil .delivrary-order').css({display:'none'});
            $('.profil .offer').css({display:'none'});
            $('.profil .setting').css({display:'none'});
            $.post("../../inc/controls.php",{postType:'clientCommande',user_id:<?php echo $_SESSION['user']['user_id'] ?>},function(res){
                let table = '<table class ="table table-striped mb-5 mt-5">';
                table += '<tr><th>Nr. commande</th><th>Detail de la commande</th><th>Prix</th><th>Statut de la commande</th><th>Restaurant</th><th>Date de la commande</th></tr>';
                
                if (res.resultat != null) {
                    console.log(res.resultat);
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
                        
                        table += '<td>'+(i+1)+'</td>';
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
                        table += '<td>'+element.resto+'</td>';
                        table += '<td>'+element.commande_date+'</td>';
                        table += '</tr>';
                        commandeList = '';
                    }
                    
                    $('.profil .relise-order').prepend(table);
                }else{
                    $('.profil .relise-order').prepend('<p class="mt-4 mb-8" style="text-align:center;">Aucune commande réalisée pour l\'instant</p>');
                }
            },'json');
        });
        
        $('.profil .livraison').on("click",function(){
            $('.profil .delivrary-order').css({display:'block'});
            $('.profil .delivrary-adresse').css({display:'none'});
            $('.profil .relise-order').css({display:'none'});
            $('.profil .offer').css({display:'none'});
            $('.profil .setting').css({display:'none'});
        });
        $('.profil .paramettre').on("click",function(){
            $('.profil .setting').css({display:'block'});
            $('.profil .delivrary-order').css({display:'none'});
            $('.profil .delivrary-adresse').css({display:'none'});
            $('.profil .relise-order').css({display:'none'});
            $('.profil .offer').css({display:'none'});
        });
        $('.profil .offre').on("click",function(){
            $('.profil .offer').css({display:'block'});
            $('.profil .delivrary-adresse').css({display:'none'});
            $('.profil .relise-order').css({display:'none'});
            $('.profil .delivrary-order').css({display:'none'});
            $('.profil .setting').css({display:'none'});
            $.post("../../inc/controls.php",{postType:'clientOffer'},function(res){
                if (res.resultat != null) {
                    $('.profil .offer .offer-content .card').remove();
                    for (let i = 0; i < res.resultat.length; i++) {
                        const element = res.resultat[i];
                        $('.profil .offer .offer-content').prepend('<div class="card"><span>promo</span><img src="'+URL+element.product_img_url+'" class="card-img-top" alt="'+element.product_name+'"><div class="card-body"><h5 class="card-title">'+element.product_name+'</h5><div class="card-text"><p><s>'+element.prix+' €</s></p><p>'+element.prix_promo+' €</p></div><a href="../<?php echo $_SESSION['actuelPage']['nom_resto']; ?>/product-detail/?access='+element.product_id+'" class="btn btn-primary">Découvrir le produit</a></div></div>')
                    }
                }else{
                    $('.profil .offer').prepend('<p class="mt-4 mb-8" style="text-align:center;">Nous n\'avons aucune offre en ce moment</p>');
                }
            },'json');
        });
        $('.googlebtn').on('click',function(){
            $('body').prepend('<div class="load"><div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
            $.post("../../inc/controls.php",{postType:'googleOut'},function(res){
                setTimeout(() => {
                    if (res.resultat = 'ok') {
                        var auth2 = gapi.auth2.getAuthInstance();
                        auth2.signOut().then(function () {
                            window.location.href = URL+'<?php echo $_SESSION['actuelPage']['nom_resto'] ?>'+'/auth';
                        });
                    }
                    $('.load').remove();
                }, 3000);
            },'json');
        });
        $('.facebookbtn').on('click',function(){
            $('body').prepend('<div class="load"><div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
            $.post("../../inc/controls.php",{postType:'facebookOut'},function(res){
                setTimeout(() => {
                    if (res.resultat = 'ok') {
                        FB.getLoginStatus(function(response) {
                            if (response && response.status === 'connected') {
    
                                FB.logout(function(response) {
                                    window.location.href = URL+'<?php echo $_SESSION['actuelPage']['nom_resto'] ?>'+'/auth';
                                });
                            }else if (response.status === 'not_authorized') {
                                    FB.logout(function(response) {
                                        window.location.href = URL+'<?php echo $_SESSION['actuelPage']['nom_resto'] ?>'+'/auth';
                                    });
                            }
                        }); 
                    }
                     $('.load').remove();
                }, 3000);
            },'json');
        });
        $('.profil .setting-tel form').on("submit",function(e){
            e.preventDefault();
            $('.profil .setting-tel .tel .error').remove();
            if($('.profil #tel').val() != ''){
                $.post("../../inc/controls.php",{postType:'telAdd',tel:$('.profil #tel').val()},function(res){
                    if(res.resultat){
                        $('.profil .setting-tel form').prepend('<div class="success">'+res.resultat+'</div>');
                        $('.profil #tel').val('');
                    }
                },'json');
            }else{
                $('.profil .setting-tel .tel').append('<div class="error">Votre champ est vide</div>')
            }
        });
        $('.profil .setting-mail form').on("submit",function(e){
            e.preventDefault();
            $('.profil .setting-mail .email .error').remove();
            $('.profil .setting-mail .cemail .error').remove();
            if($('.profil #email').val() == ''){
                $('.profil .setting-mail .email').append('<div class="error">Votre champ est vide</div>');
            }
            if($('.profil #cemail').val() == ''){
                $('.profil .setting-mail .cemail').append('<div class="error">Votre champ est vide</div>');
            }
            if($('.profil #email').val() != '' && $('.profil #cemail').val() != ''){
                if($('.profil #email').val() == $('.profil #cemail').val()){
                    $.post("../../inc/controls.php",{postType:'changeEmail',email:$('.profil #email').val()},function(res){
                        if(res.resultat == 'emailError'){
                           $('.profil .setting-mail .email').append('<div class="error">Votre email n\'est pas conforme. </div>');
                        }else{
                             $('.profil .setting-mail form').prepend('<div class="success">'+res.resultat+'</div>');
                            $('.profil #tel').val('');
                        }
                    },'json');
                }
            }
        });
        $('.profil .setting-mdp form').on("submit",function(e){
            e.preventDefault();
            $('.profil .setting-mdp form .error').remove();
            $('.profil .setting-mdp .mdp .error').remove();
            $('.profil .setting-mdp .cmdp .error').remove();
            if($('.profil #mdp').val() == ''){
                $('.profil .setting-mdp .mdp').append('<div class="error">Votre champ est vide</div>');
            }
            if($('.profil #cmdp').val() == ''){
                $('.profil .setting-mdp .cmdp').append('<div class="error">Votre champ est vide</div>');
            }
            if($('.profil #mdp').val() != '' && $('.profil #cmdp').val() != ''){
                if($('.profil #mdp').val() == $('.profil #cmdp').val()){
                    $.post("../../inc/controls.php",{postType:'updateMdpProdil',mdp:$('.profil #mdp').val()},function(res){
                        if(res.resultat){
                            $('.profil .setting-mdp form').prepend('<div class="success">'+res.resultat+'</div>');
                            $('.profil #mdp').val('');
                            $('.profil #cmdp').val('');
                        }
                    },'json');
                }else{
                    $('.profil .setting-mdp form').prepend('<div class="error">Vos données insérées ne sont pas identiques</div>')
                }
            }
        });
    });
</script>

<?php
    require_once '../../inc/footer.php';