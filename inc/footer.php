</main>
    <footer>
        <div class="footer-top">
            <div class="follow-us">
                <h4>Suivez nous</h4>
                <div>
                    <p>Vous pouvez nous suivre sur différent reseaux sociaux</p>
                    <div class="social-media">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-pinterest"></i></a>
                        <a href="#"><i class="fas fa-rss"></i></a>
                    </div>
                </div>
            </div>
            <div class="service">
                <h4>Mes services</h4>
                <div>
                    <p class="print">Imprimer la page</p>
                    <p><a href="">Condition générale de vente</a></p>
                    <p><a href="">Condition générale d'utilisation</a></p>
                    <p><a href="<?php echo RACINE_SITE.$_SESSION['actuelPage']['nom_resto'].'/auth'; ?>">Connexion/Inscription</a></p>
                </div>
            </div>
            <div class="contact-us">
                <h4>Nous contacter</h4>
                <div>
                    <p>Vous pouvez nous contacter grâce à notre adresse mail ou par téléphone</p>
                    <p class="adress"><i class="fas fa-map-marker-alt"></i>Adresse : <span><?php echo $_SESSION['actuelPage']['adresse']; ?> </span></p>
                    <p class="tel"><i class="fas fa-phone-alt"></i>Téléphone : <span> <?php echo $tel; ?></span></p>
                    <p class="email"><i class="fas fa-envelope"></i>E-mail : <a href="mailto:<?php echo $email; ?>"> Chicken grill <?php echo $_SESSION['actuelPage']['nom_resto']; ?></a></p>
                </div>
            </div>
        </div>
        <hr>
        <div class="footer-bottom">
            <div class="copyright">
                <p>&copy;Copyright <?php echo date('Y'); ?></p>
            </div>
            <div class="payment">
                <img src="<?php echo RACINE_SITE ?>assets/paypal.png" alt="paypal">
                <img src="<?php echo RACINE_SITE ?>assets/visa.png" alt="visa card">
                <img src="<?php echo RACINE_SITE ?>assets/maestro.png" alt="maestro card">
            </div>
        </div>
    </footer>
    <script src="<?php echo RACINE_SITE ?>inc/js/main.js"></script>
    <script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>
</body>
</html>