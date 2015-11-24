$(document).ready(function(){
	initConnectForm();
});

function initConnectForm()
{
	/*
	 * Innitialisation du traitement Ajax
	 * de la connection
	 */
	$('#connectForm').submit(function(){
		connectForm_send();
		return false ;
	});
}

function connectForm_send()
{
	/*
	 * Envoie la requette ajax de connexion
	 */
	// Innitialisation
	connectForm_return(0);
	sConnectLogin = $('#sConnectLogin').val() ;
	sConnectPass = $('#sConnectPass').val() ;
	if (emptyVar(sConnectLogin,sConnectPass))
	{
		/*
		 * Si formulaire vide, affiche un message et bloque
		 */
		connectForm_return(1);
		return false ;
	}
	ajaxAsync( 'connexion/request', { sLogin: sConnectLogin, sPass: sConnectPass }, 'connectForm_return' );
}
	
function connectForm_return(iStatus)
{
	if (iStatus==0) $('#_connectMsg').html('').fadeOut() ;
	else if (iStatus==1) $('#_connectMsg').html(oLang['connectForm_empty']).fadeIn() ;
	else if (iStatus==2) $('#_connectMsg').html(oLang['connectForm_badentry']).fadeIn() ;
	else if (iStatus==3) window.location.href = sBaseurl ;
	else ajaxError() ;
}