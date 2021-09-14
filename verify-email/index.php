<?php
    require_once '../inc/init.php';
    $decrypted_chaine = '';
    $check = false;
    //print_r($_GET);
    unset($_SESSION['user']);
    if(isset($_GET) && !empty($_GET)){
        $decrypted_chaine = base64_decode($_GET['tokenid']);
    }
    
    $resultat = executeQuery("SELECT verify FROM users WHERE user_id = :user_id AND statut = :statut",array(
            ':user_id' => $decrypted_chaine,
            ':statut' => 'client'
        ));
        
    $verify = $resultat->fetch(PDO::FETCH_ASSOC);
    
    if(!$verify['verify']){
        executeQuery("UPDATE users SET verify = :verify WHERE user_id = :user_id",array(
                ':verify' => true,
                ':user_id' => $decrypted_chaine
            ));
            $check = true;
    }
    
    if(isset($_POST) && !empty($_POST)){
        if(isset($_SESSION['actuelPage'])){
            header('location:https://chicken-grill.fr/'.$_SESSION['actuelPage']['nom_resto'].'/auth');
            exit;
        }else{
            header('location:https://chicken-grill.fr/');
            exit;
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Changer le mot de passe</title>
    </head>
    <style>
        .changePass{
            width: 50%;
            margin: 50px auto;
            height:100vh;
            text-align:center;
        }
        body{
            display: flex;
            justify-content: center;
            align-items:center;
        }
    </style>
    <body>
        <div class="changePass">
            <?php
                if($resultat->rowCount() == 0){
                    ?>
                    <p>Ce compte n'existe pas</p>
                    <?php
                }else{
                    if($verify['verify']){
                        ?>
                        <p>Votre compte a déja été vérifié</p>
                        <form action="" method="post">
                            <input type="hidden" name="hidd">
                            <button type="submit" class="btn btn-primary">Me connecter</button>
                        </form>
                        <?php
                    }else{
                        if($check){
                            ?>
                            <h2 class="mb-4">Votre email a été verifiée</h2>
                            <p>Vous pouvez dés à présent vous connecter en toute sécurité</p>
                            <form action="" method="post">
                                <input type="hidden" name="hidd">
                                <button type="submit" class="btn btn-primary">Me connecter</button>
                            </form>
                            <?php
                        }
                    }
                }
            ?>
        </div>
    </body>
    </html>