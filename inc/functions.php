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
