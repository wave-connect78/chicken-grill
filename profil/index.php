<?php
    require_once '../inc/init.php';

    if (!isOn()) {
        header('location:'.RACINE_SITE.'auth');
        exit;
    }

    $title = 'Profil';

    require_once '../inc/header.php';
    print_r($_SESSION['user']);

?>
<div class="profil">
    <div class="profil-content">
        <h3 class="mb-4">Bienvenu dans votre espace personnelle</h3>
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
                            <a href="?action=out&access=<?php echo $_SESSION['user']['user_id'] ?>">Me deconnecter</a>
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
                offre
        </div>
    </div>
</div>

<script>
    let URL = 'http://localhost/chicken-grill/auth/';
    $(function(){
        $('.profil .adresse').on("click",function(){
            $('.profil .delivrary-adresse').css({display:'block'});
            $('.profil .relise-order').css({display:'none'});
            $('.profil .delivrary-order').css({display:'none'});
            $('.profil .offer').css({display:'none'});
        });
        $('.profil .commande').on("click",function(){
            $('.profil .relise-order').css({display:'block'});
            $('.profil .delivrary-adresse').css({display:'none'});
            $('.profil .delivrary-order').css({display:'none'});
            $('.profil .offer').css({display:'none'});
            $.post("../inc/controls.php",{postType:'clientCommande',user_id:<?php echo $_SESSION['user']['user_id'] ?>},function(res){
                if (res.resultat != null) {
                    console.log(res.resultat);
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
        });
        $('.profil .offre').on("click",function(){
            $('.profil .offer').css({display:'block'});
            $('.profil .delivrary-adresse').css({display:'none'});
            $('.profil .relise-order').css({display:'none'});
            $('.profil .delivrary-order').css({display:'none'});
        });
        $('.googlebtn').on('click',function(){
            $.post("../inc/controls.php",{postType:'googleOut'},function(res){
                if (res.resultat = 'ok') {
                    var auth2 = gapi.auth2.getAuthInstance();
                    auth2.signOut().then(function () {
                        window.location.href = URL;
                    });
                }
            },'json');
        });
        $('.facebookbtn').on('click',function(){
            $.post("../inc/controls.php",{postType:'facebookOut'},function(res){
                if (res.resultat = 'ok') {
                    FB.getLoginStatus(function(response) {
                        if (response && response.status === 'connected') {

                            FB.logout(function(response) {
                                window.location.href = URL;
                            });
                        }else if (response.status === 'not_authorized') {
                                FB.logout(function(response) {
                                    window.location.href = URL;
                                });
                        }
                    }); 
                }
            },'json');
        });
    });
</script>

<?php
    require_once '../inc/footer.php';