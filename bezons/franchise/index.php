<?php
    require_once '../../inc/init.php';

    $title = "Devenir franchisé";
    $email = 'chickengrill.bezons@gmail.com';
    $tel = '01 71 67 75 41';
    if(!isset($_SESSION['actuelPage'])){
        header('location:https://chicken-grill.fr/');
        exit;
    }
    require_once '../../inc/header.php';


?>
<div class="franchise">
    <h3 class="text-center m-5">Devenez franchisé Chicken-Grill !</h3>
      
    <div class="franchise-bloc">
        <div class="rows">
            <div class="cols">
                <i class="fas fa-door-open"></i>
                <br>
                Droit d'entrée à 15 000€ HT
             </div>
            <div class="cols">
                <i class="fas fa-graduation-cap"></i> 
                <br>
                Formation à 7500€ HT
            </div>
            <div class="cols">
                <i class="fas fa-money-check-alt"></i>
                <br>
                Redevance à 1200€ HT /mois
            </div>
            <div class="cols">
                <i class="fas fa-comment-dots"></i>
                <br>
                Participation à la communication (qot-part selon campagne et budget alloué aux réseaux sociaux)
            </div>
        </div>
    </div>
      
    <div class="formcontact">  
        <h3 class="text-center mb-5 mt-5">Candidater !</h3>
        <form action="" method="post">
            <h3 class="mt-4 mb-4">Remplisser le formulaire</h3>
          <div class="mb-3">
              <label for="nom" class="form-label">Votre nom complet</label>
              <input type="text" class="form-control" id="nom" name="nom" placeholder="Votre nom">
          </div>
          <div class="mb-3">
              <label for="email" class="form-label">Votre adresse</label>
              <input type="text" class="form-control" id="adresse" name="address" placeholder="Votre adresse">
          </div>
          <div class="mb-3">
              <label for="email" class="form-label">Votre email</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="Votre email">
          </div>
          <input type="hidden" name="restoemail" class="restoemail" value="chickengrill.bezons@gmail.com">
          <div class="mb-3">
              <label for="candidature" class="form-label" placeholder="Votre message">Insérer votre candidature</label>
              <textarea name="candidature" id="candidature" class="form-control"></textarea>
          </div>
          <button type="submit" class="btn btn-primary text-center">Déposer ma candidature pour être franchisé</button>
        </form>
    </div>
</div>
<script>
    $(function(){
        $('.formcontact form').on("submit",function(e){
            e.preventDefault();
            $('.formcontact form .error').remove();
             $('.formcontact form .success').remove();
            let destination = $('.formcontact form .restoemail').val();
            let nom = $('.formcontact form #nom').val();
            let email = $('.formcontact form #email').val();
            let adresse = $('.formcontact form #adresse').val();
            let message = $('.formcontact form #candidature').val();
            
            if (destination != '' && nom != '' && email != '' && adresse != '' && message != '') {
                $.post("../../inc/controls.php",{postType:'becommeFranchise',destination:destination,nom:nom,email:email,adresse:adresse,message:message},function(res){
                    if (res.resultat) {
                        if (res.resultat == "emailError") {
                            $('.formcontact form').prepend('<div class="error"><p>Votre email n\'est pas valide</p></div>');
                        } else if(res.resultat == "messageError") {
                            $('.formcontact form').prepend('<div class="error"><p>Une erreur est survenu lors de l\'envoie du message veillez reeassayer ulteurieurement</p></div>');
                        }else{
                            $('.formcontact form').prepend('<div class="success"><p>'+res.resultat+'</p></div>');
                        }
                    }
                },'json');
            }else{
                $('.formcontact form').prepend('<div class="error"><p>Veuillez remplir tous les champs.</p></div>');
            }
        });
    });
</script>
<?php
    require_once '../../inc/footer.php';