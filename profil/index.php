<?php
    require_once '../inc/init.php';

    if (!isOn()) {
        header('location:'.RACINE_SITE.'auth');
        exit;
    }

    $title = 'Profil';

    require_once '../inc/header.php';


?>

<?php
    require_once '../inc/footer.php';