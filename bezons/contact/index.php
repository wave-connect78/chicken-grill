<?php
    require_once '../../inc/init.php';

    $title = "Nous contacter";
    $email = 'chickengrill.bezons@gmail.com';
    $tel = '01 71 67 75 41';
    if(!isset($_SESSION['actuelPage'])){
        header('location:https://chicken-grill.fr/');
        exit;
    }
    require_once '../../inc/header.php';


?>
<div class="contactclient">
    <h2>Nos différents points de vente</h2>
     <div class="restaurant">
        <div class="bloc">
            <h5>Chicken grill Asnieres</h5>
            <p><i class="fas fa-map-marker-alt"></i>Adresse : 104 rue Émile Zola 92600 Asnières sur seine</p>
            <p><i class="fas fa-phone-alt"></i>Tel : 01 47 28 04 60</p>
            <p><i class="fas fa-envelope"></i>Email : <a href="mailto:chickengrill.asnieres@gmail.com">Chicken grill Asnieres</a></p>
        </div>
        <div class="bloc">
            <h5>Chicken grill Argenteuil</h5>
            <p><i class="fas fa-map-marker-alt"></i>Adresse : 149 av Jean Jaurès 95100 Argenteuil</p>
            <p><i class="fas fa-phone-alt"></i>Tel : 06 21 52 65 93</p>
            <p><i class="fas fa-envelope"></i>Email : <a href="mailto:chickengrill.argenteuil95@gmail.com">Chicken grill Argenteuil</a></p>
        </div>
        <div class="bloc">
            <h5>Chicken grill Bezons</h5>
            <p><i class="fas fa-map-marker-alt"></i>Adresse : 16 rue de Montesson 95870 Bezons</p>
            <p><i class="fas fa-phone-alt"></i>Tel : 01 71 67 75 41</p>
            <p><i class="fas fa-envelope"></i>Email : <a href="mailto:chickengrill.bezons@gmail.com">Chicken grill Bezon</a></p>
        </div>
        <div class="bloc">
            <h5>Chicken grill Saint-Denis</h5>
            <p><i class="fas fa-map-marker-alt"></i>Adresse : 67 rue Gabriel Péri 93200 Saint-Denis</p>
            <p><i class="fas fa-phone-alt"></i>Tel : 09 53 37 75 04</p>
            <p><i class="fas fa-envelope"></i>Email : <a href="mailto:chickengrillsaintdenis@gmail.com">Chicken grill Saint-Denis</a></p>
        </div>
        <div class="bloc">
            <h5>Chicken grill Epinay/seine</h5>
            <p><i class="fas fa-map-marker-alt"></i>Adresse : 27 impasse du Noyer Bossu 93800 Epinay Sur Seine</p>
            <p><i class="fas fa-phone-alt"></i>Tel : 09 53 36 02 17</p>
            <p><i class="fas fa-envelope"></i>Email : <a href="mailto:chickengrill.93800@gmail.com">Chicken grill Epinay/seine</a></p>
        </div>
    </div>
    
    <div class="formcontact">
        <h3 class="mb-5 mt-5">Nous envoyer un message</h3>
        <div class="message"></div>
        <form action="" method="post">
            <div class="mb-3">
                <label for="nom" class="form-label">Votre nom complet</label>
                <input type="text" class="form-control" id="nom" name="nom" placeholder="Votre nom">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Votre adresse email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Votre adresse mail">
            </div>
            <div class="mb-3">
                <label for="objet" class="form-label">L'objet de votre message</label>
                <input type="text" class="form-control" id="objet" name="objet" placeholder="L'objet de votre message">
            </div>
            <input type="hidden" name="restoemail" class="restoemail" value="chickengrill.bezons@gmail.com">
            <div class="mb-3">
                <label for="message" class="form-label" placeholder="Votre méssage">Insérer votre message</label>
                <textarea name="message" id="message" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer votre message</button>
        </form>
    </div>
</div>
<script>
    $(function(){
        $('.formcontact form').on("submit",function(e){
            e.preventDefault();
            $('.formcontact form .error p').remove();
            $('.formcontact .message div').remove();
            let destination = $('.formcontact form .restoemail').val();
            let nom = $('.formcontact form #nom').val();
            let email = $('.formcontact form #email').val();
            let objet = $('.formcontact form #objet').val();
            let message = $('.formcontact form #message').val();
            if (destination != '' && nom != '' && email != '' && objet != '' && message != '') {
                $.post("../../inc/controls.php",{postType:'emailContact',destination:destination,nom:nom,email:email,objet:objet,message:message},function(res){
                    if (res.resultat) {
                        if (res.resultat == "emailError") {
                            $('.formcontact form .error').append('<p>Votre email n\'est pas valide</p>');
                        } else if(res.resultat == "messageError") {
                            $('.formcontact .message').append('<div class="error"><p>Une erreur est survenu lors de l\'envoie du message veuillez réessayer ultérieurement</p></div>');
                        }else{
                            $('.formcontact .message').append('<div class="success"><p>'+res.resultat+'</p></div>');
                        }
                    }
                },'json');
            }else{
                $('.formcontact .message').append('<div class="error"><p>Veuillez remplir tous les champs.</p></div>');
            }
        });
    });
</script>
<?php
    require_once '../../inc/footer.php';