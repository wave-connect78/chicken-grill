<?php
    
    function verifyEmail($email){
        if (filter_var($email,FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    function executeQuery($query,$marqueur = array()){
        foreach ($marqueur as $key => $value) {
            $marqueur[$key] = htmlspecialchars($value,ENT_QUOTES);
        }

        global $pdo;

        $resultat = $pdo->prepare($query);
        $success = $resultat->execute($marqueur);
        if ($success) {
            return $resultat;
        }else {
            die('Erreur produit lors de l\'execution de la requête');
        }
    }
    
    function isOn(){
        if (!empty($_SESSION['user'])) {
            return true;
        } else {
            return false;
        }
        
    }

    function isRestoAsnieresOn(){
        if (isOn() && $_SESSION['user']['statut'] == 'admin-asnieres') {
            return true;
        }else{
            return false;
        }
    }

    function isRestoArgenteuilOn(){
        if (isOn() && $_SESSION['user']['statut'] == 'admin-argenteuil') {
            return true;
        }else{
            return false;
        }
    }

    function isRestoBezonsOn(){
        if (isOn() && $_SESSION['user']['statut'] == 'admin-bezons') {
            return true;
        }else{
            return false;
        }
    }

    function isRestoSaintDenisOn(){
        if (isOn() && $_SESSION['user']['statut'] == 'admin-saint-denis') {
            return true;
        }else{
            return false;
        }
    }

    function isRestoEpinaySeineOn(){
        if (isOn() && $_SESSION['user']['statut'] == 'admin-epinay-seine') {
            return true;
        }else{
            return false;
        }
    }

    function sendMail($from,$to,$subject,$message,$headers,$check){
        ini_set( 'display_errors', 1 );
        error_reporting( E_ALL );
        if ($check) {
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Créer les en-têtes de courriel
            $headers .= 'From: '.$from."\r\n".
            'Reply-To: '.$from."\r\n" .
            'X-Mailer: PHP/' . phpversion();
        } else {
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/plain; charset=iso-8859-1' . "\r\n";

            $headers .= 'From: '.$from."\r\n".
            'Reply-To: '.$from."\r\n" .
            'X-Mailer: PHP/' . phpversion();
        }
        if (mail($to,$subject,$message, $headers)) {
            return true;
        } else {
            return false;
        }
    }