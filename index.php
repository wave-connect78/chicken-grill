<?php
    require_once 'inc/init.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chicken grill</title>
</head>
<style>
    body{
        background-color: #FFA91E;
        display: flex;
        align-items: center;
        justify-content: center;
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
        flex-wrap: wrap;
        justify-content: center;
    }
    .restaurant a{
        padding: 10px 15px;
        background-color: #fff;
        margin-bottom: 10px;
        text-decoration: none;
        color: #593207;
        border-radius: 5px;
        margin-right: 10px
    }
</style>
<body>
    <div class="container">
        <div class="logo"><a href="<?php echo RACINE_SITE ?>"><img src="<?php echo RACINE_SITE ?>assets/logo.png" alt=""></a></div>
        <div class="restaurant">
            <div class="restaurant-navi">
                <a href="<?php echo RACINE_SITE ?>asnieres"><h3>Chicken Grill Asnières</h3><p>104,rue Émile Zola</p><p>92600 Asnières sur seine</p></a>
                <a href="<?php echo RACINE_SITE ?>argenteuil"><h3>Chicken Grill Argenteuil</h3><p>149,av Jean Jaurè</p><p>95100 Argenteuil</p></a>
                <a href="<?php echo RACINE_SITE ?>bezons"><h3>Chicken Grill Bezons</h3><p>16,rue de Montesson</p><p>95870 Bezons</p></a>
                <a href="<?php echo RACINE_SITE ?>saint-denis"><h3>Chicken Grill Saint Denis</h3><p>67,rue Gabriel Péri</p><p>93200 Saint Denis</p></a>
                <a href="<?php echo RACINE_SITE ?>epinay-seine"><h3>Chicken Grill Epinay/seine</h3><p>27,impasse du noyer bossu</p><p>93800 Epinay sur seine</p></a>
            </div>
        </div>
    </div>
</body>
</html>