<?php 
$aTel[0] = ConfigModel::getConfig('contact', 3) ;
$aTel[1] = ConfigModel::getConfig('contact', 4) ;
?>
<div id="_MainContent">
	<div id="_MainContentLeft66">
		<div class="_MainContentLeft66">
			<h3>QUESTIONS / RÉPONSES</h3>
			<div id="_Accordeon">
				<h3><a href="#">QUI EST JANUS TELECOM ?</a></h3>
				<div>
					<p>Janus TELECOM est l'opérateur de télécommunications, fournisseur d'accès Internet 
					haut débit dédié à l'habitat collectif. Rompue aux nouvelles technologies, l'équipe 
					possède de solides compétences et un savoir-faire éprouvé en matière de 
					télécommunications depuis le développement logiciel jusqu'à l'intégration des 
					composants réseaux.</p>
				</div>
				<h3><a href="#">EN QUOI CONSISTE L'OFFRE COOLIZ ?</a></h3>
				<div>
					<p>C'est une offre d'accès illimité à Internet en haut débit : pour 9,90&euro;/mois, vous pouvez utiliser votre connexion 24h/24 et 7j/7 sans supplément de prix. Il n'y pas de limite non plus sur le volume de données échangées, vous pouvez télécharger ou envoyer autant de données que vous voulez sans surcoût. </p>
				</div>
				<h3><a href="#">QUELS ÉQUIPEMENTS SONT INSTALLÉS À MON DOMICILE ?</a></h3>
				<div>
					<p>Aucun équipement n'est nécessaire, votre connexion WiFi standard présente sur votre ordinateur vous permet de naviguer sur Internet. </p>
				</div>
				<h3><a href="#">QUEL EST LE DÉBIT DISPONIBLE?</a></h3>
				<div>
					<p>Avec COOLIZ de janus TELECOM, vous surfez en haut débit jusqu'à 25 Mbit/sec* en réception et 800 ko/sec* en émission. <br /><span style="font-size: .8em ;">*(Débit ATM : soit 20 Mégas et 600 ko/sec IP. Sous réserve des caractéristiques de la ligne.)</span></p>
				</div>
				<h3><a href="#">POURQUOI COOLIZ EST-IL MOINS CHER ?</a></h3>
				<div>
					<p>Tout simplement parce que vous ne payez que ce que vous consommez. La majorité des Français s'abonne à un service multiplay à 35&euro;/mois en moyenne alors qu'ils n'utilisent que l'Internet. Pour tout ceux qui veulent surfez dans les meilleures conditions et téléphoner sans limite, COOLIZ by Janus Telecom est l'offre de référence.</p>
				</div>
				<h3><a href="#">QUELS SONT LES AVANTAGES DU WIFI ?</a></h3>
				<div>
					<p>Le WiFi permet d'atteindre des débits équivalents à une connexion ADSL, ce qui rend son partage possible pour la desserte des clients. L'usage réel d'Internet n'impose pas une connexion en fibre optique pour une navigation confortable et stable. Enfin, le WiFi ne nécessite aucun équipement supplémentaire, la seule activation de votre connexion vous permet de naviguer en illimité à très haut débit. </p>
				</div>
				<h3><a href="#">NOS VALEURS ?</a></h3>
				<div>
					<p>Nous essayons de travailler de la façon la plus intelligente possible, et cherchons à réduire notre impact sur votre facture, aussi nous supprimons tous les services superflus dont vous n'avez pas besoin. Avec Cooliz il n'y a pas d'options à rallonges qui viennent augmenter votre facture en fin de mois, vous avez besoin de surfer, inscrivez vous, c'est rapide, vous payez 9,90&euro;/mois, et rien d'autres ! </p>
				</div>
				<h3><a href="#">COMMENT JOINDRE LE SERVICE CLIENTS ?</a></h3>
				<div>
					<p>Votre Service Clients est à votre disposition du lundi au samedi de 9h à 19h au 0892 700 207 (0,34&euro;/min) et par mail, <a href="mailto:service.commercial@janustelecom.fr">service.commercial@janustelecom.fr</a></p>
				</div>
				<h3><a href="#">VOUS ÊTES OCCUPANT D'IMMEUBLE ?</a></h3>
				<div>
					<p>Vous êtes occupant d'immeuble en habitat collectif, étudiant en résidence universitaire privée - publique ou copropriétaire et vous souhaitez profiter du service COOLIZ.
					<br />Contactez notre service client au <?php echo $aTel[0] ?> en nous indiquant les coordonnées de votre gestionnaire d'immeuble, un collaborateur de janus TELECOM lui présentera l'offre COOLIZ dans les plus brefs délais.
					<br />N'hésitez pas aussi à lui en parler directement !
					<br />Contactez notre service client au <?php echo $aTel[0] ?> (<?php echo $aTel[1] ?>&euro;/min) et par mail, <a href="mailto:service.commercial@janustelecom.fr">service.commercial@janustelecom.fr</a></p>
				</div>
				<h3><a href="#">VOUS ÊTES GESTIONNAIRE D'IMMEUBLE ?</a></h3>
				<div>
					<p>Vous êtes bailleur social, syndic, promoteur ou gestionnaire d'un immeuble et vous souhaitez faire profiter à vos résidents du service COOLIZ. Il vous suffit de nous contacter pour permette à tous les habitants de votre immeuble d'accéder à COOLIZ.
					<br />Pour plus d'informations, contactez notre service client au <?php echo $aTel[0] ?> (<?php echo $aTel[1] ?>&euro;/min) et par mail, <a href="mailto:service.commercial@janustelecom.fr">service.commercial@janustelecom.fr</a></p>
				</div>
			</div>
		</div>
	</div>
	<div id="_MainContentRight33">
		<div id="_Contact">
			<h4>PARLEZ À UN CONSEILLER</h4>
			<p id="_CadreText1">Profitez de <strong class="_HighLineViolet">COOLIZ</strong><br />ni box, ni dépôt de garantie,<br />inscrivez-vous et naviguez<br />en moins de 5 minutes !</p>
			<a href="#" class="_GreenBtn">S'inscrire</a>
			<img src="<?php echo IMG_HTTP ?>layout/hrhorizontal.png" style="width: 215px; margin: 15px 0 5px 15px;" />
			<div id="_ContactTel">
				<p>PAR TÉLÉPHONE</p>
				<strong class="_HighLineViolet"><?php echo $aTel[0]?></strong><span>(<?php echo $aTel[1]?>&euro;/min)</span>
				<p><span>5j/7, de 9h à 18h</span></p>
			</div>
			<img src="<?php echo IMG_HTTP ?>layout/hrhorizontal.png" style="width: 215px; margin: 15px 0 5px 15px;" />
			<div id="_ContactMail">
				<p>PAR MAIL</p>
				<strong class="_HighLineViolet">Formulaire de contact</strong>
			</div>
		</div>
		<div id="_Telechargement">
			<h4>TÉLÉCHARGEMENTS</h4>
			<ul class="_ListPlus">
				<li><a href="<?php echo ROOT_HTTP ?>public/download/pdf/presse/Service_Cooliz.pdf" target="_blank">Fiche service COOLIZ by Janus Télécom</a><br /><br /></li>
				<li><a href="<?php echo ROOT_HTTP ?>public/download/pdf/presse/Charte_Cooliz.pdf" target="_blank">Charte d'installation</a><br /><br /></li>
			</ul>
		</div>
	</div>
</div>
<?php 
$this->sFooter = 
"" ;
?>