$(document).ready(function(){
	initBtnSameAdresse() ;
	initBtnStep3() ;
});

function initBtnSameAdresse()
{
	$('#iSameAdresse').change(function(){
		if ($('#iSameAdresse').is(':checked'))
		{
			$('#sAdresse').val( $('#sAdresseResidence').val() ).attr('disabled', 'disabled') ;
			$('#sZipcode').val( $('#sZipcodeResidence').val() ).attr('disabled', 'disabled') ;
			$('#sVille').val( $('#sVilleResidence').val() ).attr('disabled', 'disabled') ;
		}
		else
		{
			$('#sAdresse').val( '' ).attr('disabled', '') ;
			$('#sZipcode').val( '' ).attr('disabled', '') ;
			$('#sVille').val( '' ).attr('disabled', '') ;
		}
	});
}

function initBtnStep3()
{
	/*
	 * Lors d'un clic sur le bouton _btnSep3, on sauvegarde
	 * dans des variables tout les paramètre entré dans le formulaire
	 * pour envoyer une requette ajax qui va le traiter.
	 */
	$('#_btnStep3').click(function(){
		sCivilite = $('input[type=radio][name=sCivilite]:checked').val() ;
		sNom = $('#sNom').val() ;
		sPrenom = $('#sPrenom').val() ;
		sAdresse = $('#sAdresse').val() ;
		sZipcode = $('#sZipcode').val() ;
		sVille = $('#sVille').val() ;
		sBirthDay = $('#sBirthDay').val() ;
		sBirthMonth = $('#sBirthMonth').val() ;
		sBirthYear = $('#sBirthYear').val() ;
		sFai = $('#sFai').val() ;
		sActivite = $('#sActivite').val() ;
		sMobile = $('#sMobile').val() ;
		sNomBanque = $('#sNomBanque').val() ;
		sAdresseBanque = $('#sAdresseBanque').val() ;
		sVilleBanque = $('#sVilleBanque').val() ;
		sZipcodeBanque = $('#sZipcodeBanque').val() ;
		sCodeBanque = $('#sCodeBanque').val() ;
		sCodeGuichet = $('#sCodeGuichet').val() ;
		sNumeroCompte = $('#sNumeroCompte').val() ;
		sCleRib = $('#sCleRib').val() ;
		ajaxAsync( 'abonnement/validationstep2', { sCivilite: sCivilite, sNom: sNom, sPrenom: sPrenom, sAdresse: sAdresse, sZipcode: sZipcode, sVille: sVille, sBirthDay: sBirthDay, sBirthMonth: sBirthMonth, sBirthYear: sBirthYear, sFai: sFai, sActivite: sActivite, sMobile: sMobile, sNomBanque: sNomBanque, sAdresseBanque: sAdresseBanque, sVilleBanque: sVilleBanque, sZipcodeBanque: sZipcodeBanque, sCodeBanque: sCodeBanque, sCodeGuichet: sCodeGuichet, sNumeroCompte: sNumeroCompte, sCleRib: sCleRib }, 'returnStep2' ) ;
		return true ;
	});
}

function returnStep2(aReturn)
{
	dump(aReturn) ;
	aReturn = eval( '(' + aReturn + ')' ) ;
	if ( (aReturn['sPaymentUrl']=='0') || (aReturn['sPaymentUrl']==undefined) )
	{
		iError = 0 ;
		if (aReturn['sCivilite']=='1')
		{
			iError++ ;
		}
		if (aReturn['sNom']=='1')
		{
			iError++ ;
		}
		if (aReturn['sPrenom']=='1')
		{
			iError++ ;
		}
		if (aReturn['sAdresse']=='1')
		{
			iError++ ;
		}
		if (aReturn['sZipcode']=='1')
		{
			iError++ ;
		}
		if (aReturn['sVille']=='1')
		{
			iError++ ;
		}
		if (aReturn['sBirth']=='1')
		{
			iError++ ;
		}
		if (aReturn['sFai']=='1')
		{
			iError++ ;
		}
		if (aReturn['sMobile']=='1')
		{
			iError++ ;
		}
		if (aReturn['sActivite']=='1')
		{
			iError++ ;
		}
		if (aReturn['sNomBanque']=='1')
		{
			iError++ ;
		}
		if (aReturn['sAdresseBanque']=='1')
		{
			iError++ ;
		}
		if (aReturn['sVilleBanque']=='1')
		{
			iError++ ;
		}
		if (aReturn['sZipcodeBanque']=='1')
		{
			iError++ ;
		}
		if (aReturn['sCodeBanque']=='1')
		{
			iError++ ;
		}
		if (aReturn['sCodeGuichet']=='1')
		{
			iError++ ;
		}
		if (aReturn['sNumeroCompte']=='1')
		{
			iError++ ;
		}
		if (aReturn['sCleRib']=='1')
		{
			iError++ ;
		}
		if (aReturn['sValidRib']=='1')
		{
			iError++ ;
		}
		if (iError==0)
		{
			/*
			 * Création du Wallet Echoué !
			 */
		}
	}
	else window.location.href = aReturn['sPaymentUrl'] ;
}