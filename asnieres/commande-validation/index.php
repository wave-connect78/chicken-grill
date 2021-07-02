<?php
    require_once '../../inc/init.php';

    if (!isOn()) {
        header('location:../../auth');
    }

    $title = 'Validation de la commande';

    require_once '../../inc/stripe-php/init.php';

    require_once '../../inc/fpdf/fpdf.php';

    \Stripe\Stripe::setApiKey(STRIPE_API_KEY);

    $somme = 0.00;
    $commande_code = 0;
    $reference_id = '';
    $commande_detail = '';
    $onLinecommande = false;

    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $value) {
            //print_r($_SESSION['cart']);
            $somme = intval($_SESSION['cart'][$key]['quantite']) * floatval($_SESSION['cart'][$key]['prix']) + $somme;
        }
    }

    /*if ($somme <= 0) {
        header('location:'.RACINE_SITE.$_SESSION['actuelPage']);
    }*/

    if (isset($_POST) && !empty($_POST)) {
        
        try {
            $customer = \Stripe\Customer::create(array(
              'source' => $_POST['stripeToken']
            ));
        } catch (Exception $e) {
            $api_error = $e->getMessage();
        }

        if (empty($api_error) && $customer) {
            
            try {
                $charge = \Stripe\Charge::create(array(
                    'customer' => $customer->id,
                    'amount' => $somme*100,
                    'currency' => 'eur'
                ));
            } catch (Exception $e) {
                $api_error = $e->getMessage();
            }
            if (empty($api_error) && $charge) {
                $chargeJson = $charge->jsonSerialize();
                if ($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1) {
                    $transactionID = $chargeJson['balance_transaction']; 
                    $paidAmount = $chargeJson['amount']; 
                    $paidAmount = ($paidAmount/100); 
                    $paidCurrency = $chargeJson['currency']; 
                    $payment_status = $chargeJson['status'];
                    
                    while (1) {
                        $randomNumber = rand(1000, 10000);
                        $resultat = executeQuery("SELECT * FROM commande WHERE commande_code =:commande_code",array(
                            ':commande_code' => $randomNumber
                        ));

                        if ($resultat->rowCount() < 1) {
                            $commande_code = $randomNumber;
                            break;
                        } 
                        
                    }
                    while (1) {
                        $uniqid = bin2hex(random_bytes(20));
                        $resultat = executeQuery("SELECT * FROM commande WHERE reference_id =:reference_id",array(
                            ':reference_id' => $uniqid
                        ));

                        if ($resultat->rowCount() < 1) {
                            $reference_id = $uniqid;
                            break;
                        } 
                        
                    }
                    foreach ($_SESSION['cart'] as $key => $value) {
                        //print_r($_SESSION['cart']);
                        if ($key == count($_SESSION['cart'])-1) {
                            $commande_detail .= $_SESSION['cart'][$key]['product_id'].'::'.$_SESSION['cart'][$key]['product_name'].'::'.$_SESSION['cart'][$key]['quantite'].'::'.$_SESSION['cart'][$key]['product_type'].'::'.$_SESSION['cart'][$key]['commande_mode'].'::'.$_SESSION['cart'][$key]['boisson'].'::'.$_SESSION['cart'][$key]['precision'].'::'.$_SESSION['cart'][$key]['message'];
                        } else {
                            $commande_detail .= $_SESSION['cart'][$key]['product_id'].'::'.$_SESSION['cart'][$key]['product_name'].'::'.$_SESSION['cart'][$key]['quantite'].'::'.$_SESSION['cart'][$key]['product_type'].'::'.$_SESSION['cart'][$key]['commande_mode'].'::'.$_SESSION['cart'][$key]['boisson'].'::'.$_SESSION['cart'][$key]['precision'].'::'.$_SESSION['cart'][$key]['message'].'|';
                        }
                    }
                    executeQuery("INSERT INTO commande(reference_id,user_id,commande_code,commande_detail,reference_commande,commande_statut,resto,commande_date) VALUES(:reference_id,:user_id,:commande_code,:commande_detail,:reference_commande,:commande_statut,:resto,NOW())",array(
                        ':reference_id' => $reference_id,
                        ':user_id' => $_SESSION['user']['user_id'],
                        ':commande_code' => $commande_code,
                        ':commande_detail' => $commande_detail,
                        ':reference_commande' => $commande_code.'-'.strtolower(str_replace(" ","_",$_SESSION['user']['nom'])),
                        ':commande_statut' => 'reçu',
                        ':resto' => 'asnieres'
                    ));
                    executeQuery("INSERT INTO payment(user_id,transaction_id,reference_id,amount,payment_statut,currency,resto,create_date) VALUES(:user_id,:transaction_id,:reference_id,:amount,:payment_statut,:currency,:resto,NOW())",array(
                        ':user_id' => $_SESSION['user']['user_id'],
                        ':transaction_id' => $transactionID,
                        ':reference_id' => $reference_id,
                        ':amount' => $paidAmount,
                        ':payment_statut' => $payment_status,
                        ':currency' => $paidCurrency,
                        ':resto' => 'asnieres'
                    ));
                    unset($_SESSION['cart']);
                }
            }
        }
    }

    require_once '../../inc/header.php';
    
?>
<div class="commande">
    <div class="stripe">
        <h3>Bienvenu au processus de paiement en ligne</h3>
        <p>Pour éffectuer le paiement en toute sérénité vous aurez besoin de votre numéro de carte, du cvc qui se trouve deriere votre carte et la date d'expiration.</p>
        <p>Le montant est de <span style="color:green;font-weight:bold"><?php echo $somme.' €' ?></span></p>
        <div id="card-errors" class="error mb-4"></div>
        <form action="" method="post" id="payment">
            <div class="mb-3">
                <label for="card_number" class="form-label">Numéro de votre carte</label>
                <div class="card-number"></div>
            </div>
            <div class="mb-3">
                <label for="cvc" class="form-label">CVC</label>
                <div class="cvc"></div>
            </div>
            <div class="mb-3">
                <label for="card_expiry" class="form-label">Date d'expiration</label>
                <div class="expiry"></div>
            </div>
            <button type="submit" class="btn btn-primary">Valider le payment</button>
        </form>
    </div>
       
</div>

<script>
    let cNumber = false;
    let cvcNumber = false;
    let cExpiry = false;
    let stripe = Stripe('pk_test_51J7LvEGmpSPcezX39MNC50iR9dYSZVCMiXpiDHpchXWcc2PeCbhweI5TfwSIQjVk7j6N9SJExAUaAzeV3n2GBusw00i34jq0eK');
    let elements = stripe.elements();
    let style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    let cardNumber = elements.create('cardNumber', {style: style});
    cardNumber.mount('.card-number');

    let cvc = elements.create('cardCvc', {style: style});
    cvc.mount('.cvc');

    let expiry = elements.create('cardExpiry', {style: style});
    expiry.mount('.expiry');

    cardNumber.addEventListener('change', function(event) {
        let displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
            cNumber = true;
        }
    });
    expiry.addEventListener('change', function(event) {
        let displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
            cExpiry = true;
        }
    });
    cvc.addEventListener('change', function(event) {
        let displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
            cvcNumber = true;
        }
    });

    let form = document.getElementById("payment");

    form.addEventListener("submit",function(event){
        event.preventDefault();
        createToken();
    });
    function createToken(){
        stripe.createToken(cardNumber).then(function(result){
            if(result.error){
                let displayError = document.getElementById('card-errors');
                displayError.textContent = result.error.message;
            }else{
                stripeTokenHandler(result.token);
            }
        });
    }
    function stripeTokenHandler(token){
        let hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type','hidden');
        hiddenInput.setAttribute('name','stripeToken');
        hiddenInput.setAttribute('value',token.id);
        form.appendChild(hiddenInput);
        form.submit();
    }
</script>

<?php
    require_once '../../inc/footer.php';