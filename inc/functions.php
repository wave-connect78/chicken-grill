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
