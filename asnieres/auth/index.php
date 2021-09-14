<?php
    require_once '../../inc/init.php';
    if(!isset($_SESSION['actuelPage'])){
        header('location:https://chicken-grill.fr');
        exit;
    }else{
        if (isOn()) {
            header('location:'.RACINE_SITE.'/'.$_SESSION['actuelPage']['nom_resto'].'/profil');
        }   
    }
    $title = 'Connexion à mon compte';
    $email = 'chickengrill.asnieres@gmail.com';
    $tel = '01 47 28 04 60';
    require_once '../../inc/header.php';



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
            <p>Vous avez oublié votre mot de passe? <span style="color:#0d6efd;cursor:pointer;" class="verifyEmail">Reinitialiser</span></p>
            <div class="renitialisePass">
                <div class="info"></div>
                <div class="mb-3 email">
                    <label for="emailV" class="form-label">Verification de votre email</label><br>
                    <input type="text" class="form-control" id="emailV" name="emailV" placeholder="name@example.com">
                    <div class="error"></div>
                </div>
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </div>
            <div class="withotherprovider">
                <div class="line"></div>
                <p>Se connecter avec</p>
                <div class="g-signin2 google" data-onsuccess="onSignIn" data-theme="light"></div>
                <button class="facebook" data-scope="email"><i class="fab fa-facebook-f"></i>Facebook</button>
                
            </div>
        </div>
        <div class="sign">
            <h3 class="mb-5">Créer votre compte</h3>
            <form action="" method="post">
                <div class="mb-3 nom">
                    <label for="exampleFormControlInput1" class="form-label">Nom*</label>
                    <input type="text" class="form-control" id="nom" name="nom" placeholder="nom">
                </div>
                <div class="mb-3 tel">
                    <label for="exampleFormControlInput1" class="form-label">Numéro de téléphone*</label>
                    <input type="text" class="form-control" id="tel" name="tel" placeholder="Numéro de téléphone">
                </div>
                <div class="mb-3 email">
                    <label for="exampleFormControlInput1" class="form-label">Email adresse*</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="name@example.com">
                </div>
                <div class="mb-3 mdp">
                    <label for="exampleFormControlInput1" class="form-label">Mot de passe*</label>
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
        let URL = 'https://chicken-grill.fr/'+'<?php echo $_SESSION['actuelPage']['nom_resto']; ?>'+'/profil';
        $(function(){
            $('.verifyEmail').on('click',function(){
                $('.renitialisePass').css({display:'block'});
            });
            $('.renitialisePass button').on('click',function(){
                $('.renitialisePass .error p').remove();
                $('.renitialisePass .info p').remove();
                if ($('.renitialisePass #emailV').val() != '') {
                    $.post('../../inc/controls.php',{postType:'renitializePass',emailV:$('.renitialisePass #emailV').val()},function(res){
                        if (res.resultat == 'emailError') {
                            $('.renitialisePass .error').append('<p>Votre adresse email n\'est pas correct</p>');
                            console.log(res.resultat);
                        }else if(res.resultat == 'noPresent'){
                            $('.renitialisePass .error').append('<p>Votre adresse email n\'existe pas dans notre base de donnée</p>');
                        }else{
                            $('.renitialisePass .info').append('<p>'+res.resultat+'</p>');
                        }
                    },'json');
                } else {
                    $('.renitialisePass .error').append('<p>Veillez indiquer une Adresse email</p>');
                }
            });
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
                    $('body').prepend('<div class="load"><div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
                    $.post('../../inc/controls.php',{email:$('.login #email').val(),mdp:$('.login #mdp').val(),postType:"login"},function(res){
                        setTimeout(() => {
                            if (res.errorMdp) {
                                $('.login .mdp').append('<div class="error">'+res.errorMdp+'</div>');
                                $('.load').remove();
                            }
                            if (res.errorVerifyEmail) {
                                $('.login').prepend('<div class="error">'+res.errorVerifyEmail+'</div>');
                                $('.load').remove();
                            }
                            if (res.error) {
                                $('.login').prepend('<div class="error">'+res.error+'</div>');
                                $('.load').remove();
                            }
                            if (res.errorMail) {
                                $('.login').prepend('<div class="error">'+res.error+'</div>');
                                $('.load').remove();
                            }
                            if (res.success) {
                                window.location.href = URL;
                            }
                            $('.load').remove(); 
                        }, 3000);
                        //console.log(res);
                    },'json');
                }
            });
            $('.sign form').on('submit',function(e){
                e.preventDefault();
                $('body').prepend('<div class="load"><div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
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
                if ($('.sign #tel').val() == '') {
                    $('.sign .tel').append('<div class="error">Votre champs est vide</div>');
                }
                if ($('.sign #nom').val() != '' && $('.sign #email').val() != '' && $('.sign #mdp').val() != '' && $('.sign #tel')) {
                    $.post('../../inc/controls.php',{nom:$('.sign #nom').val(),email:$('.sign #email').val(),mdp:$('.sign #mdp').val(),tel:$('.sign #tel').val(),postType:"sign"},function(res){
                        setTimeout(() => {
                            if (res.errorEmail) {
                                $('.sign .email').append('<div class="error">'+res.errorEmail+'</div>');
                            }
                            if (res.success) {
                                $('.sign').prepend('<div class="success">'+res.success+'</div>');
                                $('.sign #nom').val('');
                                $('.sign #email').val('');
                                $('.sign #mdp').val('');
                                $('.sign #tel').val('');
                            }
                            $('.load').remove();
                        },3000);
                    },'json');
                }
            });
            $('.facebook').on('click',function(){
                fbLogin();
            });
        });
        
        function onSignIn(googleUser) {
            var profile = googleUser.getBasicProfile();
            let guid = profile.getId();
            var idToken=profile.id_token;
            var auth2 = gapi.auth2.getAuthInstance();
            auth2.disconnect();
            $.post('../../inc/controls.php',{user_google_id:guid,nom:profile.getName(),email:profile.getEmail(),mdp:'google',postType:'googleLogin'},function(res){
                //console.log(res);
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
            
            //FB.AppEvents.logPageView();
            FB.getLoginStatus(function(response) {
                if (response.status === 'connected') {
                    //display user data
                    getFbUserData();
                }
            });   
            
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        function fbLogin() {
            FB.login(function (response) {
                if (response.authResponse) {
                    // Get and display the user profile data
                    getFbUserData();
                } else {

                }
            }, {scope: 'email',auth_type: 'rerequest'});
        }
        function getFbUserData(){
            FB.api('/me', {locale: 'en_US', fields: 'id,first_name,last_name,email,link,gender,locale,picture,permissions'},
            function (response) {
                if (response) {
                    if (response.email !='' || response.email != undefined) {
                        let nom = response.first_name+' '+response.last_name;
                        $.post('../../inc/controls.php',{nom:nom,email:response.email,user_facebook_id:response.id,mdp:'facebook',postType:'facebookLogin'},function(res){
                            if (res.success) {
                                window.location.href = URL;
                            }
                        },'json');
                    }
                }
                //console.log(response);
            });
        }
  
    </script>
<?php
    require_once '../../inc/footer.php';