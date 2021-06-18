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

    function isResto1On(){
        if (isOn() && $_SESSION['user']['statut'] == 'admin-resto1') {
            return true;
        }else{
            return false;
        }
    }
