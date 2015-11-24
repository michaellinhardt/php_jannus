$(document).ready(function(){
	/*
	 * Innitialisation
	 */
	iDebugStatus = 0 ; // 0 = arreté, 1 = démarré, 2 = terminé
	oNbUser = '' ; // Contien l'initialisation par PHP
	iNbUser = 0 ;
	oResult = {} ; // Contien le retour PHP
	sHtml = '' ; // Stock le contenue HTML à ajouter
	$('#_icon_debugUser').css('visibility', 'hidden') ;
	$('#_btn_debugUser').click(function(){ changeDebugUserStatus(); });
	$('#_btn_debugUserReset').click(function(){ resetDebugUser(); });
});

function resetDebugUser()
{
	ajaxAsync( 'user/debuguserreset', {} , false, false );
	window.location.href = sBaseurl + 'user/debuguser' ;
}

function changeDebugUserStatus()
{
	/*
	 * Gére les clic sur le bouton de lancement
	 */
	if (iDebugStatus==0)
	{
		iDebugStatus = 1 ;
		$('#_btn_debugUser').html('Arrêter');
		$('#_icon_debugUser').css('visibility', 'visible') ;
		startDebugUser();
	}
	else if (iDebugStatus==1)
	{
		iDebugStatus = 0 ;
		$('#_btn_debugUser').html('Reprendre');
		$('#_icon_debugUser').css('visibility', 'hidden') ;
	}
	else if (iDebugStatus==2)
	{
		$('#_btn_debugUser').html('Terminé');
		$('#_icon_debugUser').css('visibility', 'hidden') ;
	}
}

function startDebugUser()
{
	/*
	 * Exécute les appels ajax pour gérer la maintenance
	 */
	// Initialisation
	if (oNbUser=='')
	{
		eval( 'oNbUser = '+ajaxAsync( 'user/debuguserrequest', {} , false, false )+';');
		iNbUser = oNbUser['iNbUser'];
		$('#_nbUserDrupal').html(oNbUser['iNbUserDrupal']);
		$('#_nbUser').html(iNbUser);
		if (iDebugStatus==1) startDebugUser();
		return true ;
	}
	eval( 'oResult = '+ajaxAsync( 'user/debuguserrequest', {} , false, false )+';');
	if (oResult['end']!=undefined)
	{
		$('<li>Terminé</li>').prependTo('#_resultDebugUser');
		iDebugStatus = 2 ;
		changeDebugUserStatus();
		return true ;
	}
	sHtml = 'UserID: ' + oResult['UID'] ;
	if (oResult['action']==1)
	{
		iNbUser++;
		$('#_nbUser').html(iNbUser);
		sHtml += ', Action: Ajout dans la table bo_user' ;
	}
	else if (oResult['action']==2) sHtml += ', Action: Modifier dans la table bo_user' ;
	else if (oResult['action']==3)
	{
		iNbUser--;
		$('#_nbUser').html(iNbUser);
		sHtml += ', Action: Supprimer de la table bo_user' ;
	}
	else if (oResult['action']==4) sHtml += ', Supression d\'une entré en trop dans la table bo_user_adresse' ;
	else sHtml += ', Action: Erreur' ;
	$('<li>'+sHtml+'</li>').prependTo('#_resultDebugUser');
	if (iDebugStatus==1) { startDebugUser(); }
}
