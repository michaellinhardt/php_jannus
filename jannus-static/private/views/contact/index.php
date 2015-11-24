<?php 
$aTel[0] = ConfigModel::getConfig('contact', 3) ;
$aTel[1] = ConfigModel::getConfig('contact', 4) ;
?>
<div id="_MainContent">
	<div id="_MainContentLeft66">
		<div class="_MainContentLeft66">
			<h2><span class="_HighLineViolet">ASSISTANCE</span></h2>
			<p><strong class="_HighLineViolet">En ligne</strong></p>
			<p style="margin-left: 45px;">Vous avez un incident de connexion,
			<br />envoyez une demande au service
			<br />technique en <a href="<?php echo ROOT_HTTP?>contact/technique">cliquant ici</a>
			<br /><br />
			<br />Vous avez une demande relatice à 
			<br />l'inscription, à la souscription de 
			<br />services ou au paiement, envoyez 
			<br />une demande au service
			<br />commercial en <a href="<?php echo ROOT_HTTP?>contact/commercial">cliquant ici</a></p>
			
			<p><strong class="_HighLineViolet">Par téléphone</strong></p>
			<p style="margin-left: 45px;"><?php echo $aTel[0]?> (<?php echo $aTel[1]?>&euro;/min)</p>
			
			<p><strong class="_HighLineViolet">Guides</strong></p>
			<p style="margin-left: 45px;">Assistance de démarrage Wi-Fi
			<br />sur PC et mac en <a href="<?php echo PUBLIC_HTTP?>download/pdf/contact/Assistance.doc" target="_blank">cliquant ici</a></p>
		</div>
	</div>
	<div id="_MainContentRight33">
		<br /><br />
		<img src="<?php echo IMG_HTTP?>pages/contact/operatrice.jpg" />
	</div>
</div>
<?php 
$this->sFooter = 
"" ;
?>