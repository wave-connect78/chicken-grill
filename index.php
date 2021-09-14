<?php
    require_once 'inc/init.php';
    
    $resultat = executeQuery('SELECT switch_state FROM switch WHERE resto = :resto',array(
        ':resto' => 'bezons'    
    ));
    $state = $resultat->fetch(PDO::FETCH_ASSOC);
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="X-UA-Compatible" content="IE=8,IE=9,IE=10" />
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
        margin:50px 0;
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
        margin-right: 10px;
        transition:all .1s;
        -moz-transition:all .1s;
        -webkit-transition:all .1s;
        -o-transition:all .1s;
        -ms-transition:all .1s;
    }
     .restaurant a:hover{
         box-shadow: 0px 0px 12px 4px rgba(0, 0, 0, .4);
        -moz-box-shadow: 0px 0px 12px 4px rgba(0, 0, 0, .4);
        -webkit-box-shadow: 0px 0px 12px 4px rgba(0, 0, 0, .4);
        -o-box-shadow: 0px 0px 12px 4px rgba(0, 0, 0, .4);
        -ms-box-shadow: 0px 0px 12px 4px rgba(0, 0, 0, .4);
         transform:translateY(-5px);
        -moz-transform:translateY(-5px);
        -webkit-transform:translateY(-5px);
        -o-transform:translateY(-5px);
        -ms-transform:translateY(-5px);
     }
    @media (max-width: 916px) {
        .container{
            width:60%;
        }
    }
    @media (max-width: 748px) {
        .restaurant a{
            width:55%;
        }
        .restaurant a{
            box-shadow: 0px 0px 12px 4px rgba(0, 0, 0, .4);
            -moz-box-shadow: 0px 0px 12px 4px rgba(0, 0, 0, .4);
            -webkit-box-shadow: 0px 0px 12px 4px rgba(0, 0, 0, .4);
            -o-box-shadow: 0px 0px 12px 4px rgba(0, 0, 0, .4);
            -ms-box-shadow: 0px 0px 12px 4px rgba(0, 0, 0, .4);
        }
    }
    @media (max-width: 425px) {
        .container{
            width:80%;
        }
        .restaurant a{
            width:70%;
        }
    }
    
</style>
<noscript>
    For full functionality of this site it is necessary to enable JavaScript.
    Pour un fonctionnment optimal du site, il est neccessaire d'activer Javascript sur votre navigateur.
    Ici sont <a href="https://www.enablejavascript.io/">
        des instructions comment activer Javascript sur votre navigateur.</a>.
</noscript>
<body>
    <div class="container">
        <div class="logo"><a href="https://chicken-grill.fr/"><img src="<?php echo RACINE_SITE ?>/assets/logo.png" alt=""></a></div>
        <div class="restaurant">
            <div class="restaurant-navi">
                <a href="<?php echo RACINE_SITE ?>/asnieres/home"><h3>Chicken Grill Asnières</h3><p>104, rue Émile Zola</p><p>92600 Asnières sur seine</p></a>
                <a href="<?php echo RACINE_SITE ?>/argenteuil/home"><h3>Chicken Grill Argenteuil</h3><p>149, av Jean Jaurès</p><p>95100 Argenteuil</p></a>
                <?php 
                    if(isset($state) && $state['switch_state'] == 'on'){
                        ?>
                        <a href="<?php echo RACINE_SITE ?>/bezons/home"><h3>Chicken Grill Bezons</h3><p>16, rue de Montesson</p><p>95870 Bezons</p></a>
                        <?php
                    }
                ?>
                <a href="<?php echo RACINE_SITE ?>/saint-denis/home"><h3>Chicken Grill Saint Denis</h3><p>67, rue Gabriel Péri</p><p>93200 Saint Denis</p></a>
                <a href="<?php echo RACINE_SITE ?>/epinay-seine/home"><h3>Chicken Grill Epinay/seine</h3><p>27, impasse du Noyer Bossu</p><p>93800 Epinay sur seine</p></a>
            </div>
        </div>
    </div>
</body>
</html>