<?php
   //print_r($_POST);
   require_once 'init.php';
    $response = array();
    if (isset($_POST) && !empty($_POST)) {
        if ($_POST['postType'] == 'login') {
            $response['response'] = "status ok";
            echo json_encode($response);
        }elseif ($_POST['postType'] == 'sign') {
            if (verifyEmail($_POST['email'])) {
                $response['success'] = 'Votre compte a été crée avec sucssé. <a href="https://localhost/chicken-grill/auth/">Connectez vous a votre compte</a>';
                echo json_encode($response);
            } else {
                $response['errorEmail'] = "Email invalide";
                echo json_encode($response);
            }
            
            //$response['response'] = "sign status ok";
            //echo json_encode($response);
        }
    }