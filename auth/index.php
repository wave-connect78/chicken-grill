<?php
    require_once '../inc/init.php';

    $title = 'Connexion à mon compte';
    require_once '../inc/header.php';



?>
    <div class="auth">
        <div class="login">
            <h3 class="mb-5">Connectez vous à votre compte</h3>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Email adresse</label><br>
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                    <div class="info">Email incorrect</div>
                </div>
                <div class="mb-3">
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
                <button class="google"><i class="fab fa-google-plus-g"></i>Google</button><br>
                <button class="facebook"><i class="fab fa-facebook-f"></i>Facebook</button>
            </div>
        </div>
        <div class="sign">
            <h3 class="mb-5">Créer votre compte</h3>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Nom</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                    <div class="error">Email incorrect</div>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Email adresse</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                </div>
                <div class="mb-3">
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
        $(function(){
            $('.account .create-account').on('click',function(){
                $('.auth .login').css({display:'none'});
                $('.auth .sign').css({display:'block'});
            });
            $('.account .connect-me').on('click',function(){
                $('.auth .login').css({display:'block'});
                $('.auth .sign').css({display:'none'});
            });
        })
    </script>
<?php
    require_once '../inc/footer.php';