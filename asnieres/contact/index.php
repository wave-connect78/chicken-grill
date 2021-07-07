<?php
    require_once '../../inc/init.php';

    $title = "Nous contacter";
    $email = 'chickengrill.asnieres@gmail.com';
    $tel = '07 65 45 88 89';
    require_once '../../inc/header.php';


?>
<div class="contactclient">
    <h2>Nos différents points de vente</h2>
    <div class="restaurant">
        <div class="bloc">
            <h5>Chicken grill asnieres</h5>
            <p><i class="fas fa-map-marker-alt"></i>Adresse : 104 rue Émile Zola 92600 Asnières sur seine</p>
            <p><i class="fas fa-phone-alt"></i>Tel : 01 71 67 75 41</p>
            <p><i class="fas fa-envelope"></i>Email : <a href="mailto:chickengrill.asnieres@gmail.com">Chicken grill asnieres</a></p>
        </div>
        <div class="bloc">
            <h5>Chicken grill argenteuil</h5>
            <p><i class="fas fa-map-marker-alt"></i>Adresse : 149 av Jean Jaurè 95100 Argenteuil</p>
            <p><i class="fas fa-phone-alt"></i>Tel : 01 71 67 75 41</p>
            <p><i class="fas fa-envelope"></i>Email : <a href="mailto:chickengrill.argenteuil95@gmail.com">Chicken grill argenteuil</a></p>
        </div>
        <div class="bloc">
            <h5>Chicken grill bezons</h5>
            <p><i class="fas fa-map-marker-alt"></i>Adresse : 16 rue de Montesson 95870 Bezons</p>
            <p><i class="fas fa-phone-alt"></i>Tel : 01 71 67 75 41</p>
            <p><i class="fas fa-envelope"></i>Email : <a href="mailto:chickengrill.bezons@gmail.com">Chicken grill bezon</a></p>
        </div>
        <div class="bloc">
            <h5>Chicken grill saint-denis</h5>
            <p><i class="fas fa-map-marker-alt"></i>Adresse : 67 rue Gabriel Péri 93200 Saint Denis</p>
            <p><i class="fas fa-phone-alt"></i>Tel : 01 71 67 75 41</p>
            <p><i class="fas fa-envelope"></i>Email : <a href="mailto:chickengrillsaintdenis@gmail.com">Chicken grill saint-denis</a></p>
        </div>
        <div class="bloc">
            <h5>Chicken grill epinay/seine</h5>
            <p><i class="fas fa-map-marker-alt"></i>Adresse : 27 impasse du noyer bossu 93800 Epinay sur seine</p>
            <p><i class="fas fa-phone-alt"></i>Tel : 01 71 67 75 41</p>
            <p><i class="fas fa-envelope"></i>Email : <a href="mailto:chickengrill.93800@gmail.com">Chicken grill epinay/seine</a></p>
        </div>
    </div>
    
    <div class="formcontact">
    <h3 class="mb-5 mt-5">Nous envoyer un message</h3>
        <form action="" method="post">
            <div class="mb-3">
                <label for="nom" class="form-label">Votre nom complet</label>
                <input type="text" class="form-control" id="nom" name="nom" placeholder="Votre nom">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Votre adresse email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Votre adersse mail">
            </div>
            <div class="mb-3">
                <label for="objet" class="form-label">L'objet de votre méssage</label>
                <input type="text" class="form-control" id="objet" name="objet" placeholder="L'objet de votre méssage">
            </div>
            <input type="hidden" name="restoemail" class="restoemail" value="chickengrill.asnieres@gmail.com">
            <div class="mb-3">
                <label for="message" class="form-label" placeholder="Votre méssage">Insérer votre méssage</label>
                <textarea name="message" id="message" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer votre méssage</button>
        </form>
    </div>
</div>
<?php
    require_once '../../inc/footer.php';