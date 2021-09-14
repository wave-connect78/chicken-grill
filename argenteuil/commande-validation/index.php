<?php
    require_once '../../inc/init.php';

    if(!isset($_SESSION['actuelPage'])){
        header('location:https://chicken-grill.fr/');
        exit;
    }else{
        if (!isOn()) {
            header('location:/'.$_SESSION['actuelPage']['nom_resto'].'/auth');
            exit;
        }
    }

    $title = 'Validation de la commande';

    require_once '../../inc/stripe-php/init.php';

    \Stripe\Stripe::setApiKey(STRIPE_ARGENTEUIL_API_KEY);

    $somme = 0.00;
    $commande_code = 0;
    $reference_id = '';
    $commande_detail = '';
    $onLinecommande = false;
    $email = 'chickengrill.argenteuil95@gmail.com';
    $tel = '06 21 52 65 93';

    if (isset($_SESSION['cart'])) {
        if(isset($_SESSION['sale_price'])){
            $somme = $_SESSION['sale_price'];
        }else{
           foreach ($_SESSION['cart'] as $key => $value) {
            //print_r($_SESSION['cart']);
                $somme = intval($_SESSION['cart'][$key]['quantite']) * floatval($_SESSION['cart'][$key]['prix']) + $somme;
            } 
        }
    }else {
        header('location:'.RACINE_SITE.'/'.$_SESSION['actuelPage']['nom_resto']);
    }

    /*if ($somme <= 0) {
        header('location:'.RACINE_SITE.$_SESSION['actuelPage']);
    }*/
    //print_r($_SESSION['cart']);
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
                    
                    if (isset($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $key => $value) {
                        
                            if ($key == count($_SESSION['cart'])-1) {
                                $commande_detail .= $_SESSION['cart'][$key]['product_id'].'::'.$_SESSION['cart'][$key]['product_name'].'::'.$_SESSION['cart'][$key]['quantite'].'::'.$_SESSION['cart'][$key]['product_type'].'::'.$_SESSION['cart'][$key]['commande_mode'].'::'.$_SESSION['cart'][$key]['boisson'].'::'.$_SESSION['cart'][$key]['precision'].'::'.$_SESSION['cart'][$key]['message'];
                            } else {
                                $commande_detail .= $_SESSION['cart'][$key]['product_id'].'::'.$_SESSION['cart'][$key]['product_name'].'::'.$_SESSION['cart'][$key]['quantite'].'::'.$_SESSION['cart'][$key]['product_type'].'::'.$_SESSION['cart'][$key]['commande_mode'].'::'.$_SESSION['cart'][$key]['boisson'].'::'.$_SESSION['cart'][$key]['precision'].'::'.$_SESSION['cart'][$key]['message'].'|';
                            }
                        }
                    }
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
                    if(isset($_SESSION['sale_price'])){
                        
                        if(isset($_SESSION['codepromo_update'])){
                            executeQuery("UPDATE manage_code_promo SET nb = :nb WHERE code_name =:code_name AND user_id =:user_id",array(
                                    ':nb' => intval($_SESSION['user_promo_nb']) +1,
                                    ':code_name' => $_SESSION['code_name'],
                                    ':user_id' => $_SESSION['user']['user_id']
                                ));
                                insertCommandeAndValidatePayment($transactionID,$commande_code,$commande_detail,$somme,$paidAmount,$payment_status,$paidCurrency,'Argenteuil',$tel,$email);
                        }else{
                            executeQuery("INSERT INTO manage_code_promo (user_id,nb,code_name) VALUES(:user_id,:nb,:code_name)",array(
                                    ':user_id' => $_SESSION['user']['user_id'],
                                    ':nb' => 1,
                                    ':code_name' => $_SESSION['code_name']
                                ));
                            insertCommandeAndValidatePayment($transactionID,$commande_code,$commande_detail,$somme,$paidAmount,$payment_status,$paidCurrency,'Argenteuil',$tel,$email);
                        }
                    }else{
                        insertCommandeAndValidatePayment($transactionID,$commande_code,$commande_detail,$somme,$paidAmount,$payment_status,$paidCurrency,'Argenteuil',$tel,$email);
                    }
                }
            }
        }
    }

    require_once '../../inc/header.php';
    
?>
<div class="commande">
    <div class="stripe">
        <h3>Bienvenue au processus de paiement en ligne</h3>
        <p>Pour effectuer le paiement en toute sérénité vous aurez besoin de votre numéro de carte, du code de vérification de la carte (CVC) qui se trouve derrière votre carte et la date d'expiration.</p>
        <p>Le montant est de <span style="color: rgb(14, 107, 49);font-weight:bold"><?php echo str_replace('.',',',$somme) ?>€</span></p>
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
            <button type="submit" class="btn btn-primary">Valider le paiement</button>
        </form>
    </div>
       
</div>

<script>
    let cNumber = false;
    let cvcNumber = false;
    let cExpiry = false;
    let stripe = Stripe('<?php echo STRIPE_ARGENTEUIL_PUBLIC_KEY; ?>');
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