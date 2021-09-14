<?php
    require_once '../../inc/init.php';
    $title = 'Condition générale de vente';
    $email = 'chickengrill.bezons@gmail.com';
    $tel = '01 71 67 75 41';
    if(!isset($_SESSION['actuelPage'])){
        header('location:https://chicken-grill.fr/');
        exit;
    }
    require_once '../../inc/header.php'

?>
<div class="cgv">
    <h3>CGV Click &amp; Collect</h3>
    <h5>Préambule</h5>
    <p>Le site Internet www.chicken-grill.fr est un service de : </p>
    <ul>
        <li>La société KTBR</li>
        <li>située 104 RUE EMILE ZOLA 92600 ASNIERES-SUR-SEINE, </li>
        <li>adresse URL du site : https://www.chicken-grill.fr</li>
        <li>e-mail : chickengrill.ktbr@gmail.com</li>
    </ul>
    <p>Le site Internet <a href="https://www.chicken-grill.fr">https://www.chicken-grill.fr</a> commercialise les produits choisis et distribués par KTBR. Le client déclare avoir pris connaissance et avoir accepté les conditions générales de vente antérieurement à la passation de sa commande. La validation de la commande vaut donc acceptation des conditions générales de vente.
    </p>
    <h5>Article 1 - Principes</h5>
    <p>Les présentes conditions générales expriment l'intégralité des obligations des parties. En ce sens, l'acheteur est réputé les accepter sans réserve.<br>Les présentes conditions générales de vente s'appliquent à l'exclusion de toutes autres conditions, et notamment celles applicables pour les ventes en magasin ou au moyen d'autres circuits de distribution et de commercialisation.<br>Elles sont accessibles sur le site internet Chicken Grill et prévaudront, le cas échéant, sur toute autre version ou tout autre document contradictoire.<br>Le vendeur et l'acheteur conviennent que les présentes conditions générales régissent exclusivement leur relation. Le vendeur se réserve le droit de modifier ponctuellement ses conditions générales. Elles seront applicables dès leur mise en ligne.<br>Si une condition de vente venait à faire défaut, elle serait considérée être régie par les usages en vigueur dans le secteur de la vente à distance dont les sociétés ont leur siège en France.<br>Les présentes conditions générales de vente sont valables pendant toute la durée de la mise en ligne des produits proposés par <strong>KTBR</strong>.</p>
    <h5>Article 2 - Contenu</h5>
    <p>Les présentes conditions générales ont pour objet de définir les droits et obligations des parties dans le cadre de la vente en ligne de produits proposés par le vendeur à l'acheteur, à partir du site internet Chicken Grill. Les présentes conditions ne concernent que les achats effectués sur le site et distribués par <strong>KTBR</strong>.</p>
    <h5>Article 3 - Informations précontractuelles</h5>
    <p>L'acheteur reconnaît avoir eu communication, préalablement à la passation de sa commande et à la conclusion du contrat, d'une manière lisible et compréhensible, des présentes conditions générales de vente et de toutes les informations listées à l'article L. 221-5 du code de la consommation.<br>Sont transmises à l'acheteur, de manière claire et compréhensible, les informations suivantes :</p>
    <ul>
        <li>les caractéristiques essentielles des produits ;</li>
        <li>le prix du produit et/ou le mode de calcul du prix ;</li>
        <li>la date ou le délai auquel le vendeur s'engage à rendre le produit disponible ;</li>
        <li>les informations relatives à l'identité du vendeur, à ses coordonnées postales, téléphoniques et électroniques, les informations relatives à l'identité du vendeur, à ses coordonnées postales, téléphoniques et électroniques, </li>
    </ul>
    <h5>Article 4 - La commande</h5>
    <p>L'acheteur a la possibilité de passer sa commande en ligne et au moyen du formulaire qui y figure, pour tout produit, dans la limite des stocks disponibles.<br>L'acheteur sera informé de toute indisponibilité du produit commandé.<br>Pour que la commande soit validée, l'acheteur devra accepter, en cliquant à l'endroit indiqué, les présentes conditions générales. Il devra valider le mode de paiement.<br>La vente sera considérée comme définitive :</p>
    <ul>
        <li>après l'envoi à l'acheteur de la confirmation de l'acceptation de la commande par le vendeur par courrier électronique ;</li>
        <li>et après encaissement par le vendeur de l'intégralité du prix.</li>
    </ul>
    <p>Toute commande vaut acceptation des prix et de la description des produits disponibles à la vente. Toute contestation sur ce point interviendra dans le cadre d'un éventuel échange et des garanties ci-dessous mentionnées.</p>
    <p>Pour toute question relative au suivi d'une commande, l'acheteur peut appeler le numéro de téléphone suivant : (coût d'un appel local), aux jours et horaires suivants : du lundi au dimanche de 11H30 à 21h30, ou envoyer un mail au vendeur à l’adresse mail suivante : chickengrill.ktbr@gmail.com.</p>
    <h5>Article 6 - Confirmation de commande par le vendeur</h5>
    <p>Le vendeur fournit à l'acheteur une confirmation de commande, par messagerie électronique.<br>La commande est alors ferme et définitive, et le Client peut procéder au retrait des produits dans les conditions fixées lors de la vente.<br>Il est vivement recommandé au Client de conserver cet email d'accusé de réception précisant notamment la référence de la commande. </p>
    <h5>Article 7 - Preuve de la transaction</h5>
    <p>Les registres informatisés, conservés dans les systèmes informatiques du vendeur dans des conditions raisonnables de sécurité, seront considérés comme les preuves des communications, des commandes et des paiements intervenus entre les parties. L'archivage des bons de commande et des factures est effectué sur un support fiable et durable pouvant être produit à titre de preuve.</p>
    <h5>Article 8 - Informations sur les produits</h5>
    <p>Les produits régis par les présentes conditions générales sont ceux qui figurent sur le site internet du vendeur. Ils sont proposés dans la limite des stocks disponibles.<br>Les produits sont décrits et présentés avec la plus grande exactitude possible. Toutefois, si des erreurs ou omissions ont pu se produire quant à cette présentation, la responsabilité du vendeur ne pourrait être engagée.<br>Les photographies des produits ne sont pas contractuelles.</p>
    <h5>Article 9 - Prix</h5>
    <p>Le vendeur se réserve le droit de modifier ses prix à tout moment mais s'engage à appliquer les tarifs en vigueur indiqués au moment de la commande, sous réserve de disponibilité à cette date.<br>Les prix sont indiqués en euros. Les prix tiennent compte de la TVA applicable au jour de la commande et tout changement du taux applicable TVA sera automatiquement répercuté sur le prix des produits de la boutique en ligne.<br>Si une ou plusieurs taxes ou contributions, notamment environnementales, venaient à être créées ou modifiées, en hausse comme en baisse, ce changement pourra être répercuté sur le prix de vente des produits.</p>
    <h5>Article 10 - Mode de paiement</h5>
    <p>Il s'agit d'une commande avec obligation de paiement, ce qui signifie que la passation de la commande implique un règlement de l'acheteur.<br>Pour régler sa commande, l'acheteur dispose, à son choix, de l'ensemble des modes de paiement mis à sa disposition par le vendeur et listés sur le site du vendeur. L'acheteur garantit au vendeur qu'il dispose des autorisations éventuellement nécessaires pour utiliser le mode de paiement choisi par lui, lors de la validation du bon de commande. Le vendeur se réserve le droit de suspendre toute gestion de commande et toute mise à disposition en cas de refus d'autorisation de paiement par carte bancaire de la part des organismes officiellement accrédités ou en cas de non-paiement.<br>Le paiement du prix s'effectue en totalité au jour de la commande, selon les modalités suivantes :</p>
    <ul>
        <li>carte bancaire </li>
        <li>paypal</li>
    </ul>
    <h5>Article 11 - Disponibilité des produits - Remboursement - Résolution</h5>
    <p>Sauf en cas de force majeure ou lors des périodes de fermeture de la boutique en ligne qui seront clairement annoncées sur la page d'accueil du site, les délais de mise à disposition seront, dans la limite des stocks disponibles, ceux indiqués à l'acheteur au moment de la vente. <br>En cas d'indisponibilité du produit commandé, l'acheteur en sera informé au plus tôt et aura la possibilité d'annuler sa commande. L'acheteur aura alors le choix de demander soit le remboursement des sommes versées dans les 14 jours au plus tard de leur versement, soit l'échange du produit.</p>
    <h5>Article 12 - Modalités de mise à disposition des produits</h5>
    <p>Les produits commandés sont disponibles selon les modalités et le délai précisés lors de la commande en ligne.<br>Les produits sont mis à disposition à l'adresse indiquée par l'acheteur lors de la commande. L'acheteur peut, à sa demande, obtenir l'envoi d'une facture à l'adresse de facturation.</p>
    <h5>Article 13 - Droit de rétractation</h5>
    <p>Selon les dispositions de l'article L121-20-2 3° du Code de la Consommation, le droit de rétractation applicable en matière de vente à distance ne peut être exercé dans le cas de la fourniture de biens qui du fait de leur nature sont susceptibles de se détériorer ou de se périmer rapidement.<br>En application de ce texte, il est expressément indiqué que toute Commande sur le Site est ferme et définitive et que l'exercice du droit de rétractation est exclu.<br>Les Commandes qui ont donc été définitivement validées, payées et retirées ne sont pas annulables. Aucune marchandise ne peut être reprise ou échangée.</p>
    <h5>Article 14 - Propriété intellectuelle</h5>
    <p>Le contenu du site internet reste la propriété du vendeur, seul titulaire des droits de propriété intellectuelle sur ce contenu.<br>Les acheteurs s'engagent à ne faire aucun usage de ce contenu ; toute reproduction totale ou partielle de ce contenu est strictement interdite et est susceptible de constituer un délit de contrefaçon.</p>
    <h5>Article 15 - Informatiques et Libertés</h5>
    <p>Les données nominatives fournies par l'acheteur sont nécessaires au traitement de sa commande et à l'établissement des factures.<br>Elles peuvent être communiquées aux partenaires du vendeur chargés de l'exécution, du traitement, de la gestion et du paiement des commandes.<br>Le traitement des informations communiquées par l'intermédiaire du site internet Chicken Grill a fait l'objet d'une déclaration auprès de la CNIL.<br>L'acheteur dispose d'un droit d'accès permanent, de modification, de rectification et d'opposition s'agissant des informations le concernant. Ce droit peut être exercé dans les conditions et selon les modalités définies sur le site Chicken Grill.</p>
    <h5>Article 16 - Langue du contrat</h5>
    <p>Les présentes conditions générales de vente sont rédigées en langue française. Dans le cas où elles seraient traduites en une ou plusieurs langues étrangères, seul le texte français ferait foi en cas de litige.</p>
    <h5>Article 17 - Médiation et règlement des litiges</h5>
    <p>L'acheteur peut recourir à une médiation conventionnelle, notamment auprès de la Commission de la médiation de la consommation ou auprès des instances de médiation sectorielles existantes, ou à tout mode alternatif de règlement des différends (conciliation, par exemple) en cas de contestation. Les noms, coordonnées et adresse électronique du médiateur sont disponibles sur notre site.<br>Conformément à l’article 14 du Règlement (UE) n°524/2013, la Commission Européenne a mis en place une plateforme de Règlement en Ligne des Litiges, facilitant le règlement indépendant par voie extrajudiciaire des litiges en ligne entre consommateurs et professionnels de l’Union européenne. Cette plateforme est accessible au lien suivant : <a href="https://webgate.ec.europa.eu/odr/">https://webgate.ec.europa.eu/odr/</a>.</p>
    <h5>Article 18 - Loi applicable</h5>
    <p>Les présentes conditions générales sont soumises à l'application du droit français. Le tribunal compétent est le tribunal judiciaire.<br>Il en est ainsi pour les règles de fond comme pour les règles de forme. En cas de litige ou de réclamation, l'acheteur s'adressera en priorité au vendeur pour obtenir une solution amiable.</p>
    <h5>Article 19 - Protection des données personnelles</h5>
    <h5 class="underline-text">Données collectées</h5>
    <p>Les données à caractère personnel qui sont collectées sur ce site sont les suivantes :</p>
    <ul>
        <li><strong>ouverture de compte </strong> : lors de la création du compte de l'utilisateur, ses nom ; prénom ; adresse électronique ; n° de téléphone ; adresse postale ;</li>
        <li><strong>connexion</strong> : lors de la connexion de l'utilisateur au site web, celui-ci enregistre, notamment, ses nom, prénom, données de connexion, d'utilisation, de localisation et ses données relatives au paiement ;</li>
        <li><strong>profil</strong> : l'utilisation des prestations prévues sur le site web permet de renseigner un profil, pouvant comprendre une adresse et un numéro de téléphone ;</li>
        <li><strong>paiement</strong> : dans le cadre du paiement des produits et prestations proposés sur le site web, celui-ci enregistre des données financières relatives au compte bancaire ou à la carte de crédit de l'utilisateur ;</li>
        <li><strong>communication</strong> : lorsque le site web est utilisé pour communiquer avec d'autres membres, les données concernant les communications de l'utilisateur font l'objet d'une conservation temporaire ;</li>
        <li><strong>cookies</strong> : les cookies sont utilisés, dans le cadre de l'utilisation du site. L'utilisateur a la possibilité de désactiver les cookies à partir des paramètres de son navigateur.</li>
    </ul>
    <h5 class="underline-text">Utilisation des données personnelles</h5>
    <p>Les données personnelles collectées auprès des utilisateurs ont pour objectif la mise à disposition des services du site web, leur amélioration et le maintien d'un environnement sécurisé. Plus précisément, les utilisations sont les suivantes :</p>
    <ul>
        <li>accès et utilisation du site web par l'utilisateur ;</li>
        <li>gestion du fonctionnement et optimisation du site web ;</li>
        <li>organisation des conditions d'utilisation des Services de paiement ;</li>
        <li>vérification, identification et authentification des données transmises par l'utilisateur ;</li>
        <li>proposition à l'utilisateur de la possibilité de communiquer avec d'autres utilisateurs du site web ;</li>
        <li>mise en œuvre d'une assistance utilisateurs ;</li>
        <li>personnalisation des services en affichant des publicités en fonction de l'historique de navigation de l'utilisateur, selon ses préférences ;</li>
        <li>prévention et détection des fraudes, malwares (malicious softwares ou logiciels malveillants) et gestion des incidents de sécurité ;</li>
        <li>gestion des éventuels litiges avec les utilisateurs ;</li>
        <li>envoi d'informations commerciales et publicitaires, en fonction des préférences de l'utilisateur.</li>
    </ul>
    <h5 class="underline-text">Partage des données personnelles avec des tiers</h5>
    <p>Les données personnelles peuvent être partagées avec des sociétés tierces, dans les cas suivants :</p>
    <ul>
        <li>lorsque l'utilisateur utilise les services de paiement, pour la mise en œuvre de ces services, le site web est en relation avec des sociétés bancaires et financières tierces avec lesquelles elle a passé des contrats ;</li>
        <li>lorsque l'utilisateur publie, dans les zones de commentaires libres du site web, des informations accessibles au public ;</li>
        <li>lorsque l'utilisateur autorise le site web d'un tiers à accéder à ses données ;</li>
        <li>lorsque le site web recourt aux services de prestataires pour fournir l'assistance utilisateurs, la publicité et les services de paiement. Ces prestataires disposent d'un accès limité aux données de l'utilisateur, dans le cadre de l'exécution de ces prestations, et ont une obligation contractuelle de les utiliser en conformité avec les dispositions de la réglementation applicable en matière protection des données à caractère personnel ;</li>
        <li>si la loi l'exige, le site web peut effectuer la transmission de données pour donner suite aux réclamations présentées contre le site web et se conformer aux procédures administratives et judiciaires ;</li>
        <li>si le site web est impliquée dans une opération de fusion, acquisition, cession d'actifs ou procédure de redressement judiciaire, elle pourra être amenée à céder ou partager tout ou partie de ses actifs, y compris les données à caractère personnel. Dans ce cas, les utilisateurs seraient informés, avant que les données à caractère personnel ne soient transférées à une tierce partie.</li>
    </ul>
    <h5 class="underline-text">Sécurité et confidentialité</h5>
    <p>Le site web met en œuvre des mesures organisationnelles, techniques, logicielles et physiques en matière de sécurité du numérique pour protéger les données personnelles contre les altérations, destructions et accès non autorisés. Toutefois, il est à signaler qu'internet n'est pas un environnement complètement sécurisé et le site web ne peut pas garantir la sécurité de la transmission ou du stockage des informations sur internet.</p>
    <h5 class="underline-text">Mise en oeuvre des droits des utilisateurs</h5>
    <p>En application de la réglementation applicable aux données à caractère personnel, les utilisateurs disposent des droits suivants, qu'ils peuvent exercer en faisant leur demande à l'adresse suivante : chickengrill.ktbr@gmail.com.</p>
    <ul>
        <li>le droit d’accès : ils peuvent exercer leur droit d'accès, pour connaître les données personnelles les concernant. Dans ce cas, avant la mise en œuvre de ce droit, le site web peut demander une preuve de l'identité de l'utilisateur afin d'en vérifier l'exactitude.</li>
        <li>le droit de rectification : si les données à caractère personnel détenues par le site web sont inexactes, ils peuvent demander la mise à jour des informations.</li>
        <li>le droit de suppression des données : les utilisateurs peuvent demander la suppression de leurs données à caractère personnel, conformément aux lois applicables en matière de protection des données.</li>
        <li>le droit à la limitation du traitement : les utilisateurs peuvent de demander au site web de limiter le traitement des données personnelles conformément aux hypothèses prévues par le RGPD.</li>
        <li>le droit de s’opposer au traitement des données : les utilisateurs peuvent s’opposer à ce que ses données soient traitées conformément aux hypothèses prévues par le RGPD.</li>
        <li>le droit à la portabilité : ils peuvent réclamer que le site web leur remette les données personnelles qui lui sont fournies pour les transmettre à un nouveau site web.</li>
    </ul>
    <h5 class="underline-text">Evolution de la présente clause</h5>
    <p>Le site web se réserve le droit d'apporter toute modification à la présente clause relative à la protection des données à caractère personnel à tout moment. Si une modification est apportée à la présente clause de protection des données à caractère personnel, le site web s'engage à publier la nouvelle version sur son site. Le site web informera également les utilisateurs de la modification par messagerie électronique, dans un délai minimum de 15 jours avant la date d'effet. Si l'utilisateur n'est pas d'accord avec les termes de la nouvelle rédaction de la clause de protection des données à caractère personnel, il a la possibilité de supprimer son compte.</p>
</div>
<?php
    require_once '../../inc/footer.php';