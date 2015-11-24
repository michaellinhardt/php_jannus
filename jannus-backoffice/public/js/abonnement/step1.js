$(document).ready(function(){
	initBoxWait() ;
	initBtnStep2() ;
});

function initBoxWait()
{
	/*
	 * Initialisationd de la boite de chargement
	 * ajax
	 */
	$('#_boxWait').dialog({
		modal: true,
		resizable: false,
		draggable: false,
		autoOpen: false,
		title: oLang['wait_box']
	});
}

function initBtnStep2()
{
	$('#_btnStep2').click(function(){
		PID1 = $('#_PID1').is(':checked') ;
		PID2 = $('#_PID2').is(':checked') ;
		PID3 = $('#_PID3').is(':checked') ;
		PID4 = $('#_PID4').is(':checked') ;
		PID5 = $('#_PID5').is(':checked') ;
		PID6 = $('#_PID6').is(':checked') ;
		CGV = $('#_CGV').is(':checked') ;
		sMail = $('#_User_Mail').val() ;
		sMail2 = $('#_User_Mail2').val() ;
		sPortable = $('#_User_Portable').val() ;
		ajaxAsync( 'abonnement/validationstep1', { sMail: sMail, sMail2: sMail2, sPortable: sPortable, PID1: PID1, PID2: PID2, PID3: PID3, PID4: PID4, PID5: PID5, PID6: PID6, CGV: CGV }, 'validationReturn' ) ;
	});
}

function validationReturn(iData)
{
	/*
	 * Affiche les message d'erreur si nécéssaire,
	 * sinon envoie au Step2
	 */
	aReturn = eval( '(' + iData + ')' ) ;
	iError = 0 ;
	if (aReturn['CGV']==1)
	{
		iError++ ;
	}
	if (aReturn['sMail']==1)
	{
		iError++ ;
	}
	if (aReturn['sPortable']==1)
	{
		iError++ ;
	}
	if (iError==0) window.location.href = sBaseurl + 'abonnement/step2' ;
}