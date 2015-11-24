<div id="_MenuIncrustation"><img src="<?php echo IMG_HTTP ?>pages/offre/resident/img.jpg" /></div>
<div id="_MenuIncrustationEnd" style="height: 231px ;"><!-- Définie l'emplacement de l'ombre et la taille de l'image, ne modifier que la propriété height --></div>

<?php 
$aTel[0] = ConfigModel::getConfig('contact', 3) ;
$aTel[1] = ConfigModel::getConfig('contact', 4) ;
?>

<div id="_MainContent">
	<div id="_MainContentLeft66">
		<div class="_MainContentLeft66">
			<h3>RÉSIDENTS D'IMMEUBLES</h3>
			<p>Votre gestionnaire d'immeuble a confié à Janus TELECOM<br />
			la mise en place du service <strong class="_HighLineViolet">COOLIZ</strong> ?<br />
			N'attendez plus, vous avez la possibilité avec <strong class="_HighLineViolet">COOLIZ</strong><br />
			d'accéder à Internet à haut débit.</p>
			<p><br /><span class="_HighLineViolet">Surfez en haut débit jusqu'à 25 Mégas :</span></p>
			<ul class="_ListPlus">
				<li>Internet haut débit en WiFi jusqu'à 25 Mégas <sup>(1)</sup></li>
				<li>Appels illimités vers fixes et 40 pays <sup>(2)</sup></li>
				<li>Economisez 325&euro;/an, <sup>(3)</sup></li>
				<li>Accès immédiat : « démarrez votre connexion WiFi, surfez »,</li>
				<li>Accessible depuis tous vos équipements sans fil <sup>(4)</sup></li>
			</ul>
		</div>
	</div>
	<div id="_MainContentRight33">
		<div id="_Cadre">
			<p id="_CadreText1">Profitez de <strong class="_HighLineViolet">COOLIZ</strong><br />ni box, ni dépôt de garantie,<br />inscrivez-vous et naviguez<br />en moins de 5 minutes !</p>
			<a href="http://clients.cooliz.fr/user/register" class="_GreenBtn">S'inscrire</a>
			<img src="<?php echo IMG_HTTP ?>layout/hrhorizontal.png" style="width: 215px; margin: 15px 0 5px 15px;" />
			<div id="_ContactTel">
				<p>PAR TÉLÉPHONE</p>
				<strong class="_HighLineViolet"><?php echo $aTel[0]?></strong><span>(<?php echo $aTel[1]?>&euro;/min)</span>
				<p><span>5j/7, de 9h à 18h</span></p>
			</div>
			<img src="<?php echo IMG_HTTP ?>layout/hrhorizontal.png" style="width: 215px; margin: 15px 0 5px 15px;" />
			<p id="_Resiliez">Pratique: Rèsiliez votre F.A.I<br /><span>Cliquez ici</span></p>
		</div>
	</div>
</div>
<?php 
$this->sFooter = 
"(1) Débit ATM : soit 20 Mégas et 600 ko/sec IP. Sous réserve des caractéristiques de la ligne. (2) Vers 99 numéros différents maximum par mois. Dans la limite de 60 minutes de communication par appel, au-delà facturation à la seconde (voir les tarifs). Appels inclus vers : Allemagne, Argentine, Australie, Autriche, Belgique, Brésil, Canada, Chili, Chine, Chypre, Colombie, Danemark, Espagne, France métropolitaine, Royaume Uni, Grèce, Hong-Kong, Hongrie, Irlande, Israël, Italie, Kazakhstan, Luxembourg, Malaisie, Mexique, Norvège, Nouvelle Zélande, Panama, Pays Bas, Pologne, Portugal, Pérou, Russie, Singapour, Slovaquie, Suisse, Suède, Taïwan, Thaïlande, USA, Vénézuela. (3) Le calcul est fait sur la base d'un abonnement multiplay à 37&euro;/mois soit 444&euro;/an. (4) Service accessible depuis tous les équipements sans fil WiFi 802.11 a/b/g/n sous réserve de compatibilité du matériel de l'utilisateur." ;
?>