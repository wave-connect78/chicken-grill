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
                    $response['success'] = 'Connexion reussit';
                    echo json_encode($response);
                }else{
                    $response['errorMdp'] = "Votre mot de passe est incorrect";
                    echo json_encode($response);
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
                    $resultat = executeQuery("INSERT INTO users (nom,email,mdp,statut,date_enregistrement) VALUES(:nom,:email,:mdp,:statut,NOW())",array(
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
            $resultat = executeQuery("SELECT * FROM users WHERE email = :email AND user_google_id = :user_google_id",array(
                ':email' => $_POST['email'],
                ':user_google_id' => $_POST['user_google_id']
            ));
            if ($resultat->rowCount() > 0) {
                $user = $resultat->fetch(PDO::FETCH_ASSOC);
                if (password_verify($_POST['mdp'],$user['mdp'])) {
                    executeQuery("UPDATE users SET nom = :nom,email =:email,date_enregistrement = NOW() WHERE user_google_id = :user_google_id",array(
                        ':nom' => $_POST['nom'],
                        ':email' => $_POST['email'],
                        ':user_google_id' => $_POST['user_google_id']
                    ));
                    $resultat = executeQuery("SELECT * FROM users WHERE email = :email AND user_google_id = :user_google_id",array(
                        ':email' => $_POST['email'],
                        ':user_google_id' => $_POST['user_google_id']
                    ));
                    $user = $resultat->fetch(PDO::FETCH_ASSOC);
                    $_SESSION['user'] = $user;
                    $response['success'] = 'Connexion reussit';
                    echo json_encode($response);
                }
            }else{
                $resultat = executeQuery("INSERT INTO users (nom,email,mdp,user_google_id,statut,date_enregistrement) VALUES(:nom,:email,:mdp,:user_google_id,:statut,NOW())",array(
                    ':nom' => $_POST['nom'],
                    ':email' => $_POST['email'],
                    ':mdp' => password_hash($_POST['mdp'], PASSWORD_DEFAULT),
                    ':user_google_id' => $_POST['user_google_id'],
                    ':statut' => 'client'
                ));
                $resultat = executeQuery("SELECT * FROM users WHERE email = :email AND user_google_id = :user_google_id",array(
                    ':email' => $_POST['email'],
                    ':user_google_id' => $_POST['user_google_id']
                ));
                $user = $resultat->fetch(PDO::FETCH_ASSOC);
                $_SESSION['user'] = $user;
                $response['success'] = 'Connexion reussit';
                echo json_encode($response);
            }
        }elseif ($_POST['postType'] == 'facebookLogin') {
            $resultat = executeQuery("SELECT * FROM users WHERE email = :email AND user_facebook_id = :user_facebook_id",array(
                ':email' => $_POST['email'],
                ':user_facebook_id' => $_POST['user_facebook_id']
            ));
            if ($resultat->rowCount() > 0) {
                $user = $resultat->fetch(PDO::FETCH_ASSOC);
                if (password_verify($_POST['mdp'],$user['mdp'])) {
                    executeQuery("UPDATE users SET nom = :nom,email =:email,date_enregistrement = NOW() WHERE user_facebook_id = :user_facebook_id",array(
                        ':nom' => $_POST['nom'],
                        ':email' => $_POST['email'],
                        ':user_facebook_id' => $_POST['user_facebook_id']
                    ));
                    $resultat = executeQuery("SELECT * FROM users WHERE email = :email AND user_facebook_id = :user_facebook_id",array(
                        ':email' => $_POST['email'],
                        ':user_facebook_id' => $_POST['user_facebook_id']
                    ));
                    $user = $resultat->fetch(PDO::FETCH_ASSOC);
                    $_SESSION['user'] = $user;
                    $response['success'] = 'Connexion reussit';
                    echo json_encode($response);
                }
            }else{
                $resultat = executeQuery("INSERT INTO users (nom,email,mdp,user_facebook_id,statut,date_enregistrement) VALUES(:nom,:email,:mdp,:user_facebook_id,:statut,NOW())",array(
                    ':nom' => $_POST['nom'],
                    ':email' => $_POST['email'],
                    ':mdp' => password_hash($_POST['mdp'], PASSWORD_DEFAULT),
                    ':user_facebook_id' => $_POST['user_facebook_id'],
                    ':statut' => 'client'
                ));
                $resultat = executeQuery("SELECT * FROM users WHERE email = :email AND user_facebook_id = :user_facebook_id",array(
                    ':email' => $_POST['email'],
                    ':user_facebook_id' => $_POST['user_facebook_id']
                ));
                $user = $resultat->fetch(PDO::FETCH_ASSOC);
                $_SESSION['user'] = $user;
                $response['success'] = 'Connexion reussit';
                echo json_encode($response);
            }
        }elseif ($_POST['postType'] == 'homeData') {
            $resultat = executeQuery("SELECT * FROM product");
            while ($single_product = $resultat->fetch(PDO::FETCH_ASSOC)) {
                $response['resultat'][] = $single_product;
            }
            echo json_encode($response);
        }elseif ($_POST['postType'] == 'cart') {
            $i = 0;
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'][$i] = $_POST;
                $response['resultat'] = $i+1;
                echo json_encode($response);
            }else {
                $i = count($_SESSION['cart']);
                $_SESSION['cart'][$i] = $_POST;
                $response['resultat'] = $i+1;
                echo json_encode($response);
            }
            
        }elseif ($_POST['postType'] == 'commande') {
            $resultat = executeQuery("SELECT u.nom,c.prix,c.reference_id,c.commande_code,c.commande_detail,c.reference_commande,c.commande_statut,c.commande_date FROM commande c INNER JOIN users u ON c.user_id = u.user_id WHERE c.resto =:resto AND c.commande_statut != :commande_statut",array(
                ':resto' => $_POST['resto'],
                ':commande_statut' => 'livré'
            ));
            if (isset($_SESSION['rowcount'])) {
                
                if ($_SESSION['rowcount'] == $resultat->rowCount()) {
                    while ($commande = $resultat->fetch(PDO::FETCH_ASSOC)) {
                        $response['resultat'][] = $commande;
                    }
                    print_r($response);
                }elseif ($_SESSION['rowcount'] < $resultat->rowCount()) {
                    while ($commande = $resultat->fetch(PDO::FETCH_ASSOC)) {
                        $response['resultat'][] = $commande;
                    }
                    $_SESSION['rowcount'] = $resultat->rowCount();
                    echo json_encode($response);
                }
            }else {
                while ($commande = $resultat->fetch(PDO::FETCH_ASSOC)) {
                    $response['resultat'][] = $commande;
                }
                
                $_SESSION['rowcount'] = $resultat->rowCount(); 
                echo json_encode($response);
            }
        }elseif ($_POST['postType'] == 'directAccess') {
            $resultat = executeQuery("SELECT u.nom,c.prix,c.reference_id,c.commande_code,c.commande_detail,c.reference_commande,c.commande_statut,c.commande_date FROM commande c INNER JOIN users u ON c.user_id = u.user_id WHERE c.resto =:resto AND c.commande_statut != :commande_statut",array(
                ':resto' => $_POST['resto'],
                ':commande_statut' => 'livré'
            ));
            while ($commande = $resultat->fetch(PDO::FETCH_ASSOC)) {
                $response['resultat'][] = $commande;
            }
            
            $_SESSION['rowcount'] = $resultat->rowCount(); 
            echo json_encode($response);
        }elseif ($_POST['postType'] == 'commandeStatutUpdate') {
            executeQuery("UPDATE commande SET commande_statut = :commande_statut WHERE commande_code = :commande_code",array(
                ':commande_statut' => $_POST['update'],
                ':commande_code' => $_POST['code']
            ));
            $response['resultat'] = 'ok';
            echo json_encode($response);
        }elseif ($_POST['postType'] == 'googleOut') {
            unset($_SESSION['user']);
            $response['resultat'] = 'ok';
            echo json_encode($response);
        }elseif ($_POST['postType'] == 'facebookOut') {
            unset($_SESSION['user']);
            $response['resultat'] = 'ok';
            echo json_encode($response);
        }elseif ($_POST['postType'] == 'clientCommande') {
            $resultat = executeQuery("SELECT * FROM commande WHERE user_id = :user_id",array(
                ':user_id' => $_POST['user_id']
            ));
            while ($clientCommande = $resultat->fetch(PDO::FETCH_ASSOC)) {
                $response['resultat'][] = $clientCommande;
            }
            echo json_encode($response);
        }elseif ($_POST['postType'] == 'clientOffer') {
            $resultat = executeQuery("SELECT * FROM product WHERE promo = :promo",array(
                ':promo' => 'en-promo'
            ));
            while ($clientCommande = $resultat->fetch(PDO::FETCH_ASSOC)) {
                $response['resultat'][] = $clientCommande;
            }
            echo json_encode($response);
        }elseif ($_POST['postType'] == 'commandeStatutUpdateLivre') {
            executeQuery("UPDATE commande SET commande_statut = :commande_statut,commande_code=:commande_code_reset WHERE commande_code = :commande_code",array(
                ':commande_statut' => $_POST['update'],
                ':commande_code' => $_POST['code'],
                ':commande_code_reset' => 1
            ));
            $response['resultat'] = 'ok';
            echo json_encode($response);
        }
    }