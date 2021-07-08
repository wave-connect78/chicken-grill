<?php
    require_once '../inc/init.php';
    $decrypted_chaine = openssl_decrypt($encrypted_chaine, "AES-128-ECB" ,'chickengrill');
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
            margin: 0 auto;
        }
        body{
            display: flex;
            justify-content: center;
            align-items:center;
        }
    </style>
    <body>
        <div class="changePass">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="mdp" class="form-label">Nouveau mot de passe</label>
                    <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Nouveau mot de passe">
                </div>
                <div class="mb-3">
                    <label for="cmdp" class="form-label">Confirmation de votre mot de passe</label>
                    <input type="password" class="form-control" id="cmdp" name="cmdp" placeholder="Confirmation de votre mot de passe">
                </div>
                <button type="submit" class="btn btn-primary">Enregister</button>
            </form>
        </div>
    </body>
    </html>