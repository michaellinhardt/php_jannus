<div id="_MenuIncrustation"><img src="<?php echo IMG_HTTP ?>pages/offre/gestionnaire/img.jpg" /></div>
<div id="_MenuIncrustationEnd" style="height: 231px ;"><!-- Définie l'emplacement de l'ombre et la taille de l'image, ne modifier que la propriété height --></div>
<?php 
$aTel[0] = ConfigModel::getConfig('contact', 3) ;
$aTel[1] = ConfigModel::getConfig('contact', 4) ;
?>
<div id="_MainContent">
	<div id="_MainContentLeft66">
		<div class="_MainContentLeft66">
			<h3><span class="_HighLineViolet">COOLIZ</span> : UNE SOLUTION CLEFS EN MAIN</h3>
			<ul class="_ListPlus">
				<li><strong class="_HighLineViolet">Une prise en charge globale, de l'installation à la maintenance</strong></li>
					<p>Le bailleur ne supporte aucun cout d'installation,
					<br />Le déploiement, l'exploitation et la maintenance sont assurés par Janus Telecom.</p>
				<li><strong class="_HighLineViolet">Un faible encombrement des parties communes</strong></li>
					<p>Le cable optique en colonne montante = 10 mm de diamétre,
					<br />Une ou plusieurs bornes WiFi intégrées dans les parties communes,
					<br />Espace résiduel suffisant pour un déploiement ultérieur.</p>
				<li><strong class="_HighLineViolet">Un réseau opérationnel en 4 semaines sans travaux</strong></li>
					<p>Le réseau est déployé selon les règles de l'art,
					<br />Intervention rapide et efficace dans les colonnes.</p>				
			</ul>
			<p>&nbsp;</p>
			<p>Janus TELECOM et ses partenaires contrôlent à tout instant l'avancement des travaux et la qualitée du travail réalisé sur le terrain.</p>
			<p style="font-size: .8em;">Pour obtenir plus d'informations sur l'opérateur Janus Télécom : <a href="http://www.janustelecom.fr" target="_blank">cliquez-ici</a></p>
		</div>
	</div>
	<div id="_MainContentRight33">
		<div id="_Client" class="_Cadre">
			<p><strong>CLIENTS INSTITUTIONNELS</strong></p>
			<img src="<?php echo IMG_HTTP?>pages/offre/gestionnaire/clients.jpg" />
		</div>
		<div id="_Contact" class="_Cadre">
			<p style="padding: 10px 0 0 0; text-align: center ;"><strong>PARLER À UN CONSEILLER</strong></p>
			<div id="_ContactTel">
				<p>PAR TÉLÉPHONE</p>
				<strong class="_HighLineViolet"><?php echo $aTel[0]?></strong><span>(<?php echo $aTel[1]?>&euro;/min)</span>
				<p><span>5j/7, de 9h à 18h</span></p>
			</div>
			<img src="<?php echo IMG_HTTP ?>layout/hrhorizontal.png" style="width: 215px; margin: 0 0 0 15px;" />
			<div id="_ContactMail">
				<p>PAR MAIL</p>
				<strong class="_HighLineViolet">Formulaire de contact</strong>
			</div>
		</div>
	</div>
</div>
<?php 
$this->sFooter = 
"Parce que chaque immeuble est spécifique dans ses plans et ses matériaux de construction, chacun fait l'objet d'une étude préalable détaillée par notre bureau d'étude. Les travaux ne commenceront qu'une fois validé ce schéma de raccordement avec le gestionnaire de l'immeuble. En tant qu'opérateur d'Immeuble, janus TELECOM est seul et entier responsable du réseau et des coûts associés." ;
?>