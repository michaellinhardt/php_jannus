<?php 
/*
 * Remanie le tableau contenant la liste des produit pour 
 * l'utiliser dans le skinnage des produit
 */
$aProduct = array() ;
foreach( $this->aView['aProduct'] as $iKey => $aValue )
{
	$iPID = $aValue['PID'] ;
	$aProduct[$iPID] = $aValue ;
}
?>

<h1>Abonnement</h1>
<div id="_Product">
	<fieldset>
		<legend>Abonnement</legend>
		
		<?php if (isset($aProduct[1])) { // Bloc du PID 1?>
		<p><input type="radio" id="_PID1" name="iInternet" value="1" checked="checked" /> Abonnement mensuel sur 12 mois ( 9.90&euro;/mois )</p>
		<?php }?>
		
		<?php if (isset($aProduct[2])) { // Bloc du PID 2?>
		<p><input type="radio" id="_PID2" name="iInternet" value="2" /> Abonnement mensuel sur 24 mois ( 9.90&euro;/mois )</p>
		<?php }?>
		
		<?php if (isset($aProduct[3])) { // Bloc du PID 3?>
		<p><input type="checkbox" disabled="disabled" checked="checked" id="_PID3" /> Frais d'inscription ( 10&euro; )</p>
		<?php }?>
		
		<?php if (isset($aProduct[4])) { // Bloc du PID 4?>
		<p><input type="checkbox" id="_PID4" /> Clé WiFi</p>
		<?php }?>
		
		<?php if (isset($aProduct[5])) { // Bloc du PID 5?>
		<p><input type="checkbox" id="_PID5" /> Antivirus</p>
		<?php }?>

		<p><input type="checkbox" id="_CGV" /> Condition général de vente</p>

	</fieldset>
</div>

<div id="_User">
	<fieldset>
		<legend>Mon compte</legend>
		<p><input type="text" size="50" id="_User_Mail" /> Mail</p>
		<p><input type="text" size="50" id="_User_Mail2" /> Re-Mail</p>
		<p><input type="text" size="16" id="_User_Portable" /> Téléphone portable</p>
	</fieldset>
</div>

<div id="_boxWait">
	<p>Veuillez patientez ...<br />
	<img src="<?php echo IMG_HTTP?>icon/loading.gif" /></p>
</div>

<a href="#" id="_btnStep2" />Step 2</a>