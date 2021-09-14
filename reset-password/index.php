<?php
    require_once '../inc/init.php';
    $decrypted_chaine = '';
    $message = '';
    //print_r($_GET);
    if(isset($_GET) && !empty($_GET)){
        $decrypted_chaine = base64_decode($_GET['tokenid']);
    }
    
    
    if(isset($_POST) && !empty($_POST)){
        if(!empty($_POST['mdp']) && !empty($_POST['cmdp']) && $_POST['mdp'] == $_POST['cmdp']){
            executeQuery("UPDATE users SET mdp = :mdp WHERE user_id =:user_id",array(
                    ':mdp' => password_hash($_POST['mdp'], PASSWORD_DEFAULT),
                    ':user_id' => $decrypted_chaine
                ));
                header('location:/'.$_SESSION['actuelPage']['nom_resto'].'/auth');
        }else{
            $message = '<p style="color:red;">Vérifier que tous les champs sont remplis et que vos deux mots de passe sont identiques</p>';
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <title>Changer le mot de passe</title>
    </head>
    <style>
        .changePass{
            width: 50%;
            margin: 50px auto;
            height:100vh;
        }
        body{
            display: flex;
            justify-content: center;
            align-items:center;
        }
    </style>
    <body>
        <div class="changePass">
            <h2 class="mb-4">Modifier votre mot de passe</h2>
            <?php echo $message; ?>
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