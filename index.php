<?php
    require_once 'inc/init.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    body{
        background-color: #FFA91E;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        margin: 0;
        padding: 0;
    }
    .container{
        width: 50%;
        text-align:center;
    }
    .logo{
        width: 100%;
    }
    .container .logo img{
        width: 100%;
    }
    .restaurant{
        display: flex;
        justify-content: center;
        margin: 20px 0;
    }
    .restaurant .restaurant-navi{
        display: flex;
        flex-direction: column;
        width: 25%;
    }
    .restaurant a{
        padding: 10px 15px;
        background-color: #fff;
        margin-bottom: 10px;
        text-decoration: none;
        color: #593207;
        border-radius: 5px;
    }
</style>
<body>
    <div class="container">
        <div class="logo"><a href="<?php echo RACINE_SITE ?>"><img src="<?php echo RACINE_SITE ?>photos/logo.png" alt=""></a></div>
        <div class="restaurant">
            <div class="restaurant-navi">
                <a href="<?php echo RACINE_SITE ?>restaurant-1">Restaurant 1</a>
                <a href="<?php echo RACINE_SITE ?>restaurant-2">Restaurant 2</a>
                <a href="<?php echo RACINE_SITE ?>restaurant-3">Restaurant 3</a>
                <a href="<?php echo RACINE_SITE ?>restaurant-4">Restaurant 4</a>
                <a href="<?php echo RACINE_SITE ?>restaurant-5">Restaurant 5</a>
            </div>
        </div>
    </div>
</body>
</html>