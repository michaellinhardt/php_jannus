<h1>Abonnement Step 2</h1>


<dl>
	<dd>Situation</dd>
	<dt>
		<input name="sCivilite" value="M" type="radio"> M
		<input name="sCivilite" value="Mme" type="radio"> Mme
		<input name="sCivilite" value="Mlle" type="radio"> Mlle
	</dt>
</dl>
<dl>
	<dd>Nom</dd>
	<dt><input type="text" size="50" id="sNom" /></dt>
</dl>
<dl>
	<dd>Prénom</dd>
	<dt><input type="text" size="50" id="sPrenom" /></dt>
</dl>
<dl>
	<dd>Adresse Résidence</dd>
	<dt><input type="text" disabled="disabled" size="40" id="sAdresseResidence" value="<?php echo $this->aView['aResidence']['adresse'] ?>" /></dt>
</dl>
<dl>
	<dd>Code Postal Résidence</dd>
	<dt><input type="text" disabled="disabled" size="40" id="sZipcodeResidence" value="<?php echo $this->aView['aResidence']['zipcode'] ?>" /></dt>
</dl>
<dl>
	<dd>Ville Résidence</dd>
	<dt><input type="text" disabled="disabled" size="40" id="sVilleResidence" value="<?php echo $this->aView['aResidence']['ville'] ?>" /></dt>
</dl>
<dl>
	<dd>Pays Résidence</dd>
	<dt><input type="text" disabled="disabled" size="40" id="sPaysResidence" value="<?php echo $this->aView['aResidence']['pays'] ?>" /></dt>
</dl>
<div id="_FacturationAdresse">
	<dl>
		<dd>Adresse</dd>
		<dt><input type="text" size="50" id="sAdresse" value="" /></dt>
	</dl>
	<dl>
		<dd>Code Postal</dd>
		<dt><input type="text" size="50" id="sZipcode" value="" /></dt>
	</dl>
	<dl>
		<dd>Ville</dd>
		<dt><input type="text" size="50" id="sVille" value="" /></dt>
	</dl>
</div>
<p><input type="checkbox" id="iSameAdresse" /> Utiliser l'adresse de Résidence pour la facturation</p>
<dl>
	<dd>Date de naissance</dd>
	<dt>
		<select id="sBirthDay">
			<option value="" selected="selected"></option>
			<?php 
			for( $i=1 ; $i<32 ; $i++ )
			{
				echo '<option value="'.$i.'">'.$i.'</option>' ;
			}
			?>
		</select>
		<select id="sBirthMonth">
			<option value="" selected="selected"></option>
			<?php 
			for( $i=1 ; $i<13 ; $i++ )
			{
				echo '<option value="'.$i.'">'.$i.'</option>' ;
			}
			?>
		</select>
		<select id="sBirthYear">
			<option value="" selected="selected"></option>
			<?php
			for( $i = ( intval(date('Y')) - 100 ) ; $i < ( intval(date('Y')) - 15 ) ; $i++ )
			{
				echo '<option value="'.$i.'">'.$i.'</option>' ;
			}
			?>
		</select>
	</dt>
</dl>
<dl>
	<dd>Métier/activité</dd>
	<dt>
		<select id="sActivite">
			<option value="">- Choisissez -</option>
			<?php 
			foreach( $this->aView['aJob'] as $aValue )
			{
				echo '<option value="'.$aValue['JID'].'">'.$aValue['job'].'</option>' ;
			}
			?>
		</select>
	</dt>
</dl>
<dl>
	<dd>Fournisseur Internet Actuel</dd>
	<dt>
		<select id="sFai">
			<option value="">- Choisissez -</option>
			<?php 
			foreach( $this->aView['aFai'] as $aValue )
			{
				echo '<option value="'.$aValue['FID'].'">'.$aValue['fai'].'</option>' ;
			}
			?>
		</select>
	</dt>
</dl>
<dl>
	<dd>La marque de votre Mobile</dd>
	<dt>
		<select id="sMobile">
			<option value="">- Choisissez -</option>
			<?php 
			foreach( $this->aView['aMobile'] as $aValue )
			{
				echo '<option value="'.$aValue['MID'].'">'.$aValue['mobile'].'</option>' ;
			}
			?>
		</select>
	</dt>
</dl>
<dl>
	<dd>Nom de la Banque</dd>
	<dt><input type="text" size="23" id="sNomBanque" /></dt>
</dl>
<dl>
	<dd>Adresse de la Banque</dd>
	<dt><input type="text" size="23" id="sAdresseBanque" /></dt>
</dl>
<dl>
	<dd>Ville de la Banque</dd>
	<dt><input type="text" size="23" id="sVilleBanque" /></dt>
</dl>
<dl>
	<dd>Code Postal de la Banque</dd>
	<dt><input type="text" size="23" id="sZipcodeBanque" /></dt>
</dl>
<dl>
	<dd>Code Banque</dd>
	<dt><input type="text" size="23" id="sCodeBanque" /></dt>
</dl>
<dl>
	<dd>Code Guichet</dd>
	<dt><input type="text" size="23" id="sCodeGuichet" /></dt>
</dl>
<dl>
	<dd>Numéro du compte</dd>
	<dt><input type="text" size="23" id="sNumeroCompte" /></dt>
</dl>
<dl>
	<dd>Clé RIB</dd>
	<dt><input type="text" size="23" id="sCleRib" /></dt>
</dl>
<p><a href="#" id="_btnStep3">Step 3</a></p>