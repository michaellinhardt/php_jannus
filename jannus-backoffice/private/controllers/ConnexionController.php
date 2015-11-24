<?php
class ConnexionController
{
	public function _start()
	{
		$this->mSetLayout = 'layout-connexion.php' ;
	}
	
	public function IndexMethod()
	{
	}

	public function RequestMethod()
	{
		/*
		 * Page de connexion, elle dois recevoir
		 * $_POST['sLogin'] et $_POST['sPass'] ;
		 */
		$this->bAjaxMethod = true ;
		$oAuth = new AuthModel();
		echo $oAuth->AjaxAuth();
		$oAuth->oPDO = NULL ;
	}
	
	public function DeconnexionMethod()
	{
		/*
		 * Deconnect l'utilisateur
		 */
		$this->bAjaxMethod = true ;
		session_destroy();
		echo 1 ;
	}
}