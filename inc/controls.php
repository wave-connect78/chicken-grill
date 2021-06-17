<?php
   //print_r($_POST);
   require_once 'init.php';
    $response = array();
    if (isset($_POST) && !empty($_POST)) {
        if ($_POST['postType'] == 'login') {
            $resultat = executeQuery("SELECT * FROM users WHERE email = :email",array(
                ':email' => $_POST['email']
            ));
            if ($resultat->rowCount() > 0) {
                $user = $resultat->fetch(PDO::FETCH_ASSOC);
                if (password_verify($_POST['mdp'],$user['mdp'])) {
                    $_SESSION['user'] = $user;
                    $reponse['success'] = 'Connexion reussit';
                    echo json_encode($reponse);
                }else{
                    $reponse['errorMdp'] = "Votre mot de passe est incorrect";
                    echo json_encode($reponse);
                }
            }else{
                $response['error'] = "Ce compte n'existe pas dans notre base de donnée";
                echo json_encode($response);
            }
            
        }elseif ($_POST['postType'] == 'sign') {
            if (verifyEmail($_POST['email'])) {
                $resultat = executeQuery("SELECT * FROM users WHERE email = :email",array(
                    ':email' => $_POST['email']
                ));
                if ($resultat->rowCount() > 0) {
                    $response['errorEmail'] = "Ce compte existe déja. Veuillez créer un aotre";
                    echo json_encode($response);
                } else {
                    $resultat = executeQuery("INSERT INTO users (nom,email,mdp,statut) VALUES(:nom,:email,:mdp,:statut)",array(
                        ':nom' => $_POST['nom'],
                        ':email' => $_POST['email'],
                        ':mdp' => password_hash($_POST['mdp'], PASSWORD_DEFAULT),
                        ':statut' => 'client'
                    ));
                    $response['success'] = 'Votre compte a été crée avec sucssé. <a href="https://localhost/chicken-grill/auth/">Connectez vous a votre compte</a>';
                    echo json_encode($response);
                }
            } else {
                $response['errorEmail'] = "Email invalide";
                echo json_encode($response);
            }
        }elseif ($_POST['postType'] == 'googleLogin') {
            $resultat = executeQuery("SELECT * FROM users WHERE email = :email",array(
                ':email' => $_POST['email']
            ));
            if ($resultat->rowCount() > 0) {
                $user = $resultat->fetch(PDO::FETCH_ASSOC);
                if (password_verify($_POST['mdp'],$user['mdp'])) {
                    $_SESSION['user'] = $user;
                    $reponse['success'] = 'Connexion reussit';
                    echo json_encode($reponse);
                }
            }else{
                $resultat = executeQuery("INSERT INTO users (nom,email,mdp,statut) VALUES(:nom,:email,:mdp,:statut)",array(
                    ':nom' => $_POST['nom'],
                    ':email' => $_POST['email'],
                    ':mdp' => password_hash($_POST['mdp'], PASSWORD_DEFAULT),
                    ':statut' => 'client'
                ));
                $resultat = executeQuery("SELECT * FROM users WHERE email = :email",array(
                    ':email' => $_POST['email']
                ));
                $user = $resultat->fetch(PDO::FETCH_ASSOC);
                $_SESSION['user'] = $user;
                $reponse['success'] = 'Connexion reussit';
                echo json_encode($reponse);
            }
        }
    }