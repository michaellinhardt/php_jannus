$(document).ready(function(){
	initSendForm();
});

function initSendForm()
{
	/*
	 * Innitialisation du traitement Ajax
	 * du formulaire de mail
	 */
	$('#_SendFormBtn').click(function(){ $('#_SendForm').submit(); return false ; });
	$('#_SendForm').submit(function(){
		sendForm_request();
		return false ;
	});
}

function sendForm_request()
{
	/*
	 * Envoie le mail
	 */
	$('.formError').css('visibility', 'hidden');
	// Vérifie les champs vide ou non
	bSend = sendForm_verif() ;
	if (bSend==false) return false ;
	// Stoque les info
	sCivilite = $('input:radio[name=sCivilite]:checked').val() ;
	sNom = $('#sNom').val() ;
	sPrenom = $('#sPrenom').val() ;
	sLogin = $('#sLogin').val() ;
	sMail = $('#sMail').val() ;
	sMobile = $('#sMobile').val() ;
	sMotif = $('#sMotif').val() ;
	sMessage = $('#sMessage').val() ;
	sContact = $('#sContact').val() ;
	// Envoie la requette
	ajaxAsync('contact/send', { sContact: sContact, sCivilite: sCivilite, sNom: sNom, sPrenom: sPrenom, sLogin: sLogin, sMail: sMail, sMobile: sMobile, sMotif: sMotif, sMessage: sMessage }, 'sendForm_result' );
}

function sendForm_result(iData)
{
	alert(iData);
	if ((iData>0) && (iData<8)) $('#_ajaxResult').html(oLang['result_'+iData]).dialog('open') ;
	else ajaxError() ;
}

function sendForm_verif()
{
	bSend = true ;
	if ($('input:radio[name=sCivilite]:checked').val()==undefined) { bSend = false ; $('.formErrorCivilite').css('visibility', 'visible'); }
	if ($('#sNom').val()=='') { bSend = false ; $('.formErrorNom').css('visibility', 'visible'); }
	if ($('#sPrenom').val()=='') { bSend = false ; $('.formErrorPrenom').css('visibility', 'visible'); }
	if ($('#sMail').val()=='') { bSend = false ; $('.formErrorMail').css('visibility', 'visible'); }
	if ($('#sMobile').val()=='') { bSend = false ; $('.formErrorMobile').css('visibility', 'visible'); }
	if ($('#sMotif').val()=='') { bSend = false ; $('.formErrorMotif').css('visibility', 'visible'); }
	if ($('#sMessage').val()=='') { bSend = false ; $('.formErrorMessage').css('visibility', 'visible'); }
	return bSend ;
}