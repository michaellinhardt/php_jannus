<?php
class CronController
{
	public function _start()
	{
		$this->bAjaxMethod = true ;
	}
	
	public function startMethod()
	{
		$iStartMicrotime = microtime(true) ;
		
		// Controle la table des token
		$this->createNewAbonnementFromToken() ;
		
		$iTotalMicrotime = microtime(true) - $iStartMicrotime ;
		echo '<hr /><p>Temps d\'exécution: ' . $iTotalMicrotime ;
	}
	
	private function createNewAbonnementFromToken()
	{
		/*
		 * Contrôle les token en cours de traitement
		 * pour créer les abonnement ou au contraire supprimé les 
		 * données dans le cas d'un echec
		 */
		$this->bAjaxMethod = true ;
		$oPayline = new PaylineModel() ;
		$oPayline->setConfig() ;
		$oPayline->createNewAbonnementFromToken() ;
		/*
		 * Envoie les mail de rappel au utilisateur concerné
		 */
	}
}