<script type="text/javascript" src="<?php echo JS_HTTP?>contact/mail.js"></script>

<div id="_ajaxResult"></div>
<!-- DIV DE CHARGEMENT AJAX ASYNC -->
<div id="_ajaxLoading"></div>
<!-- DIV D'ERREUR AJAX -->
<div id="_ajaxError"><p><?php $this->lang('ajax_error')?></p></div>

<div id="_MainContent">
	<div id="_MainContentLeft66">
		<div class="_MainContentLeft66">
			<?php 
				if ($this->aView['mail']=='technique')
				{
					$sMail = ConfigModel::getConfig('contact',1) ; // Mail Technique
					$sService = 'TECHNIQUE' ;
				}
				else
				{
					$sMail = ConfigModel::getConfig('contact',2) ; // Mail Commercial
					$sService = 'COMMERCIAL' ;
				}
				$aTel = ConfigModel::getConfig('contact', 3) ; // Téléphone
			?>
			<p>Pour toute demande concernant l'utilisation du service, appelez le <?php echo $aTel[0] ?> (<?php echo $aTel[1]?>&euro;/min) du lundi au vendredi de 9h à 19h ou par mail <a href="mailto:<?php echo $sMail ?>"><?php echo $sMail ?></a></p>
			<h3>FORMULAIRE DE CONTACT DU SERVICE <?php echo $sService?></h3>
			<form id="_SendForm">
				<p><strong class="_HighLineViolet">Qui êtes-vous?</strong></p>
				<dl>
					<dd>Civilité :</dd>
					<dt>
						<input name="sCivilite" value="M." style="width: auto;" type="radio"> Monsieur&nbsp;&nbsp;
						<input name="sCivilite" value="Mlle" style="width: auto;" type="radio"> Mademoiselle&nbsp;&nbsp;
						<input name="sCivilite" value="Mme" style="width: auto;" type="radio"> Madame&nbsp;&nbsp;
					</dt>
				</dl>
				<dl>
					<dd>Nom :</dd>
					<dt><input id="sNom" title="Champ obligatoire" size="60" type="text"></dt>
				</dl>
				<dl>
					<dd>Prénom :</dd>
					<dt><input id="sPrenom" title="Champ obligatoire" size="60" type="text"></dt>
				</dl>
				<dl>
					<dd>Identifiant Cooliz :</dd>
					<dt><input id="sLogin" title="Champ optionnel" size="60" type="text"></dt>
				</dl>
				
				<hr class="_Clear" />
				<p><strong class="_HighLineViolet">Vos coordonnées</strong></p>
				<dl>
					<dd>E-mail :</dd>
					<dt><input id="sMail" title="Champ obligatoire" size="60" type="text"></dt>
				</dl>
				<dl>
					<dd>Mobile :</dd>
					<dt><input id="sMobile" title="Champ obligatoire" size="60" type="text"></dt>
				</dl>				
				
				<hr class="_Clear" />
				<p><strong class="_HighLineViolet">Votre demande</strong></p>
				<dl>
					<dd>Motif :</dd>
					<dt>
						<select id="sMotif">
							<option value="" selected="selected">- Merci de choisir une option</option>
							<?php 
							if ($this->aView['mail']=='technique')
							{
								echo'<option value="Facturation">Facturation</option>
								<option value="Abonnement">Abonnement</option>
								<option value="Facturation">Facturation</option>
								<option value="Autre">Autre</option>' ;
							}
							else
							{
								echo'<option value="Inscription">Inscription</option>
								<option value="Identifiants">Identifiants</option>
								<option value="Connexion compte client">Connexion compte client</option>
								<option value="Connexion acces Internet">Connexion acces Internet</option>
								<option value="Autre">Autre</option>' ;
							}
							?>
						</select>
					</dt>
					<dl>
						<dd>Message :</dd>
						<textarea rows="" cols="" id="sMessage" title="Champ obligatoire"></textarea></dd>
					</dl>
				</dl>
				<a href="#" id="_SendFormBtn" class="_GreenBtn">Envoyer</a>
				<hr class="_Clear" />
				<input type="hidden" id="sContact" value="<?php echo $this->aView['mail'] ; ?>" />
			</form>
		</div>
	</div>
	<div id="_MainContentRight33">
		<p id="_Operatrice"><img src="<?php echo IMG_HTTP?>pages/contact/operatrice.jpg" /></p>
	</div>
</div>
<hr class="_Clear" />
<div class="formError formErrorCivilite">
	<div class="formErrorContent">Veuillez séléctionnez une civilité<br></div>
	<div class="formErrorArrow">
		<div class="line10"><!-- --></div>
		<div class="line9"><!-- --></div>
		<div class="line8"><!-- --></div>
		<div class="line7"><!-- --></div>
		<div class="line6"><!-- --></div>
		<div class="line5"><!-- --></div>
		<div class="line4"><!-- --></div>
		<div class="line3"><!-- --></div>
		<div class="line2"><!-- --></div>
		<div class="line1"><!-- --></div>
	</div>
</div>
<div class="formError formErrorNom">
	<div class="formErrorContent">Tapez votre votre nom<br></div>
	<div class="formErrorArrow">
		<div class="line10"><!-- --></div>
		<div class="line9"><!-- --></div>
		<div class="line8"><!-- --></div>
		<div class="line7"><!-- --></div>
		<div class="line6"><!-- --></div>
		<div class="line5"><!-- --></div>
		<div class="line4"><!-- --></div>
		<div class="line3"><!-- --></div>
		<div class="line2"><!-- --></div>
		<div class="line1"><!-- --></div>
	</div>
</div>
<div class="formError formErrorPrenom">
	<div class="formErrorContent">Tapez votre prénom<br></div>
	<div class="formErrorArrow">
		<div class="line10"><!-- --></div>
		<div class="line9"><!-- --></div>
		<div class="line8"><!-- --></div>
		<div class="line7"><!-- --></div>
		<div class="line6"><!-- --></div>
		<div class="line5"><!-- --></div>
		<div class="line4"><!-- --></div>
		<div class="line3"><!-- --></div>
		<div class="line2"><!-- --></div>
		<div class="line1"><!-- --></div>
	</div>
</div>
<div class="formError formErrorMail">
	<div class="formErrorContent">Tapez votre E-mail<br></div>
	<div class="formErrorArrow">
		<div class="line10"><!-- --></div>
		<div class="line9"><!-- --></div>
		<div class="line8"><!-- --></div>
		<div class="line7"><!-- --></div>
		<div class="line6"><!-- --></div>
		<div class="line5"><!-- --></div>
		<div class="line4"><!-- --></div>
		<div class="line3"><!-- --></div>
		<div class="line2"><!-- --></div>
		<div class="line1"><!-- --></div>
	</div>
</div>
<div class="formError formErrorMobile">
	<div class="formErrorContent">Tapez votre mobile<br></div>
	<div class="formErrorArrow">
		<div class="line10"><!-- --></div>
		<div class="line9"><!-- --></div>
		<div class="line8"><!-- --></div>
		<div class="line7"><!-- --></div>
		<div class="line6"><!-- --></div>
		<div class="line5"><!-- --></div>
		<div class="line4"><!-- --></div>
		<div class="line3"><!-- --></div>
		<div class="line2"><!-- --></div>
		<div class="line1"><!-- --></div>
	</div>
</div>
<div class="formError formErrorMotif">
	<div class="formErrorContent">Séléctionnez un motif<br></div>
	<div class="formErrorArrow">
		<div class="line10"><!-- --></div>
		<div class="line9"><!-- --></div>
		<div class="line8"><!-- --></div>
		<div class="line7"><!-- --></div>
		<div class="line6"><!-- --></div>
		<div class="line5"><!-- --></div>
		<div class="line4"><!-- --></div>
		<div class="line3"><!-- --></div>
		<div class="line2"><!-- --></div>
		<div class="line1"><!-- --></div>
	</div>
</div>
<div class="formError formErrorMessage">
	<div class="formErrorContent">Ecrivez votre message<br></div>
	<div class="formErrorArrow">
		<div class="line10"><!-- --></div>
		<div class="line9"><!-- --></div>
		<div class="line8"><!-- --></div>
		<div class="line7"><!-- --></div>
		<div class="line6"><!-- --></div>
		<div class="line5"><!-- --></div>
		<div class="line4"><!-- --></div>
		<div class="line3"><!-- --></div>
		<div class="line2"><!-- --></div>
		<div class="line1"><!-- --></div>
	</div>
</div>

<?php 
$this->sFooter = 
"" ;
?>