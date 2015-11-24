<?php
class AbonnementController
{
	public function _start()
	{
		$_SESSION['UID'] = 0 ;
	}
	
	public function ReturnMethod()
	{
		$this->bAjaxMethod = true ;
		if (isset($_GET['token']))
		{
			/*
			 * Retour sur une ouverture de portefeuille
			 */
			$oPayline = new PaylineModel() ;
			$oPayline->setConfig() ;
			$oPayline = new paylineSDK() ;
			$aWebWallet = $oPayline->get_WebWallet( $_GET['token'] ) ;
			
			if ( ($aWebWallet['result']['code']=='02500') || ($aWebWallet['result']['code']=='02501') )
			{
				/*
				 * Affiche payement en attente
				 * (Cette étape ne fais que de l'affichage)
				 */
				echo 'Votre payment est en cours de validation' ;
			}
			else
			{
				/*
				 * Affiche opération échoué
				 * (Cette étape ne fais que de l'affichage)
				 */
				echo 'Votre moyen de payement n\'est pas valide' ;
			}
		}
		else if (isset($_GET['paymentRecordId']))
		{
			/*
			 * Retour sur une échéance
			 */
			$oPayline = new PaylineModel() ;
			$oPayline->setConfig() ;
			$oPayline->traitePaymentRecord( $_GET['paymentRecordId'] ) ;
		}
		else
		{
			/*
			 * Erreur, aucune donné fourni...
			 */
		}
	}
	
	public function Step2Method()
	{
		/*
		 * Etape deux de l'abonnement, enregistre 
		 * les donné personnel de l'utilisateur
		 */
		if ( (!isset($_SESSION['aUser'])) || (!isset($_SESSION['aProduct'])) )
		{
			// L'utilisateur n'a pas passé la premià¨re étape
			header( 'Location: ' . ROOT_HTTP . 'abonnement/step1' );
			exit() ;
		}
		// Récupà¨re la résidence de l'utilisateur
		$oResidence = new ResidenceModel() ;
		$this->aView['aResidence'] = $oResidence->getResidence() ;
		// Récupére la liste des Job à  choisir
		$oUser = new UserModel() ;
		$this->aView['aJob'] = $oUser->getAllJob() ;
		$this->aView['aFai'] = $oUser->getAllFai() ;
		$this->aView['aMobile'] = $oUser->getAllMobile() ;
		$oResidence->oPDO = NULL ;
		$oUser->oPDO = NULL ;
	}
	
	public function Step1Method()
	{
		unset($_SESSION['aUser']) ;
		unset($_SESSION['aProduct']) ;
		/*
		 * Détermine les offres accessible pour cette résidence
		 * ( Uniquement si il passe la vérification )
		 */
		$iCanGetAbonnement = $this->canGetAbonnement() ;
		// Vérifie la résidence
		if ($iCanGetAbonnement=='1')
		{
			// Rediréction car, résidence non listé
			exit() ;
		}
		// Vérifie si l'user est déjà  abonné
		if ($iCanGetAbonnement=='2')
		{
			// Rediréction car, utilisateur déjà  abonné
			exit() ;
		}
		$oResidence = new ResidenceModel() ;
		$this->aView['aProduct'] = $oResidence->getProduct() ;
		// Déconnexion SQL
		$oResidence->oPDO = NULL ;
		$oPayline->oPDO = NULL ;
	}
	
	public function validationStep2Method()
	{
		/*
		 * Vérifie le contenue des donné envoyé par la requette ajax
		 * de Step1, si le contenue est valide il est sauvegarder en 
		 * session puis on envoie l'utilisateur sur la page Step2
		 */
		$this->bAjaxMethod = true ;
		$iCanGetAbonnement = $this->canGetAbonnement() ;
		// Vérifie la résidence
		if ($iCanGetAbonnement=='1')
		{
			// Rediréction car, résidence non listé
			echo 'ici' ;
			exit() ;
		}
		// Vérifie si l'user est déjà  abonné
		if ($iCanGetAbonnement=='2')
		{
			// Rediréction car, utilisateur déjà  abonné
			echo 'la' ;
			exit() ;
		}
		$oPayline = new PaylineModel() ;
		$oPayline->setConfig() ;
		echo json_encode($oPayline->validationStep2()) ;
	}
	
	private function canGetAbonnement()
	{
		/*
		 * Premià¨re étape d'un abonnement:
		 * 1) Vérification de l'adresse IP (pour bloqué la souscription si non résident)
		 * 2) Vérifie si l'utilisateur à  déjà  un dossier de payment UNIQUEMENT SI IL EST CONNECTé (donc impossible de se re-abonner)
		 */
		// Vérifie si l'IP de l'utilisateur correspond à  une résidence
		$oResidence = new ResidenceModel() ;
		if ( !$oResidence->getResidence() )
		{
			/*
			 * L'utilisateur n'est pas dans l'une de nos résidence
			 * on lui bloque l'acces et le redirige vers une page 
			 * expliquant pourquoi
			 */
			/*
			$oWarning = new WarningModel() ;
			$oWarning->badResidenceForAbonnement() ;
			$oWarning->oPDO = NULL ;
			 */
			return 1 ;
		}
		// Initialise le PaylineModel
		$oPayline = new PaylineModel() ;
		$oPayline->setConfig() ;
		// Vérifie si l'utilisateur est connecté 
		if ( ( isset( $_SESSION['UID'] ) ) && ( $_SESSION['UID'] != 0 ) )
		{
			// Si l'utilisateur est connecté, il à  forcément un abonnement
			return 2 ;
		}
		return 0 ;
	}
	
	public function ValidationStep1Method()
	{
		/*
		 * Vérifie le contenue des donné envoyé par la requette ajax
		 * de Step1, si le contenue est valide il est sauvegarder en 
		 * session puis on envoie l'utilisateur sur la page Step2
		 */
		$this->bAjaxMethod = true ;
		$iCanGetAbonnement = $this->canGetAbonnement() ;
		// Vérifie la résidence
		if ($iCanGetAbonnement=='1')
		{
			// Rediréction car, résidence non listé
			exit() ;
		}
		// Vérifie si l'user est déjà  abonné
		if ($iCanGetAbonnement=='2')
		{
			// Rediréction car, utilisateur déjà  abonné
			exit() ;
		}
		$oPayline = new PaylineModel() ;
		$oPayline->setConfig() ;
		echo json_encode($oPayline->validationStep1()) ;
		$oPayline->oPDO = NULL ;
	}
	
	public function cronTacheMethod()
	{
		/*
		 * Contrôle les token en cours de traitement
		 * pour créer les abonnement ou au contraire supprimé les 
		 * données dans le cas d'un echec
		 */
		$this->bAjaxMethod = true ;
		$oPayline = new PaylineModel() ;
		$oPayline->setConfig() ;
		$oPayline->makePayment() ;
		/*
		 * Envoie les mail de rappel au utilisateur concerné
		 */
	}
}