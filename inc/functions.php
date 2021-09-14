<?php

    require_once 'fpdf/fpdf.php';
    
    class PDF extends FPDF {
      // Header
      function Header() {
        // Titre gras (B) police Helbetica de 11
        $this->SetFont('Times','B',11);
        // fond de couleur gris (valeurs en RGB)
        $this->setFillColor(230,230,230);
        $this->setFontSize(35);
         // position du coin supérieur gauche par rapport à la marge gauche (mm)
        $this->SetX(20);
        // Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok  
        $this->Cell(60,12,'FACTURE',0,1,'R',0);
        // Saut de ligne 10 mm
        $this->Image('https://chicken-grill.fr/assets/logo.png',140,10,50);
        $this->Ln(10);
      }
      // Footer
      function Footer() {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);
        // Police Arial italique 8
        $this->SetFont('Helvetica','I',9);
        // Numéro de page, centré (C)
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
        $this->SetX(20);
        $this->Cell(60,10,'Chicken-grill',0,0,'L');
        $this->SetX(130);
        $this->Cell(60,10,'https://chicken-grill.fr',0,0,'R');
      }
    }
    
    function generatePdf($pdf,$resto,$adresse,$tel,$name,$email,$usertel,$code,$transaction,$refc){
        // Nouvelle page A4 (incluant ici logo, titre et pied de page)
        define('EURO',chr(128));
        $pdf->AddPage();
        // Polices par défaut : Helvetica taille 9
        $pdf->SetFont('Helvetica','',9);
        // Couleur par défaut : noir
        $pdf->SetTextColor(0);
        // Compteur de pages {nb}
        $pdf->AliasNbPages();
        // couleur de fond de la cellule : gris clair
        $pdf->setFillColor(230,230,230);
        //$pdf->setFontSize(12);
        $pdf->SetX(20);
        $pdf->Cell(60,4,'Chicken-grill '.utf8_decode($resto),0,1,'L',0);
        $pdf->Ln(1);
        $pdf->SetX(20);
        $pdf->Cell(60,4,utf8_decode($adresse),0,1,'L',0);
        $pdf->Ln(1);
        $pdf->SetX(20);
        $pdf->Cell(60,4,$tel,0,1,'L',0);
        $pdf->Ln(10);
        $pdf->SetXY(20, 60);
        $pdf->setFontSize(15);
        $pdf->MultiCell(60,4,utf8_decode('FACTURÉ À'),0,'L',false);
        //$pdf->Cell(60,4,'FACTURE A',0,1,'L',0);
        $pdf->Ln(5); // saut de ligne 10mm
        $pdf->SetFont('Helvetica','',11);
        $pdf->SetTextColor(0);
        $pdf->SetXY(20, 69);
        $pdf->MultiCell(60,4,utf8_decode($name),0,'L',false);
        $pdf->SetXY(20, 74);
        $pdf->MultiCell(60,4,utf8_decode($email),0,'L',false);
        $pdf->SetXY(20, 79);
        $pdf->MultiCell(60,4,utf8_decode($usertel),0,'L',false);
        $pdf->SetXY(80, 60);
        $pdf->setFontSize(12);
        $pdf->MultiCell(60,4,utf8_decode('FACTURE N°'),0,'L',false);
        $pdf->SetXY(80, 68);
        $pdf->MultiCell(60,4,utf8_decode('DATE'),0,'L',false);
        $pdf->SetXY(80, 76);
        $pdf->MultiCell(60,4,utf8_decode('CODE COMMANDE'),0,'L',false);
        $pdf->SetXY(140, 60);
        $pdf->SetFont('Helvetica','',11);
        $pdf->MultiCell(60,4,rand(1, 10000),0,'L',false);
        $pdf->SetXY(140, 68);
        $pdf->MultiCell(60,4,date('d/m/Y'),0,'L',false);
        $pdf->SetXY(140, 76);
        $pdf->MultiCell(60,4,utf8_decode($code),0,'L',false);
        $pdf->SetXY(20, 95);
        $pdf->MultiCell(80,8,utf8_decode('Numero de transaction :'),0,'L',false);
        $pdf->SetXY(110, 95);
        $pdf->MultiCell(80,8,utf8_decode($transaction),0,'L',false);
        
        
        $pdf->SetXY(20, 100);
        $pdf->MultiCell(80,8,utf8_decode('Méthode de paiement : '),0,'L',false);
        $pdf->SetXY(110, 100);
        $pdf->MultiCell(60,8,utf8_decode('Paiement en ligne'),0,'L',false);
        $pdf->SetXY(20, 105);
        $pdf->MultiCell(80,8,utf8_decode('Type de carte : '),0,'L',false);
        $pdf->SetXY(110, 105);
        $pdf->MultiCell(60,8,utf8_decode('Carte de crédit'),0,'L',false);
        $pdf->SetXY(20, 110);
        $pdf->MultiCell(80,8,utf8_decode('Référence de commande :'),0,'L',false);
        $pdf->SetXY(110, 110);
        $pdf->MultiCell(60,8,utf8_decode($refc),0,'L',false);
        
        $pdf->SetXY(20, 125);
        $pdf->setFontSize(12);
        $pdf->SetDrawColor(255,0,0);
        $pdf->MultiCell(20,8,utf8_decode('QTÉ'),'TB','C',false);
        $pdf->SetXY(40, 125);
        $pdf->MultiCell(90,8,utf8_decode('DESIGNATION'),'TB','C',false);
        $pdf->SetXY(130, 125);
        $pdf->MultiCell(30,8,utf8_decode('PRIX UNIT'),'TB','C',false);
        $pdf->SetXY(160, 125);
        $pdf->MultiCell(30,8,utf8_decode('MONTANT'),'TB','C',false);
        
        $posY = 133;
        $somme = 0;
        foreach ($_SESSION['cart'] as $key => $value) {
            $pdf->SetXY(20, $posY);
            $pdf->MultiCell(20,8,$_SESSION['cart'][$key]['quantite'],0,'C',false);
            $pdf->SetXY(40, $posY);
            $pdf->MultiCell(90,8,utf8_decode($_SESSION['cart'][$key]['product_name']),0,'C',false);
            $pdf->SetXY(130, $posY);
            $pdf->MultiCell(30,8,$_SESSION['cart'][$key]['prix'].EURO,0,'C',false);
            $pdf->SetXY(160, $posY);
            $pdf->MultiCell(30,8,floatPrice($_SESSION['cart'][$key]['quantite'] * $_SESSION['cart'][$key]['prix']).EURO,0,'C',false);
            $pdf->SetXY(190, $posY);
            $posY = $posY + 8;
        }
        if(isset($_SESSION['sale_price'])){
            $somme = $_SESSION['sale_price'];
        }else{
            foreach ($_SESSION['cart'] as $key => $value) {
                $somme = intval($_SESSION['cart'][$key]['quantite']) * floatval($_SESSION['cart'][$key]['prix']) + $somme;
            } 
        }
        $pdf->SetXY(60, $posY+20);
        $pdf->setFontSize(15);
        $pdf->MultiCell(60,8,utf8_decode('SOMME TOTAL :'),0,'L',false);
        $pdf->SetXY(130, $posY+20);
        $pdf->setFontSize(15);
        $pdf->MultiCell(30,8,$somme.EURO,0,'C',false);
        $pdf->SetXY(60, $posY+30);
        $pdf->setFontSize(15);
        $pdf->MultiCell(60,8,utf8_decode('SOMME REÇU :'),0,'L',false);
        $pdf->SetXY(130, $posY+30);
        $pdf->setFontSize(15);
        $pdf->MultiCell(30,8,$somme.EURO,0,'C',false);
         $pdf->SetXY(60, $posY+40);
        $pdf->setFontSize(15);
        $pdf->MultiCell(60,8,utf8_decode('RESTE À CHARGE :'),0,'L',false);
        $pdf->SetXY(130, $posY+40);
        $pdf->setFontSize(15);
        $pdf->MultiCell(30,8,'0'.EURO,0,'C',false);
        
        $doc = $pdf->Output('facture.pdf','S');
        return $doc;
    }
    
    function verifyEmail($email){
        if (filter_var($email,FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    function executeQuery($query,$marqueur = array()){
        foreach ($marqueur as $key => $value) {
            $marqueur[$key] = htmlspecialchars($value,ENT_QUOTES);
        }

        global $pdo;

        $resultat = $pdo->prepare($query);
        $success = $resultat->execute($marqueur);
        if ($success) {
            return $resultat;
        }else {
            die('Erreur produit lors de l\'execution de la requête');
        }
    }
    
    function isOn(){
        if (!empty($_SESSION['user'])) {
            return true;
        } else {
            return false;
        }
        
    }

    function isRestoAsnieresOn(){
        if (isOn() && $_SESSION['user']['statut'] == 'admin-asnieres') {
            return true;
        }else{
            return false;
        }
    }

    function isRestoArgenteuilOn(){
        if (isOn() && $_SESSION['user']['statut'] == 'admin-argenteuil') {
            return true;
        }else{
            return false;
        }
    }

    function isRestoBezonsOn(){
        if (isOn() && $_SESSION['user']['statut'] == 'admin-bezons') {
            return true;
        }else{
            return false;
        }
    }

    function isRestoSaintDenisOn(){
        if (isOn() && $_SESSION['user']['statut'] == 'admin-saint-denis') {
            return true;
        }else{
            return false;
        }
    }

    function isRestoEpinaySeineOn(){
        if (isOn() && $_SESSION['user']['statut'] == 'admin-epinay-seine') {
            return true;
        }else{
            return false;
        }
    }
    function isSuperAdminOn(){
        if (isOn() && $_SESSION['user']['statut'] == 'super-admin') {
            return true;
        }else{
            return false;
        }
    }
    function sendMail($from,$to,$subject,$message,$check,$type,$doc){
        ini_set( 'display_errors', 1 );
        error_reporting( E_ALL );
        if ($check) {
            if($type == 'attach'){
                $filename = "facture.pdf";
                $attachment = chunk_split(base64_encode($doc));
                $separator = md5(time());
                $eol = "\r\n";
                $headers = "From: <".$from.">" . $eol;
                $headers .= "MIME-Version: 1.0" . $eol;
                $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
                $headers .= "Content-Transfer-Encoding: 7bit" . $eol;
                $headers .= "This is a MIME encoded message." . $eol;
                
                $body = "--".$separator.$eol;
                $body .= "Content-Transfer-Encoding: 7bit".$eol.$eol;
                
                // message
                $body .= "--".$separator.$eol;
                $body .= "Content-Type: text/html; charset=\"UTF-8\"".$eol;
                $body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
                $body .= $message.$eol;
                
                // attachment
                $body .= "--".$separator.$eol;
                $body .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol; 
                $body .= "Content-Transfer-Encoding: base64".$eol;
                $body .= "Content-Disposition: attachment".$eol.$eol;
                $body .= $attachment.$eol;
                $body .= "--".$separator."--";
                if (mail($to,$subject,$body, $headers)) {
                    return true;
                } else {
                    return false;
                }
            }else{
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
    
            // Créer les en-têtes de courriel
                $headers .= 'From: '.$from."\r\n".
                'Reply-To: '.$from."\r\n" .
                'X-Mailer: PHP/' . phpversion();
                if (mail($to,$subject,$message, $headers)) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/plain; charset=UTF-8' . "\r\n";

            $headers .= 'From: '.$from."\r\n".
            'Reply-To: '.$from."\r\n" .
            'X-Mailer: PHP/' . phpversion();
            if (mail($to,$subject,$message, $headers)) {
                return true;
            } else {
                return false;
            }
        }
    }
    
    function insertCommande($commande_code,$somme,$commande_detail){
        executeQuery("INSERT INTO commande(reference_id,user_id,commande_code,commande_detail,reference_commande,commande_statut,prix,resto,commande_date) VALUES(:reference_id,:user_id,:commande_code,:commande_detail,:reference_commande,:commande_statut,:prix,:resto,NOW())",array(
                ':reference_id' => 'PAIEMENT EN CAISSE',
                ':user_id' => $_SESSION['user']['user_id'],
                ':commande_code' => $commande_code,
                ':commande_detail' => $commande_detail,
                ':reference_commande' => $commande_code.'-'.strtolower(str_replace(" ","_",$_SESSION['user']['nom'])),
                ':commande_statut' => 'reçu',
                ':prix' => $somme,
                ':resto' => $_SESSION['actuelPage']['nom_resto']
            ));
        $_SESSION['confirmation']['reference_id'] = 'PAIEMENT EN CAISSE';
        $_SESSION['confirmation']['commande_code'] = $commande_code;
        $_SESSION['confirmation']['prix'] = $somme;
        $_SESSION['confirmation']['reference_commande'] = $commande_code.'-'.strtolower(str_replace(" ","_",$_SESSION['user']['nom']));
        $_SESSION['confirmation']['resto'] = $_SESSION['actuelPage']['adresse'];
        unset($_SESSION['cart']);
        unset($_SESSION['payment']);
        unset($_SESSION['sale_price']);
        unset($_SESSION['code_name']);
        unset($_SESSION['codepromo_update']);
        header('location:/'.$_SESSION['actuelPage']['nom_resto'].'/confirmation');
        exit;
    }
    
     function insertCommandeAndValidatePayment($transactionID,$commande_code,$commande_detail,$somme,$paidAmount,$payment_status,$paidCurrency,$resto,$tel,$email){
        executeQuery("INSERT INTO commande(reference_id,user_id,commande_code,commande_detail,reference_commande,commande_statut,prix,resto,commande_date) VALUES(:reference_id,:user_id,:commande_code,:commande_detail,:reference_commande,:commande_statut,:prix,:resto,NOW())",array(
                ':reference_id' => $transactionID,
                ':user_id' => $_SESSION['user']['user_id'],
                ':commande_code' => $commande_code,
                ':commande_detail' => $commande_detail,
                ':reference_commande' => $commande_code.'-'.strtolower(str_replace(" ","_",$_SESSION['user']['nom'])),
                ':commande_statut' => 'reçu',
                ':prix' => $somme,
                ':resto' => $_SESSION['actuelPage']['nom_resto']
            ));
        executeQuery("INSERT INTO payment(user_id,transaction_id,reference_id,amount,payment_statut,currency,resto,create_date) VALUES(:user_id,:transaction_id,:reference_id,:amount,:payment_statut,:currency,:resto,NOW())",array(
                ':user_id' => $_SESSION['user']['user_id'],
                ':transaction_id' => $transactionID,
                ':reference_id' => $transactionID,
                ':amount' => $paidAmount,
                ':payment_statut' => $payment_status,
                ':currency' => $paidCurrency,
                ':resto' => $_SESSION['actuelPage']['nom_resto']
            ));
            $pdf = new PDF('P','mm','A4');
            $facture = generatePdf($pdf,$resto,$_SESSION['actuelPage']['adresse'],$tel,$_SESSION['user']['nom'],$_SESSION['user']['email'],$_SESSION['user']['tel'],$commande_code,$transactionID,$commande_code.'-'.strtolower(str_replace(" ","_",$_SESSION['user']['nom'])));
            $message = '<h3>Merci pour votre commande</h3><p>Cet email est la confirmation que nous avons reçu votre commande et que nous la préparons. 
                Nous vous conseillons de vous connectez à votre compte personnelle sur <a href="https://chicken-grill.fr">chicken-grill.fr</a> afin de vérifier le statut de votre commande.</p><p>En piece jointe vous trouverez la facture correspondant a votre commande<br>Veillez penser présenter 
                votre référence de commande au guichet</p><p>À bîentôt</p> <p>Chicken grill '.$resto.'</p><p>'.$tel.'</p>';
            if(sendMail($email,$_SESSION['user']['email'],'Facture concernant votre commande',$message,true,'attach',$facture)){
                 $_SESSION['confirmation']['email'] = 'Un e-mail de confirmation de commande vous a été envoyé à votre adresse email. Pensez a vérifier vos spams si le mail n\'est pas dans votre repértoire';
            }else{
                $_SESSION['confirmation']['email'] = '';
            } 
            $_SESSION['confirmation']['transaction_id'] = $transactionID;
            $_SESSION['confirmation']['reference_id'] = 'payment';
            $_SESSION['confirmation']['commande_code'] = $commande_code;
            $_SESSION['confirmation']['prix'] = $somme;
            $_SESSION['confirmation']['reference_commande'] = $commande_code.'-'.strtolower(str_replace(" ","_",$_SESSION['user']['nom']));
            $_SESSION['confirmation']['resto'] = $_SESSION['actuelPage']['adresse'];
            unset($_SESSION['cart']);
            unset($_SESSION['sale_price']);
            unset($_SESSION['code_name']);
            unset($_SESSION['codepromo_update']);
            header('location:/'.$_SESSION['actuelPage']['nom_resto'].'/confirmation');
            exit;
        
    }
    
    function floatPrice($price){
        if(strpos($price,'.')){
            $arrarPrice = explode('.',$price);
            if(strlen($arrarPrice[1]) > 2){
                return round($price,2);
            }else{
                return $price;
            }
        }else{
            return $price;
        }
    }