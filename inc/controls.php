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
                    if($user['verify']){
                        if($user['statut'] == 'client' || $user['statut'] == 'super-admin' ){
                            $_SESSION['user'] = $user;
                            $response['success'] = 'Connexion reussit';
                        }elseif($user['statut'] != 'client' && $user['statut'] != 'super-admin'){
                            if(strpos($user['statut'],$_SESSION['actuelPage']['nom_resto'])){
                                $_SESSION['user'] = $user;
                                $response['success'] = 'Connexion reussit';
                            }else{
                                $response['error'] = 'Vous n\'avez pas le droit de vous connecter à ce compte. Rassurer vous d\'être administrateur du restaurant '.$_SESSION['actuelPage']['nom_resto'] ;
                            }
                        }else{
                            $response['error'] = 'Veillez creer un compte svp';
                        }
                        echo json_encode($response);
                    }else{
                        $response['errorVerifyEmail'] = "Vous n'avez pas encore confirmé votre adresse mail";
                        echo json_encode($response);
                    }
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
                    $response['errorEmail'] = "Ce compte existe déja. Veuillez créer un autre";
                    echo json_encode($response);
                } else {
                    executeQuery("INSERT INTO users (nom,email,tel,mdp,statut,verify,date_enregistrement) VALUES(:nom,:email,:tel,:mdp,:statut,:verify,NOW())",array(
                        ':nom' => $_POST['nom'],
                        ':email' => $_POST['email'],
                        ':tel' => $_POST['tel'],
                        ':mdp' => password_hash($_POST['mdp'], PASSWORD_DEFAULT),
                        ':statut' => 'client',
                        ':verify' => false
                    ));
                    global $pdo;
                    $id = $pdo->lastInsertId();
                    $encrypted_chaine = base64_encode($id);
                    $from = 'asnieres@gmail.com';
                    $to = $_POST['email'];
                    $subject = 'Confirmation de votre compte';
                    $message = '<p>Bonjour</p><p>Vous venez de créer un compte chez chicken grill. Pour vous connecter, vous devez confirmer votre adresse mail. Pour cela vous devez cliquer sur le lien en dessous</p><a href="https://chicken-grill.fr/verify-email/?tokenid='.$encrypted_chaine.'">Confirmer votre adresse mail</a><p>Au cas ou ce lien ne fonctionne pas, cliquer directement sur url en dessous</p><a href="https://chicken-grill.fr/verify-email/?tokenid='.$encrypted_chaine.'">https://chicken-grill.fr/verify-email/?tokenid='.$encrypted_chaine.'</a><p>Cordialement<p><p>Chicken grill</p>';
                    if (sendMail($from,$to,$subject,$message,true,'','')) {
                        $response['success'] = 'Vous avez réçu un email de confirmation. Vous devez confirmer votre adresse mail avant de vous connecter. Pensez a vérifier vos spams si le mail n\'est pas dans votre repértoire';
                        echo json_encode($response);
                    } else {
                        $response['resultat'] = 'errorMail';
                        echo json_encode($response);
                    }
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
        }elseif ($_POST['postType'] == 'homeData' || $_POST['postType'] == 'search') {
            $resultat = executeQuery("SELECT * FROM product");
            while ($single_product = $resultat->fetch(PDO::FETCH_ASSOC)) {
                $response['resultat'][] = $single_product;
            }
            if( $_POST['postType'] == 'search'){
                $response['resto'] = $_SESSION['actuelPage']['nom_resto'];
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
                        //$response['resultat'][] = $commande;
                    }
                    //print_r($response);
                    $response['nocommande'] = '';
                    echo json_encode($response);
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
        }elseif ($_POST['postType'] == 'emailContact') {
            if (verifyEmail($_POST['email'])) {
                $from = $_POST['email'];
                $to = $_POST['destination'];
                $subject = $_POST['objet'];
                $message = $_POST['message'];
                if (sendMail($from,$to,$subject,$message,false,'','')) {
                    $response['resultat'] = 'Votre méssage à été envoyé avec sucéss nous vous repondrons dans les plus brefs delais.';
                    echo json_encode($response);
                } else {
                    $response['resultat'] = 'messageError';
                    echo json_encode($response);
                }
            } else {
                $response['resultat'] = 'emailError';
                echo json_encode($response);
            }
        }elseif ($_POST['postType'] == 'renitializePass') {
            //print_r($_POST);
            if (verifyEmail($_POST['emailV'])) {
                $resultat = executeQuery("SELECT * FROM users WHERE email = :email",array(
                    ':email' => $_POST['emailV']
                ));
                if ($resultat->rowCount() == 0) {
                    $response['resultat'] = 'noPresent';
                    echo json_encode($response);
                } else {
                    $user = $resultat->fetch(PDO::FETCH_ASSOC);
                    $encrypted_chaine = base64_encode($user['user_id']);
                    $from = 'asnieres@gmail.com';
                    $to = $_POST['emailV'];
                    $subject = 'Rénitialisation de votre mot de passe';
                    $message = '<p>Bonjour</p><p>Vous avez demandez le changement de votre mot de passe. Vous n\'avez qu\'a cliquer sur le lien ci-dessous pour modifier votre mot de passe</p><a href="https://chicken-grill.fr/reset-password/?tokenid='.$encrypted_chaine.'">Modifier le mot de passe</a><p>Si ca ne fonctionne pas, cliquer directement sur le lien en dessous</p><a href="https://chicken-grill.fr/reset-password/?tokenid='.$encrypted_chaine.'">https://chicken-grill.fr/reset-password/?tokenid='.$encrypted_chaine.'</a><p>Cordialement<p><p>Chicken grill</p>';
                    if (sendMail($from,$to,$subject,$message,true,'','')) {
                        $response['resultat'] = 'Veillez consulter votre adresse email vous avez reçu un méssage. Pensez a vérifier vos spams si le mail n\'est pas dans votre repértoire';
                        echo json_encode($response);
                    } else {
                        $response['resultat'] = 'messageError';
                        echo json_encode($response);
                    }
                }
            } else {
                $response['resultat'] = 'emailError';
                echo json_encode($response);
            }
        }elseif ($_POST['postType'] == 'telAdd') {
            executeQuery("UPDATE users SET tel = :tel WHERE user_id = :user_id",array(
                    ':tel' => $_POST['tel'],
                    ':user_id' => $_SESSION['user']['user_id']
                ));
            $response['resultat'] = 'Le numéro de téléphone a été ajouté/modifié.';
            echo json_encode($response);
        }elseif ($_POST['postType'] == 'updateMdpProdil') {
            executeQuery("UPDATE users SET mdp = :mdp WHERE user_id = :user_id",array(
                    ':mdp' => password_hash($_POST['mdp'], PASSWORD_DEFAULT),
                    ':user_id' => $_SESSION['user']['user_id']
                ));
            $response['resultat'] = 'Votre mot de passe a été modifié.';
            echo json_encode($response);
        }elseif ($_POST['postType'] == 'changeEmail') {
            if(verifyEmail($_POST['email'])){
                executeQuery("UPDATE users SET email = :email, verify = :verify WHERE user_id = :user_id",array(
                    ':email' => $_POST['email'],
                    ':verify' => false,
                    ':user_id' => $_SESSION['user']['user_id']
                ));
                $encrypted_chaine = base64_encode($_SESSION['user']['user_id']);
                $from = 'asnieres@gmail.com';
                $to = $_POST['email'];
                $subject = 'Confirmation de votre adresse mail';
                $message = '<p>Bonjour</p><p>Vous venez de demander le changement de votre adresse electronique. Pour cela vous devez cliquer sur le lien en dessous pour que votre compte soit confirmé.</p><a href="https://chicken-grill.fr/verify-email/?tokenid='.$encrypted_chaine.'">Confirmer votre adresse mail</a><p>Au cas ou ce lien ne fonctionne pas, cliquer directement sur url en dessous</p><a href="https://chicken-grill.fr/verify-email/?tokenid='.$encrypted_chaine.'">https://chicken-grill.fr/verify-email/?tokenid='.$encrypted_chaine.'</a><p>Cordialement<p><p>Chicken grill</p>';
                if (sendMail($from,$to,$subject,$message,true,'','')) {
                    $response['resultat'] = 'Vous devez impérativement confirmer votre adresse mail car dans le cas contraire, vous n\'aurez plus accés à votre compte. Pensez a vérifier vos spams si le mail n\'est pas dans votre repértoire';
                    echo json_encode($response);
                } else {
                    $response['resultat'] = 'messageError';
                    echo json_encode($response);
                }
            }else{
                $response['resultat'] = 'emailError';
                echo json_encode($response);
            }
        }elseif ($_POST['postType'] == 'historyData') {
            $limit = $_POST['limit'];
            $resultat = executeQuery("SELECT u.nom,c.prix,c.reference_commande,c.commande_detail,c.commande_statut,c.commande_date FROM commande c INNER JOIN users u ON c.user_id = u.user_id WHERE c.resto =:resto LIMIT $limit, 10",array(
                ':resto' => $_POST['resto'],
            ));
            while ($commande = $resultat->fetch(PDO::FETCH_ASSOC)) {
                $response['resultat'][] = $commande;
            }
            echo json_encode($response);
        }elseif ($_POST['postType'] == 'codepromo') {
            if(!isset($_POST['code_name'])){
                $resultat = executeQuery("SELECT * FROM code_promo WHERE resto=:resto",array(
                    ':resto' => $_POST['resto']
                ));
                while ($code = $resultat->fetch(PDO::FETCH_ASSOC)) {
                    $response['resultat'][] = $code;
                }
            }else{
                $resultat = executeQuery("SELECT * FROM code_promo WHERE code_name =:code_name",array(
                ':code_name' => $_POST['code_name']
                ));
                if($resultat->rowCount() == 0){
                    executeQuery("INSERT INTO code_promo(code_name,expiry_date,pourcentage,nb,resto) VALUES(:code_name,:expiry_date,:pourcentage,:nb,:resto)",array(
                            ':code_name' => $_POST['code_name'],
                            ':expiry_date' => $_POST['expiry_date'],
                            ':pourcentage' => $_POST['pourcentage'],
                            ':nb' => $_POST['nb'],
                            ':resto' => $_POST['resto']
                        ));
                    $response['resultat'] = 'Le code promo à été ajouté';
                }else{
                    $response['resultat'] = 'codeNameError';
                }
            }
            echo json_encode($response);
            
        }elseif ($_POST['postType'] == 'clientData') {
            $limit = $_POST['limit'];
            $resultat = executeQuery("SELECT u.nom,u.email,u.tel,u.statut,u.verify,u.date_enregistrement,u.user_google_id,u.user_facebook_id, COUNT(c.user_id) AS nbCommande FROM users u LEFT JOIN commande c ON u.user_id = c.user_id GROUP BY u.user_id LIMIT $limit, 10");
            while ($client = $resultat->fetch(PDO::FETCH_ASSOC)) {
                $response['resultat'][] = $client;
            }
            echo json_encode($response);
        }elseif ($_POST['postType'] == 'nbCommande') {
            if(isset($_POST['startdate']) && isset($_POST['enddate'])){
                $resultat = executeQuery("SELECT c.resto, COUNT(c.commande_id) AS nbCommande FROM commande c WHERE c.commande_date BETWEEN :startdate AND :enddate GROUP BY c.resto",array(
                    ':startdate' => $_POST['startdate'],
                    ':enddate' => $_POST['enddate']
                ));
                while ($client = $resultat->fetch(PDO::FETCH_ASSOC)) {
                    $response['resultat'][] = $client;
                }
            }else{
                $resultat = executeQuery("SELECT c.resto, COUNT(c.commande_id) AS nbCommande FROM commande c GROUP BY c.resto");
                while ($client = $resultat->fetch(PDO::FETCH_ASSOC)) {
                    $response['resultat'][] = $client;
                } 
            }
            echo json_encode($response);
        }elseif ($_POST['postType'] == 'prixCaisse') {
            if(isset($_POST['startdate']) && isset($_POST['enddate'])){
                $resultat = executeQuery('SELECT c.resto, SUM(c.prix) AS prix FROM commande c WHERE c.reference_id = "PAIEMENT EN CAISSE" AND c.commande_statut = "livré" AND c.commande_date BETWEEN :startdate AND :enddate GROUP BY c.resto',array(
                    ':startdate' => $_POST['startdate'],
                    ':enddate' => $_POST['enddate']
                ));
                while ($client = $resultat->fetch(PDO::FETCH_ASSOC)) {
                    $response['resultat'][] = $client;
                }
            }else{
                $resultat = executeQuery('SELECT c.resto, SUM(c.prix) AS prix FROM commande c WHERE c.reference_id = "PAIEMENT EN CAISSE" AND c.commande_statut = "livré" GROUP BY c.resto');
                while ($client = $resultat->fetch(PDO::FETCH_ASSOC)) {
                    $response['resultat'][] = $client;
                }  
            }
            echo json_encode($response);
        }elseif ($_POST['postType'] == 'onlinePayment') {
            if(isset($_POST['startdate']) && isset($_POST['enddate'])){
                $resultat = executeQuery('SELECT c.resto, SUM(c.prix) AS prix FROM commande c WHERE c.reference_id != "PAIEMENT EN CAISSE" AND c.commande_statut = "livré" AND c.commande_date BETWEEN :startdate AND :enddate GROUP BY c.resto',array(
                    ':startdate' => $_POST['startdate'],
                    ':enddate' => $_POST['enddate']
                ));
                while ($client = $resultat->fetch(PDO::FETCH_ASSOC)) {
                    $response['resultat'][] = $client;
                }
            }else{
                $resultat = executeQuery('SELECT c.resto, SUM(c.prix) AS prix FROM commande c WHERE c.reference_id != "PAIEMENT EN CAISSE" AND c.commande_statut = "livré" GROUP BY c.resto');
                while ($client = $resultat->fetch(PDO::FETCH_ASSOC)) {
                    $response['resultat'][] = $client;
                }  
            }
            echo json_encode($response);
        }elseif ($_POST['postType'] == 'sommetatal') {
            if(isset($_POST['startdate']) && isset($_POST['enddate'])){
                $resultat = executeQuery('SELECT c.resto, SUM(c.prix) AS prix FROM commande c WHERE c.commande_statut = "livré" AND c.commande_date BETWEEN :startdate AND :enddate GROUP BY c.resto',array(
                    ':startdate' => $_POST['startdate'],
                    ':enddate' => $_POST['enddate']
                ));
                while ($client = $resultat->fetch(PDO::FETCH_ASSOC)) {
                    $response['resultat'][] = $client;
                }
            }else{
                $resultat = executeQuery('SELECT c.resto, SUM(c.prix) AS prix FROM commande c WHERE c.commande_statut = "livré" GROUP BY c.resto');
                while ($client = $resultat->fetch(PDO::FETCH_ASSOC)) {
                    $response['resultat'][] = $client;
                }  
            }
            echo json_encode($response);
        }elseif ($_POST['postType'] == 'totaux') {
            if(isset($_POST['startdate']) && isset($_POST['enddate'])){
                $resultat = executeQuery('SELECT SUM(c.prix) AS prix FROM commande c WHERE c.commande_statut = "livré" AND c.commande_date BETWEEN :startdate AND :enddate',array(
                    ':startdate' => $_POST['startdate'],
                    ':enddate' => $_POST['enddate']
                ));
                while ($client = $resultat->fetch(PDO::FETCH_ASSOC)) {
                    $response['resultat'][] = $client;
                }
            }else{
                $resultat = executeQuery('SELECT SUM(c.prix) AS prix FROM commande c WHERE c.commande_statut = "livré"');
                while ($client = $resultat->fetch(PDO::FETCH_ASSOC)) {
                    $response['resultat'][] = $client;
                }
            }
            echo json_encode($response);
        }elseif ($_POST['postType'] == 'becommeFranchise') {
            if (verifyEmail($_POST['email'])) {
                
                $from = $_POST['email'];
                $to = $_POST['destination'];
                $subject = 'Demande de franchise';
                $message = '<p>Mon nom est <br>'.$_POST['nom'].'</p><p>'.$_POST['message'].'</p><p>Mon adresse est le suivant<br>'.$_POST['adresse'].'</p>';
                if (sendMail($from,$to,$subject,$message,true,'','')) {
                    $response['resultat'] = 'Votre méssage à été envoyé. Nous reviendrons vers vous dans les plus bref délais!';
                    echo json_encode($response);
                } else {
                    $response['resultat'] = 'messageError';
                    echo json_encode($response);
                }
                
            } else {
                $response['resultat'] = 'emailError';
                echo json_encode($response);
            }
        }elseif ($_POST['postType'] == 'switch') {
            if(isset($_SESSION['actuelPage'])){
                if(isRestoAsnieresOn() && $_SESSION['actuelPage']['nom_resto'] != 'asnieres' || isRestoArgenteuilOn() && $_SESSION['actuelPage']['nom_resto'] != 'argenteuil' || isRestoBezonsOn() && $_SESSION['actuelPage']['nom_resto'] != 'bezons' || isRestoSaintDenisOn() && $_SESSION['actuelPage']['nom_resto'] != 'saint-denis' || isRestoEpinaySeineOn() && $_SESSION['actuelPage']['nom_resto'] != 'epinay-seine'){
                    $response['error'] = 'Vous n\'êtes pas l\'administrateur du restaurant '.$_SESSION['actuelPage']['nom_resto'].'. Veillez changer de restaurant';
                }else{
                    executeQuery('UPDATE switch SET switch_state = :state WHERE resto = :resto',array(
                        ':state' => $_POST['state'],
                        ':resto' => $_SESSION['actuelPage']['nom_resto']
                    ));
                    $response['resultat'] = 'success';
                }
            }else{
                $response['errorpage'] = 'https://chicken-grill.fr/';
            }
            
            echo json_encode($response);
        }elseif ($_POST['postType'] == 'codepromo') {
            $resultat = executeQuery('SELECT * FROM ');
        }
    }