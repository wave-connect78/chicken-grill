<?php
    require_once '../inc/init.php';

    $title = 'Connexion à mon compte';
    require_once '../inc/header.php';



?>
    <div class="auth">
        <div class="login">
            <h3 class="mb-5">Connectez vous à votre compte</h3>
            <form action="" method="post">
                <div class="mb-3 email">
                    <label for="exampleFormControlInput1" class="form-label">Email adresse</label><br>
                    <input type="text" class="form-control" id="email" name="email" placeholder="name@example.com">
                </div>
                <div class="mb-3 mdp">
                    <label for="exampleFormControlInput1" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="mdp" name="mdp" placeholder="name@example.com">
                </div>
                <div class="account">
                    <button type="submit">Se connecter</button>
                    <p class="create-account">Créer votre compte</p>
                </div>
            </form>
            <p>Vous avez oublié votre mot de passe? <a href="#">Reinitialiser</a></p>
            <div class="withotherprovider">
                <div class="line"></div>
                <p>Se connecter avec</p>
                <!--<button id="gSignIn" class="google"><i class="fab fa-google-plus-g"></i>Google</button><br>-->
                <div class="g-signin2 google" data-onsuccess="onSignIn"></div>
                <!--<button class="facebook"><i class="fab fa-facebook-f"></i>Facebook</button>-->
                <div class="fb-login-button" data-width="" data-size="large" data-button-type="login_with" data-layout="default" data-auto-logout-link="false" data-use-continue-as="false" onlogin="checkLoginState();"></div>
                
            </div>
        </div>
        <div class="sign">
            <h3 class="mb-5">Créer votre compte</h3>
            <form action="" method="post">
                <div class="mb-3 nom">
                    <label for="exampleFormControlInput1" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" placeholder="nom">
                </div>
                <div class="mb-3 email">
                    <label for="exampleFormControlInput1" class="form-label">Email adresse</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="name@example.com">
                </div>
                <div class="mb-3 mdp">
                    <label for="exampleFormControlInput1" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="mdp" name="mdp" placeholder="name@example.com">
                </div>
                <div class="account">
                    <button type="submit">Enregistrer les données</button>
                    <p class="connect-me">Me connecter</p>
                </div>
            </form>
        </div>
    </div>
    

    <script>
        let URL = 'http://localhost/chicken-grill/profil/';
        $(function(){
            $('.account .create-account').on('click',function(){
                $('.auth .login').css({display:'none'});
                $('.auth .sign').css({display:'block'});
            });
            $('.account .connect-me').on('click',function(){
                $('.auth .login').css({display:'block'});
                $('.auth .sign').css({display:'none'});
            });
            $('.login form').on('submit',function(e){
                e.preventDefault();
                $('.login .error').remove();
                if ($('.login #email').val() == '') {
                    $('.login .email').append('<div class="error">Votre champs est vide</div>');
                }
                if ($('.login #mdp').val() == '') {
                    $('.login .mdp').append('<div class="error">Votre champs est vide</div>');
                }
                if ($('.login #email').val() != '' && $('.login #mdp').val() != '') {
                    $.post('../inc/controls.php',{email:$('.login #email').val(),mdp:$('.login #mdp').val(),postType:"login"},function(res){
                        if (res.errorMdp) {
                            $('.login .mdp').append('<div class="error">'+res.errorMdp+'</div>'); 
                        }
                        if (res.error) {
                            $('.login').prepend('<div class="error">'+res.error+'</div>');
                        }
                        if (res.success) {
                            window.location.href = URL;
                        }
                        //console.log(res);
                    },'json');
                }
            });
            $('.sign form').on('submit',function(e){
                e.preventDefault();
                $('.sign .error').remove();
                $('.sign .success').remove();
                if ($('.sign #nom').val() == '') {
                    $('.sign .nom').append('<div class="error">Votre champs est vide</div>');
                }
                if ($('.sign #email').val() == '') {
                    $('.sign .email').append('<div class="error">Votre champs est vide</div>');
                }
                if ($('.sign #mdp').val() == '') {
                    $('.sign .mdp').append('<div class="error">Votre champs est vide</div>');
                }
                if ($('.sign #nom').val() != '' && $('.sign #email').val() != '' && $('.sign #mdp').val() != '') {
                    $.post('../inc/controls.php',{nom:$('.sign #nom').val(),email:$('.sign #email').val(),mdp:$('.sign #mdp').val(),postType:"sign"},function(res){
                        console.log(res);
                        if (res.errorEmail) {
                            $('.sign .email').append('<div class="error">'+res.errorEmail+'</div>');
                        }
                        if (res.success) {
                            $('.sign').prepend('<div class="success">'+res.success+'</div>');
                        }
                    },'json');
                }
            });
            $('.google').on('click',function(){

            });
        });
        
        function onSignIn(googleUser) {
            var profile = googleUser.getBasicProfile();
            $.post('../inc/controls.php',{nom:profile.getName(),email:profile.getEmail(),mdp:'google',postType:"googleLogin"},function(res){
                console.log(res);
                if (res.success) {
                    window.location.href = URL;
                }
            },'json');
        }
        
        window.fbAsyncInit = function() {
            FB.init({
            appId      : '2027066680767202',
            cookie     : true,
            xfbml      : true,
            version    : 'v11.0'
            });
            
            FB.AppEvents.logPageView();   
            
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        function checkLoginState() {               
            FB.getLoginStatus(function(response) {   
            statusChangeCallback(response);
            });
        }

        function statusChangeCallback(response) { 
            console.log('statusChangeCallback');
            console.log(response);                   
            if (response.status === 'connected') {   
                testAPI();  
            } else {                                 
            //document.getElementById('status').innerHTML = 'Please log ' +
                'into this webpage.';
            }
        }
        function testAPI() {                      
            console.log('Welcome!  Fetching your information.... ');
            FB.api('/me', function(response) {
            console.log('Successful login for: ' + response.name);
        });
  }
    </script>
<?php
    require_once '../inc/footer.php';