<?php
class PaylineModel extends CoreModel
{
	/*
	 * Cette classe gà¨re toutes les actions d'échange entre Cooliz et Payline
	 */
	public function setConfig()
	{
		/*
		 * Stoque la configuration de Payline
		 */
		$sMode = 'homologation' ;
		
		if (defined('PAYMENT_CURRENCY')) return true ;
		
		DEFINE( 'PAYMENT_CURRENCY', 978 ); // Default payment currency (ex: 978 = EURO)
		DEFINE( 'ORDER_CURRENCY', PAYMENT_CURRENCY );
		
		DEFINE( 'SECURITY_MODE', 'SSL' ); // Protocol (ex: SSL = HTTPS)
		DEFINE( 'LANGUAGE_CODE', 'fr' ); // Payline pages language
		
		DEFINE( 'PAYMENT_ACTION', 101 ); // Default payment method
		DEFINE( 'PAYMENT_MODE', 'REC' ); // Default payment mode
		
		DEFINE('CANCEL_URL', 'http://localhost/bocooliz/abonnement/return' ); // Default cancel URL
		DEFINE('NOTIFICATION_URL', 'http://localhost/bocooliz/abonnement/notification' ); // Default notification URL
		DEFINE('RETURN_URL', 'http://localhost/bocooliz/abonnement/return' ); // Default return URL
		
		DEFINE( 'CUSTOM_PAYMENT_PAGE_CODE', '' );	
		DEFINE('CUSTOM_PAYMENT_TEMPLATE_URL', ''); // Default payment template URL
		
		DEFINE( 'PROXY_HOST', null); // Proxy URL (optional)
		DEFINE( 'PROXY_PORT', null); // Proxy port number without 'quotes' (optional)
		DEFINE( 'PROXY_LOGIN', '' ); // Proxy login (optional)
		DEFINE( 'PROXY_PASSWORD', '' ); // Proxy password (optional)
		
		if ($sMode=='homologation')
		{
			DEFINE( 'CONTRACT_NUMBER', '5101105' ); // Contract type default (ex: 001 = CB, 003 = American Express...)
			DEFINE( 'CONTRACT_NUMBER_LIST', '5101105' ); // Contract type multiple values (separator: ;)
			
			DEFINE( 'MERCHANT_ID', '60899744432410' ); // Merchant ID
			DEFINE( 'ACCESS_KEY', 'ZkzYkgGKgYQrojORBAu2' ); // Certificate key
		
			DEFINE( 'PRODUCTION', FALSE); // Demonstration (FALSE) or production (TRUE) mode
		}
		else if ($sMode=='production')
		{
			DEFINE( 'CONTRACT_NUMBER', '5101106' ); // Contract type default (ex: 001 = CB, 003 = American Express...)
			DEFINE( 'CONTRACT_NUMBER_LIST', '5101106' ); // Contract type multiple values (separator: ;)
			
			DEFINE( 'MERCHANT_ID', '31410669643295' ); // Merchant ID
			DEFINE( 'ACCESS_KEY', 'HOXhYGWrvgTVH0N1MyEl' ); // Certificate key
		
			DEFINE( 'PRODUCTION', FALSE); // Demonstration (FALSE) or production (TRUE) mode
		}
		else return false ;
		
		require_once ( LIBS_PATH . '/payline/lib_debug.php' );
		require_once ( LIBS_PATH . '/payline/paylineSDK.php' );
	}
	
	public function traitePaymentRecord( $iPaymentRecordId )
	{
		/*
		 * Analyse un dossié de payement pour exécuter les traitement associé
		 * Si le payement à échoué re-créer le dossier
		 * sinon c ok, change le statut de l'user en même temps
		 */
		$aPaymentRecordId = $this->getPaymentRecord( $iPaymentRecordId ) ;
		/*
		 * Le if ci-dessous est techniquement impossible, si payline envoie une notif sur un dossier de payement
		 * avec un code de retour autre que 02500 ou 02501, c'est qu'il envoie une notif sur un dossier de payement
		 * inexistant, on stop tout
		 */
		if ( ($aPaymentRecordId['result']['code']!='02500') && ($aPaymentRecordId['result']['code']!='02501') ) return false ;
		// Si le portefeuil est cloturé on stop
		if ( $aPaymentRecordId['isDisabled']==1 ) return false ;
		/*
		 * Calcule le montant total que l'on dois avoir prélever à l'utilisateur,
		 * en partant de la date du premier payement juska la date d'aujourd'huit 
		 */
		$aProduct = $this->getAllProductPaymentRecordId( $iPaymentRecordId ) ;
		// Si la liste des produit n'existe pas on arrête (erreur dans la base de donnée !)
		if (!$aProduct) return false ;
		// Récupére la liste des sommes due pour chaque mois
		$aCoolizByMonth = $this->calcPaymentByMonth( $aProduct ) ;
		
		$aCoolizByMonth = array(
		"2010-10" => 2990,
		"2010-11" => 990,
		"2010-12" => 990,
		"2011-01" => 990,
		"2011-02" => 990,
		"2011-03" => 990,
		"2011-04" => 990,
		"2011-05" => 990,
		"2011-06" => 990,
		"2011-07" => 990,
		);
		
		// Récupére la liste des sommes payé pour chaque mois
		$aPaylineByMonth = $this->getPaymentByMonth( $aPaymentRecordId['billingRecordList']['billingRecord'] ) ;
		
		
		$aPaylineByMonth = array(
		"2010-10" => 0,
		"2010-11" => 0,
		"2010-12" => 0,
		"2011-01" => 0,
		"2011-02" => 0,
		"2011-03" => 7940,
		);
		
		
		// Calcule pour chaque date, entre le montant due et ressue, si tout est en régle
		$aSoldeByMonth = $this->calcSoldeByMonth( $aCoolizByMonth, $aPaylineByMonth ) ;
		// Calcule l'argent que nous dois l'utilisateur en additionnant chaque somme contenue dans $aSoldeByMonth
		$iImpaye = 0 ;
		// Si $iImpaye = 0, tout est ok, si negatif: on dois de l'argent, si positif: Il nous dois de l'argent
		foreach( $aSoldeByMonth as $iValue )
		{
			$iImpaye += $iValue ;
		}
		
		/*
		 * Recréer un tableau comprenant toutes les dates de l'abonnement et l'argent du
		 */
		foreach( $aCoolizByMonth as $sMonth => $iValue )
		{
			$sCurrentMonth = date('Y-m') ;
			if ( $sMonth == $sCurrentMonth ) $aNewPayement[$sMonth] = $iImpaye + 10 ;
			if ( $sMonth > $sCurrentMonth ) $aNewPayement[$sMonth] = $iValue ;
		}
		
		
		var_dump($aCoolizByMonth) ;
		var_dump($aPaylineByMonth) ;
		var_dump($aSoldeByMonth) ;
		var_dump($iImpaye) ;
		var_dump($aNewPayement) ;
		var_dump( $aPaymentRecordId['billingRecordList']['billingRecord'] ) ;
		
	}
	
	public function calcSoldeByMonth( $aCoolizByMonth, $aPaylineByMonth )
	{
		/*
		 * Vérifie pour chaque mois l'argent due et l'argent ressu
		 * retourne un tableau ayant une KEY correspondant au mois et une valeur
		 * correspondant au montant, si 0 tout est ok
		 * si somme négatif: on dois de l'argent
		 * si somme positif: il nous dois de l'argent
		 */
		$aSoldeByMonth = array() ;
		//echo $sCurrentMonth ; exit() ;
		foreach( $aCoolizByMonth as $sMonth => $iDue )
		{
			if (isset($aPaylineByMonth[$sMonth])) $aSoldeByMonth[$sMonth] = $iDue - $aPaylineByMonth[$sMonth] ;
		}
		return $aSoldeByMonth ;
	}
	
	public function getPaymentByMonth( $aBillingList )
	{
		/*
		 * Calcule la somme payé chaque mois
		 * ex:
		 * [2011-01] +29,90 (payement ok)
		 * [2011-02] +9,90 (payement ok)
		 * [2011-03] 0 (payement échoué)
		 * [2011-04] 0 (payement échoué)
		 */
		$aPaylineByMonth = array() ;
		foreach( $aBillingList as $oBilling )
		{
			// Reconstruit la date pour correspondre à notre format de date
			$aMonth = explode( '/', $oBilling->date ) ;
			$sMonth = $aMonth[2] . '-' . $aMonth[1] ;
			$sCurrentDate = date('Y-m-d') ;
			$sPayementDate = $aMonth[2] . '-' . $aMonth[1] . '-' . $aMonth[0] ;
			
			// Si $sPaymentDate <= $sCurrentDate, alors le payement est effectué, sinon il est en attente
			if ( $sPayementDate <= $sCurrentDate )
			{
				if (!isset($aPaylineByMonth[$sMonth])) $aPaylineByMonth[$sMonth] = 0 ;
				// Payement réussis, on incrémente:
				if ( $oBilling->status == 1 ) $aPaylineByMonth[$sMonth] += $oBilling->amount ;
			}
		}
		return $aPaylineByMonth ;
	}
	
	public function getNextMonthDate( $sDate )
	{
		/*
		 * On entre une date au forma Y-m-d et on récupère cette date
		 * au format Y-m + 1 mois
		 */
		// Eclate la date donnée en tableau
		$aDate = explode( '-', $sDate ) ;
		// Construit la date du mois suivant
		return date( 'Y-m', mktime( 0, 0, 0, $aDate[1]+1, 1, $aDate[0] ) ) ;
	}
	public function getPrevMonthDate( $sDate )
	{
		/*
		 * On entre une date au forma Y-m-d et on récupère cette date
		 * au format Y-m + 1 mois
		 */
		// Eclate la date donnée en tableau
		$aDate = explode( '-', $sDate ) ;
		// Construit la date du mois suivant
		return date( 'Y-m', mktime( 0, 0, 0, $aDate[1]-1, 1, $aDate[0] ) ) ;
	}
	
	public function getMonthDate( $sDate )
	{
		$aDate = explode( '-', $sDate ) ;
		return $aDate[0] . '-' . $aDate[1] ;
	}
	
	public function calcPaymentByMonth( $aProduct )
	{
		/*
		 * Cette fonction retourne un tableau ayant pour KEY la date de chaque mois
		 * et comme valeur le montant du pour cette date
		 * exemple
		 * [2011-03] 29,90
		 * [2011-04] 9,90
		 * [2011-05] 9,90 .. etc
		 */
		$aCoolizByMonth = array() ;
		foreach( $aProduct as $aValue )
		{
			$sMonth = $this->getPrevMonthDate( $aValue['createDate'] ) ;
			if ($aValue['recurrent']==1) $iNbMonth = $aValue['recurrentDuree'] ;
			else $iNbMonth = 1 ;
			// Incrémente le montant correspondant à chaque date
			for( $iBoucle = 1 ; $iBoucle < ( $iNbMonth + 1 ) ; $iBoucle++ )
			{
				$sMonth = $this->getNextMonthDate( $sMonth ) ;
				if (!isset($aCoolizByMonth[$sMonth])) $aCoolizByMonth[$sMonth] = 0 ;
				// Dans le cas d'un firstPayment particulié
				if ( ( $iBoucle == 1 ) && ( $aValue['priceFirst'] != 0 ) ) $aCoolizByMonth[$sMonth] += $aValue['priceFirst'] ;
				else $aCoolizByMonth[$sMonth] += $aValue['price'] ;
			}
		}
		return $aCoolizByMonth ;
	}
	
	public function getPaymentRecord( $iPaymentRecordId )
	{
		/*
		 * Récupère les données lié à un paymentRecordId
		 * et les met à jours dans la table si besoin
		 */
		// Récupére les infos sur le payment
		$oPayline = new paylineSDK() ;
		$aParam['contractNumber'] = CONTRACT_NUMBER ;
		$aParam['paymentRecordId'] = $iPaymentRecordId ;
		$aPaymentRecordId = $oPayline->get_payment_record( $aParam ) ;
		// Vérifie si le dossier existe dans notre base
		$aCoolizPaymentFolder = $this->oPDO->query( 'SELECT COUNT(*) FROM bo_payline_folder WHERE paymentRecordId='.$iPaymentRecordId )->fetch() ;
		if ( ($aPaymentRecordId['result']['code']=='02500') || ($aPaymentRecordId['result']['code']=='02501') )
		{
			/*
			 * Le dossier de payment existe chez Payline, on l'enregistre dans notre base
			 */
			// Le dossier n'existe pas dans notre base, on le créer
			if ($aCoolizPaymentFolder[0]==0) $this->oPDO->query('INSERT INTO bo_payline_folder SET paymentRecordId="'.$iPaymentRecordId.'"') ;
			// Met à jour le dossier dans notre base
			$oPaymentFolder = $this->oPDO->prepare('UPDATE bo_payline_folder SET result_code=:result_code
			, result_longMessage=:result_longMessage
			, result_shortMessage=:result_shortMessage
			, recurring_firstAmount=:recurring_firstAmount
			, recurring_amount=:recurring_amount
			, recurring_billingCycle=:recurring_billingCycle
			, recurring_billingLeft=:recurring_billingLeft
			, recurring_billingDay=:recurring_billingDay
			, recurring_startDate=:recurring_startDate
			, isDisabled=:isDisabled
			, reforder=:reforder
			, totalAmount=:totalAmount WHERE paymentRecordId="'.$iPaymentRecordId.'"') ;
			$oPaymentFolder->bindValue( ':result_code', $aPaymentRecordId['result']['code'] ) ;
			$oPaymentFolder->bindValue( ':result_longMessage', $aPaymentRecordId['result']['longMessage'] ) ;
			$oPaymentFolder->bindValue( ':result_shortMessage', $aPaymentRecordId['result']['shortMessage'] ) ;
			$oPaymentFolder->bindValue( ':recurring_firstAmount', $aPaymentRecordId['recurring']['firstAmount'] ) ;
			$oPaymentFolder->bindValue( ':recurring_amount', $aPaymentRecordId['recurring']['amount'] ) ;
			$oPaymentFolder->bindValue( ':recurring_billingCycle', $aPaymentRecordId['recurring']['billingCycle'] ) ;
			$oPaymentFolder->bindValue( ':recurring_billingLeft', $aPaymentRecordId['recurring']['billingLeft'] ) ;
			$oPaymentFolder->bindValue( ':recurring_billingDay', $aPaymentRecordId['recurring']['billingDay'] ) ;
			$oPaymentFolder->bindValue( ':recurring_startDate', $aPaymentRecordId['recurring']['startDate'] ) ;
			$oPaymentFolder->bindValue( ':isDisabled', $aPaymentRecordId['isDisabled'] ) ;
			if (!isset($aPaymentRecordId['order']['ref'])) $aPaymentRecordId['order']['ref'] = '' ;
			if (!isset($aPaymentRecordId['order']['amount'])) $aPaymentRecordId['order']['amount'] = '' ;
			$oPaymentFolder->bindValue( ':reforder', $aPaymentRecordId['order']['ref'] ) ;
			$oPaymentFolder->bindValue( ':totalAmount', $aPaymentRecordId['order']['amount'] ) ;
			$oPaymentFolder->execute() ;
		}
		else
		{
			/*
			 * Si le folder n'existe pas chez payline mais dans nos table,
			 * on met tout de même nos table à jour
			 */
			if ($aCoolizPaymentFolder[0]==1)
			{
				$oPaymentFolder = $this->oPDO->query('UPDATE bo_payline_folder SET result_code=:result_code, result_longMessage=:result_longMessage, result_shortMessage=:result_shortMessage WHERE paymentRecordId="'.$iPaymentRecordId.'"') ;
				$oPaymentFolder->bindValue( ':result_code', $aPaymentRecordId['result']['code'] ) ;
				$oPaymentFolder->bindValue( ':result_longMessage', $aPaymentRecordId['result']['longMessage'] ) ;
				$oPaymentFolder->bindValue( ':result_shortMessage', $aPaymentRecordId['result']['shortMessage'] ) ;
				$oPaymentFolder->execute() ;
			}
		}
		return $aPaymentRecordId ;
	}
	
	public function validationStep1()
	{
		/*
		 * Vérifie le contenue des donné envoyé par la requette ajax
		 * de Step1, si le contenue est valide il est sauvegarder en 
		 * session puis on envoie l'utilisateur sur la page Step2
		 */
		// Vérifie les champs vide
		$aReturn = array() ;
		$_SESSION['aProduct'] = array() ;
		if ($_POST['CGV']=='false') $aReturn['CGV'] = 1 ;
		else $aReturn['CGV'] = 0 ;
		// Vérifie le contenue du Mail
		if ( ( empty( $_POST['sMail'] ) )
			|| ( !StrModel::isMail( $_POST['sMail'] ) ) )
				$aReturn['sMail'] = 1 ;
		else $aReturn['sMail'] = 0 ;
		if ( $_POST['sMail'] != $_POST['sMail2'] ) $aReturn['sMail'] = 1 ;
		// Vérifie le contenue du numéro Portable
		if ( empty( $_POST['sPortable'] ) ) $aReturn['sPortable'] = 1 ;
		$_POST['sPortable'] = StrModel::is_NumPortable( $_POST['sPortable'] ) ;
		if (!$_POST['sPortable']) $aReturn['sPortable'] = 1 ;
		else $aReturn['sPortable'] = 0 ;
		/*
		 * Si un champs n'est pas correct on stop l'analyse
		 * ici et renvoie le contenue des erreur
		 */
		foreach( $aReturn as $iValue )
		{
			// Si on trouve au moins une iValue à  1 alors on stop
			if ($iValue==1) return $aReturn ;
		}
		/*
		 * Sauvegarde les donné envoyé dans la table bo_user_temp
		 * ceci permet de relancer les utilisateur qui n'on pas fini leurs abonnement
		 * (uniquement pour les user B2C)
		 */
		$oResidence = new ResidenceModel() ;
		$aResidence = $oResidence->getResidence() ;
		if ($aResidence['mode']=='b2c')
		{
			// Déléte les entré de rappelle déjà  existante
			$oUserTemp = $this->oPDO->prepare('DELETE FROM bo_user_temp WHERE mail=:mail OR portable=:portable') ;
			$oUserTemp->bindValue( ':mail', $_POST['sMail'] ) ;
			$oUserTemp->bindValue( ':portable', $_POST['sPortable'] ) ;
			$oUserTemp->execute() ;
			// Enregistre le rappel
			$oUserTemp = $this->oPDO->prepare('INSERT INTO bo_user_temp SET registered="'.date('Y-m-d').'", mail=:mail, portable=:portable') ;
			$oUserTemp->bindValue( ':mail', $_POST['sMail'] ) ;
			$oUserTemp->bindValue( ':portable', $_POST['sPortable'] ) ;
			$oUserTemp->execute() ;
		}
		/*
		 * Sauvegarde les donné pour l'étape 2
		 */
		$_SESSION['aUser']['mail'] = $_POST['sMail'] ;
		$_SESSION['aUser']['portable'] = $_POST['sPortable'] ;
		/*
		 * Récupà¨re la listes des produit autorisé pour cet utiliateur
		 * puis analyse dans les donnée envoyé uniquement celle correspondante
		 * (évite le fraudes)
		 */
		$aProduct = $oResidence->getProduct() ;
		// Déconnexion SQL
		$oResidence->oPDO = NULL ;
		/*
		 * Listes les produits proposé pour cette résidence 
		 * et remanie la liste pour l'utiliser plus facilement
		 */
		$aPID = array() ;
		foreach( $aProduct as $iKey => $aValue )
		{
			$iPID = $aValue['PID'] ;
			$aPID[$iPID] = $aValue ;
		}
		/*
		 * Vérifie chaque options souscrit à  l'abonnement
		 */
		$_SESSION['aProduct'] = array() ;
		if ( (isset($aPID[1])) && (isset($aPID[2])) )
		{
			/*
			 * Cette utilisateur à  le choix entre les deux abonnement
			 * On vérifie celui qu'il a choisis, si il y a une fraude
			 * (tentative de validation sans choix d'abonnement)
			 * on force l'abonnement 12 mois
			 */
			if ( (isset($_POST['PID2'])) && ($_POST['PID2']=='true') )
			{
				$_SESSION['aProduct'][1] = false ;
				$_SESSION['aProduct'][2] = true ;
			}
			else 
			{
				$_SESSION['aProduct'][1] = true ;
				$_SESSION['aProduct'][2] = false ;
			}
		}
		else if ( (isset($aPID[1])) && (!isset($aPID[2])) )
		{
			/*
			 * Cette utilisateur n'a pas le choix d'abonnement
			 * donc on lui souscrit obligatoirement un abonnement
			 * de 12 mois
			 */
			$_SESSION['aProduct'][1] = true ;
			$_SESSION['aProduct'][2] = false ;
		}
		else
		{
			/*
			 * Cet utilisateur n'a pas d'abonnement internet disponible
			 * (Utilisateur B2B)
			 */
			$_SESSION['aProduct'][1] = false ;
			$_SESSION['aProduct'][2] = false ;			
		}
		// Si la résidence comprends des frais d'inscription obligatoire
		if (isset($aPID[3])) $_SESSION['aProduct'][3] = true ;
		else $_SESSION['aProduct'][3] = false ;
		// Clé WiFi
		if ( (isset($aPID[4])) && ($_POST['PID4']=='true') ) $_SESSION['aProduct'][4] = true ;
		else $_SESSION['aProduct'][4] = false ;
		// Antivirus
		if ( (isset($aPID[5])) && ($_POST['PID5']=='true') ) $_SESSION['aProduct'][5] = true ;
		else $_SESSION['aProduct'][5] = false ;
		// Contrà´le Parental
		if ( (isset($aPID[6])) && ($_POST['PID6']=='true') ) $_SESSION['aProduct'][6] = true ;
		else $_SESSION['aProduct'][6 ] = false ;
		return $aReturn ;
	}
	
	public function validationStep2()
	{
		/*
		 * Vérifie tout les champs vide
		 */
		// Civilité
		if (empty($_POST['sCivilite'])) $aReturn['sCivilite'] = 1 ;
		else $aReturn['sCivilite'] = 0 ;
		// Nom
		if (empty($_POST['sNom'])) $aReturn['sNom'] = 1 ;
		else if (!StrModel::strMinLen($_POST['sNom'], 3)) $aReturn['sNom'] = 1 ;
		else $aReturn['sNom'] = 0 ;
		// Prénom
		if (empty($_POST['sPrenom'])) $aReturn['sPrenom'] = 1 ;
		else if (!StrModel::strMinLen($_POST['sPrenom'], 3)) $aReturn['sPrenom'] = 1 ;
		else $aReturn['sPrenom'] = 0 ;
		// Adresse
		if (empty($_POST['sAdresse'])) $aReturn['sAdresse'] = 1 ;
		else if (!StrModel::strMinLen($_POST['sAdresse'], 7)) $aReturn['sAdresse'] = 1 ;
		else $aReturn['sAdresse'] = 0 ;
		// Zipcode
		if (empty($_POST['sZipcode'])) $aReturn['sZipcode'] = 1 ;
		else if (!StrModel::strMinLen($_POST['sZipcode'], 5)) $aReturn['sZipcode'] = 1 ;
		else if (!StrModel::strMaxLen($_POST['sZipcode'], 5)) $aReturn['sZipcode'] = 1 ;
		else if (!StrModel::isNum($_POST['sZipcode'])) $aReturn['sZipcode'] = 1 ;
		else $aReturn['sZipcode'] = 0 ;
		// Ville
		if (empty($_POST['sVille'])) $aReturn['sVille'] = 1 ;
		else if (!StrModel::strMinLen($_POST['sVille'], 2)) $aReturn['sVille'] = 1 ;
		else $aReturn['sVille'] = 0 ;
		$aReturn['sBirth'] = 0 ;
		// Birth Day
		if (empty($_POST['sBirthDay'])) $aReturn['sBirth'] = 1 ;
		// Birth Month
		if (empty($_POST['sBirthMonth'])) $aReturn['sBirth'] = 1 ;
		// Birth Year
		if (empty($_POST['sBirthYear'])) $aReturn['sBirth'] = 1 ;
		// Fai
		if (empty($_POST['sFai'])) $aReturn['sFai'] = 1 ;
		else $aReturn['sFai'] = 0 ;
		// Mobile
		if (empty($_POST['sMobile'])) $aReturn['sMobile'] = 1 ;
		else $aReturn['sMobile'] = 0 ;
		// Activite
		if (empty($_POST['sActivite'])) $aReturn['sActivite'] = 1 ;
		else $aReturn['sActivite'] = 0 ;
		// Nom Banque
		if (empty($_POST['sNomBanque'])) $aReturn['sNomBanque'] = 1 ;
		else if (!StrModel::strMinLen($_POST['sNomBanque'], 3)) $aReturn['sNomBanque'] = 1 ;
		else $aReturn['sNomBanque'] = 0 ;
		// Adresse Banque
		if (empty($_POST['sAdresseBanque'])) $aReturn['sAdresseBanque'] = 1 ;
		else if (!StrModel::strMinLen($_POST['sAdresseBanque'], 5)) $aReturn['sAdresseBanque'] = 1 ;
		else $aReturn['sAdresseBanque'] = 0 ;
		// Ville Banque
		if (empty($_POST['sVilleBanque'])) $aReturn['sVilleBanque'] = 1 ;
		else if (!StrModel::strMinLen($_POST['sVilleBanque'], 3)) $aReturn['sVilleBanque'] = 1 ;
		else $aReturn['sVilleBanque'] = 0 ;
		// Zipcode Banque
		if (empty($_POST['sZipcodeBanque'])) $aReturn['sZipcodeBanque'] = 1 ;
		else if (!StrModel::strMinLen($_POST['sZipcodeBanque'], 5)) $aReturn['sZipcodeBanque'] = 1 ;
		else if (!StrModel::strMaxLen($_POST['sZipcodeBanque'], 5)) $aReturn['sZipcodeBanque'] = 1 ;
		else if (!StrModel::isNum($_POST['sZipcodeBanque'])) $aReturn['sZipcodeBanque'] = 1 ;
		else $aReturn['sZipcodeBanque'] = 0 ;
		// Code Banque
		if (empty($_POST['sCodeBanque'])) $aReturn['sCodeBanque'] = 1 ;
		else if (!StrModel::strMinLen($_POST['sCodeBanque'], 5)) $aReturn['sCodeBanque'] = 1 ;
		else if (!StrModel::strMaxLen($_POST['sCodeBanque'], 5)) $aReturn['sCodeBanque'] = 1 ;
		else $aReturn['sCodeBanque'] = 0 ;
		// Code Guichet
		if (empty($_POST['sCodeGuichet'])) $aReturn['sCodeGuichet'] = 1 ;
		else if (!StrModel::strMinLen($_POST['sCodeGuichet'], 5)) $aReturn['sCodeGuichet'] = 1 ;
		else if (!StrModel::strMaxLen($_POST['sCodeGuichet'], 5)) $aReturn['sCodeGuichet'] = 1 ;
		else $aReturn['sCodeGuichet'] = 0 ;
		// Numéro de Compte
		if (empty($_POST['sNumeroCompte'])) $aReturn['sNumeroCompte'] = 1 ;
		else if (!StrModel::strMinLen($_POST['sNumeroCompte'], 11)) $aReturn['sNumeroCompte'] = 1 ;
		else if (!StrModel::strMaxLen($_POST['sNumeroCompte'], 11)) $aReturn['sNumeroCompte'] = 1 ;
		else $aReturn['sNumeroCompte'] = 0 ;
		// Clé Rib
		if (empty($_POST['sCleRib'])) $aReturn['sCleRib'] = 1 ;
		else if (!StrModel::strMinLen($_POST['sCleRib'], 2)) $aReturn['sCleRib'] = 1 ;
		else if (!StrModel::strMaxLen($_POST['sCleRib'], 2)) $aReturn['sCleRib'] = 1 ;
		else $aReturn['sCleRib'] = 0 ;
		// Validation du RIB
		if (!RibModel::verifierRib( $_POST['sCodeBanque'], $_POST['sCodeGuichet'], $_POST['sNumeroCompte'], $_POST['sCleRib'])) $aReturn['sValidRib'] = 1 ;
		else $aReturn['sValidRib'] = 0 ;
		/*
		 * Si une erreur est retourné pour l'un des champs, on stop l'opération et renvoie le tableau de résultat
		 */
		foreach( $aReturn as $iValue )
		{
			if ($iValue==1) return $aReturn ;
		}
		/*
		 * Enregistre les données de l'utilisateur et créer le portefeuil
		 * Si l'utilisateur ne valide pas son portefeuil, les donnée seron supprimé
		 * L'enregistrement se fais avant la création du token, car pour créer le token
		 * il faut connaitre l'user ID (UID) qui va etre attribué en créant le compte
		 */
		$_SESSION['aUserInfo']['nom'] = strtoupper( $_POST['sNom'] ) ;
		$_SESSION['aUserInfo']['civilite'] = $_POST['sCivilite'] ;
		$_SESSION['aUserInfo']['prenom'] = ucfirst( strtolower( $_POST['sPrenom'] ) ) ;
		if ($_POST['sBirthMonth']<10) $_POST['sBirthMonth'] = '0' . $_POST['sBirthMonth'] ;
		if ($_POST['sBirthDay']<10) $_POST['sBirthDay'] = '0' . $_POST['sBirthDay'] ;
		$_SESSION['aUserInfo']['birthday'] = $_POST['sBirthYear'] . '-' . $_POST['sBirthMonth'] . '-' . $_POST['sBirthDay'] ;
		$_SESSION['aUserInfo']['fai'] = $_POST['sFai'] ;
		$_SESSION['aUserInfo']['mobile'] = $_POST['sMobile'] ;
		$_SESSION['aUserInfo']['metier'] = $_POST['sActivite'] ;
		$_SESSION['aUserAdresse']['adresse'] = $_POST['sAdresse'] ;
		$_SESSION['aUserAdresse']['zipcode'] = $_POST['sZipcode'] ;
		$_SESSION['aUserAdresse']['ville'] = $_POST['sVille'] ;
		$_SESSION['aUserRib']['nomBanque'] = $_POST['sNomBanque'] ;
		$_SESSION['aUserRib']['adresseBanque'] = $_POST['sAdresseBanque'] ;
		$_SESSION['aUserRib']['villeBanque'] = $_POST['sVilleBanque'] ;
		$_SESSION['aUserRib']['codeBanque'] = $_POST['sCodeBanque'] ;
		$_SESSION['aUserRib']['zipcodeBanque'] = $_POST['sZipcodeBanque'] ;
		$_SESSION['aUserRib']['codeBanque'] = $_POST['sCodeBanque'] ;
		$_SESSION['aUserRib']['codeGuichet'] = $_POST['sCodeGuichet'] ;
		$_SESSION['aUserRib']['numeroCompte'] = $_POST['sNumeroCompte'] ;
		$_SESSION['aUserRib']['cleRib'] = $_POST['sCleRib'] ;
		$oResidence = new ResidenceModel() ;
		$aResidence = $oResidence->getResidence() ;
		// Enregistrement des données bo_user
		$oUser = $this->oPDO->prepare('INSERT INTO bo_user SET registered="'.date('Y-m-d').'", RID=:RID, pass=:pass, mail=:mail, portable=:portable') ;
		$oUser->bindValue( ':pass', StrModel::generatePass(8) );
		$oUser->bindValue( ':mail', $_SESSION['aUser']['mail'] ) ;
		$oUser->bindValue( ':portable', $_SESSION['aUser']['portable'] ) ;
		$oUser->bindValue( ':RID', $aResidence['RID'] ) ;
		$oUser->execute() ;
		// Sauvegarde du nouveau UID associé à  cet user
		$_SESSION['iUID'] = $this->oPDO->lastInsertId() ;
		// Enregistrement des donné dans bo_user_info
		$oUserInfo = $this->oPDO->prepare('INSERT INTO bo_user_info SET UID="'.$_SESSION['iUID'].'", civilite=:civilite, nom=:nom, prenom=:prenom, metier=:metier, fai=:fai, mobile=:mobile, birthday=:birthday') ;
		$oUserInfo->bindValue( ':civilite', $_SESSION['aUserInfo']['civilite'] );
		$oUserInfo->bindValue( ':nom', $_SESSION['aUserInfo']['nom'] );
		$oUserInfo->bindValue( ':prenom', $_SESSION['aUserInfo']['prenom'] );
		$oUserInfo->bindValue( ':metier', $_SESSION['aUserInfo']['metier'] );
		$oUserInfo->bindValue( ':fai', $_SESSION['aUserInfo']['fai'] );
		$oUserInfo->bindValue( ':mobile', $_SESSION['aUserInfo']['mobile'] );
		$oUserInfo->bindValue( ':birthday', $_SESSION['aUserInfo']['birthday'] );
		$oUserInfo->execute() ;
		// Enregistrement des donné dans bo_user_adresse
		$oUserAdresse = $this->oPDO->prepare('INSERT INTO bo_user_adresse SET UID="'.$_SESSION['iUID'].'", adresse=:adresse, zipcode=:zipcode, ville=:ville') ;
		$oUserAdresse->bindValue( ':adresse', $_SESSION['aUserAdresse']['adresse'] ) ;
		$oUserAdresse->bindValue( ':zipcode', $_SESSION['aUserAdresse']['zipcode'] ) ;
		$oUserAdresse->bindValue( ':ville', $_SESSION['aUserAdresse']['ville'] ) ;
		$oUserAdresse->execute() ;
		// Enregistrement des donné dans bo_user_rib
		$oUserRib = $this->oPDO->prepare('INSERT INTO bo_user_rib SET UID="'.$_SESSION['iUID'].'", nomBanque=:nomBanque, adresseBanque=:adresseBanque, villeBanque=:villeBanque, zipcodeBanque=:zipcodeBanque, codeBanque=:codeBanque, codeGuichet=:codeGuichet, numeroCompte=:numeroCompte, cleRib=:cleRib') ;
		$oUserRib->bindValue( ':nomBanque', $_SESSION['aUserRib']['nomBanque'] ) ;
		$oUserRib->bindValue( ':adresseBanque', $_SESSION['aUserRib']['adresseBanque'] ) ;
		$oUserRib->bindValue( ':villeBanque', $_SESSION['aUserRib']['villeBanque'] ) ;
		$oUserRib->bindValue( ':zipcodeBanque', $_SESSION['aUserRib']['zipcodeBanque'] ) ;
		$oUserRib->bindValue( ':codeBanque', $_SESSION['aUserRib']['codeBanque'] ) ;
		$oUserRib->bindValue( ':codeGuichet', $_SESSION['aUserRib']['codeGuichet'] ) ;
		$oUserRib->bindValue( ':numeroCompte', $_SESSION['aUserRib']['numeroCompte'] ) ;
		$oUserRib->bindValue( ':cleRib', $_SESSION['aUserRib']['cleRib'] ) ;
		$oUserRib->execute() ;
		$oProduct = $this->oPDO->prepare('INSERT INTO') ;
		// Demande à  Payline de créer le portefeuille
		$aWebWallet = $this->createWebWalletFromSession() ;
		
		if ($aWebWallet['result']['code']=='00000')
		{
			/*
			 * Sauvegarde le tolken avec la liste de produit lié dans la base
			 * 1) Créer le dossier de payment dans notre base avec comme paymentRecordId le numéro de tolken
			 * 		ce numéro de tolken sera remplacé par le vrai paymentRecordId aprà¨s création du dossier chez payline
			 * 2) Enregistre la liste des produit avec comme paymentRecordId le numéro de tolken, qui sera remplacé
			 * 		comme pour l'étape 1)
			 * 3) Sauvegarde le numéro du token pour pouvoir supprimer toutes les données lié en cas de retour négatif de payline
			 */
			// Créer le dossier de payment dans bo_payment_folder
			$sOrder = $_SESSION['iUID'] ;
			foreach( $_SESSION['aProduct'] as $iPID => $bValue )
			{
				if ($bValue)
				{
					$sOrder .= '-' . $iPID ;
					$aProduct = $oResidence->getProductInfo( $iPID ) ;
					// Si le precurrentDureeLeader est à  1, la durée d'abonnement de se produit se duplique sur tout les produit qui n'on pas de durée définie
					$iRecurrentDuree = ($aProduct['recurrentDureeLeader']==1) ? $aProduct['recurrentDuree'] : $iRecurrentDuree ;
					$oProduct = $this->oPDO->prepare('INSERT INTO bo_payline_folder_product SET UID=:UID, paymentRecordId=:paymentRecordId, createDate=:createDate, name=:name, description=:description, price=:price, priceFirst=:priceFirst, recurrent=:recurrent, recurrentDuree=:recurrentDuree, recurrentEngagement=:recurrentEngagement') ;
					$oProduct->bindValue( ':UID', $_SESSION['iUID'] ) ;
					$oProduct->bindValue( ':paymentRecordId', $aWebWallet['token'] ) ;
					$oProduct->bindValue( ':createDate', date('Y-m-d') ) ;
					$oProduct->bindValue( ':name', $aProduct['name'] ) ;
					$oProduct->bindValue( ':description', $aProduct['description'] ) ;
					$oProduct->bindValue( ':price', $aProduct['price'] ) ;
					$oProduct->bindValue( ':priceFirst', $aProduct['priceFirst'] ) ;
					$oProduct->bindValue( ':recurrent', $aProduct['recurrent'] ) ;
					if ($aProduct['recurrent']==1) $oProduct->bindValue( ':recurrentDuree', $iRecurrentDuree ) ;
					else $oProduct->bindValue( ':recurrentDuree', 0 ) ;
					$oProduct->bindValue( ':recurrentEngagement', $aProduct['recurrentEngagement'] ) ;
					$oProduct->execute() ;
					
				}
				
			}
			// Sauvegarde le dossier de payment dans bo_payment_folder
			$oPaymentFolder = $this->oPDO->prepare('INSERT INTO bo_payline_folder SET UID=:UID, contractNumber=:contractNumber, paymentRecordId=:paymentRecordId, walletId=:walletId, reforder=:reforder') ;
			$oPaymentFolder->bindValue( ':UID', $_SESSION['iUID'] ) ;
			$oPaymentFolder->bindValue( ':contractNumber', CONTRACT_NUMBER ) ;
			$oPaymentFolder->bindValue( ':walletId', $_SESSION['iUID'] ) ;
			$oPaymentFolder->bindValue( ':paymentRecordId', $aWebWallet['token'] ) ;
			$oPaymentFolder->bindValue( ':reforder', $sOrder ) ;
			$oPaymentFolder->execute() ;
			
			// Sauvegarde le portefeuille
			$oPaymentWallet = $this->oPDO->prepare('INSERT INTO bo_payline_wallet SET UID=:UID, walletId=:walletId, createDate=:createDate, lastName=:lastName, firstName=:firstName, email=:email, result_code=:result_code, result_shortMessage=:result_shortMessage, result_longMessage=:result_longMessage, shippingAddress_name=:shippingAddress_name, shippingAddress_street1=:shippingAddress_street1, shippingAddress_zipCode=:shippingAddress_zipCode, shippingAddress_cityName=:shippingAddress_cityName, shippingAddress_country=:shippingAddress_country, shippingAddress_phone=:shippingAddress_phone') ;
			$oPaymentWallet->bindValue( ':UID', $_SESSION['iUID'] ) ;
			$oPaymentWallet->bindValue( ':walletId', $_SESSION['iUID'] ) ;
			$oPaymentWallet->bindValue( ':createDate', date('Y-m-d') ) ;
			$oPaymentWallet->bindValue( ':lastName', $_SESSION['aUserInfo']['nom'] ) ;
			$oPaymentWallet->bindValue( ':firstName', $_SESSION['aUserInfo']['prenom'] ) ;
			$oPaymentWallet->bindValue( ':email', $_SESSION['aUser']['mail'] ) ;
			$oPaymentWallet->bindValue( ':result_code', $aWebWallet['result']['code'] ) ;
			$oPaymentWallet->bindValue( ':result_shortMessage', $aWebWallet['result']['shortMessage'] ) ;
			$oPaymentWallet->bindValue( ':result_longMessage', $aWebWallet['result']['longMessage'] ) ;
			$oPaymentWallet->bindValue( ':shippingAddress_name', 'Facturation' ) ;
			$oPaymentWallet->bindValue( ':shippingAddress_street1', $_SESSION['aUserAdresse']['adresse'] ) ;
			$oPaymentWallet->bindValue( ':shippingAddress_zipCode', $_SESSION['aUserAdresse']['zipcode'] ) ;
			$oPaymentWallet->bindValue( ':shippingAddress_country', 'France' ) ;
			$oPaymentWallet->bindValue( ':shippingAddress_cityName', $_SESSION['aUserAdresse']['ville'] ) ;
			$oPaymentWallet->bindValue( ':shippingAddress_phone', $_SESSION['aUser']['portable'] ) ;
			$oPaymentWallet->execute() ;
			
			$this->oPDO->query('INSERT INTO bo_payline_token SET UID="'.$_SESSION['iUID'].'", token="'.$aWebWallet['token'].'"') ;
			
			/*
			 * Supprime toutes les variables de session qui ne sont plus nécéssaire une fois à ce stade
			 */
			unset($_SESSION['iUID']) ;
			unset($_SESSION['aUser']) ;
			unset($_SESSION['aUserInfo']) ;
			unset($_SESSION['aUserAdresse']) ;
			unset($_SESSION['aUserRib']) ;
			unset($_SESSION['aProduct']) ;
			
			// Envoie le retour
			$aReturn['sPaymentUrl'] = $aWebWallet['redirectURL'] ;
		}
		// Si payline renvoie un code d'erreur pour la création du portefeuille on annule tout
		else
		{
			/*
			 * La création du portefeuille à  échoué, on supprime toutes les données de 
			 * l'utilisateur et on lui renvoie un message d'erreur
			 */
			$this->oPDO->query('DELETE FROM bo_user_rib WHERE UID="'.$_SESSION['iUID'].'"') ;
			$this->oPDO->query('DELETE FROM bo_user_adresse WHERE UID="'.$_SESSION['iUID'].'"') ;
			$this->oPDO->query('DELETE FROM bo_user_info WHERE UID="'.$_SESSION['iUID'].'"') ;
			$this->oPDO->query('DELETE FROM bo_user WHERE UID="'.$_SESSION['iUID'].'"') ;
			unset($_SESSION['iUID']) ;
			unset($_SESSION['aUser']) ;
			unset($_SESSION['aUserInfo']) ;
			unset($_SESSION['aUserAdresse']) ;
			unset($_SESSION['aUserRib']) ;
			unset($_SESSION['aProduct']) ;
			$aReturn['sPaymentUrl'] = '0' ;
		}

		return $aReturn ;
	}
	
	public function calcAbonnement( $iPaymentRecordId )
	{
		$aAbonnement = array() ;
		
		$aProduct = $this->oPDO->query('SELECT * FROM bo_payline_folder_product WHERE paymentRecordId="'.$iPaymentRecordId.'" ORDER BY PFPID ASC')->fetchAll(PDO::FETCH_ASSOC) ;
		
		$aAbonnement['iRecurrentDuree'] = 0 ;
		$aAbonnement['iRecurrentPrice'] = 0 ;
		$aAbonnement['iPriceFirst'] = 0 ;
		
		foreach( $aProduct as $iKey => $aValue )
		{
			if ($aValue['recurrentDuree']>$aAbonnement['iRecurrentDuree']) $aAbonnement['iRecurrentDuree'] = $aValue['recurrentDuree'] ;
			if ($aValue['recurrent']==1) $aAbonnement['iRecurrentPrice'] += $aValue['price'] ;
			$aAbonnement['iPriceFirst'] += ($aValue['priceFirst']==0) ? $aValue['price'] : $aValue['priceFirst'] ;
		}
		
		$aAbonnement['iTotalPrice'] = $aAbonnement['iPriceFirst'] + ( $aAbonnement['iRecurrentPrice'] * ( $aAbonnement['iRecurrentDuree'] - 1 ) ) ;
		
		return $aAbonnement ;
	}
	
	public function createNewAbonnementFromToken()
	{
		/*
		 * Récupère les données de la table bo_payline_token et intéroge payline pour savoir ce qu'il en est
		 */
		$oPayline = new paylineSDK() ;
		$aToken = $this->oPDO->query('SELECT * FROM bo_payline_token ORDER BY PTID ASC LIMIT 0,1')->fetch(PDO::FETCH_ASSOC) ;
		if (!$aToken) return false ;
		/*
		 * Intérogge Payline sur le token, si ok on créer le dossier de payment
		 * Si token en attente on ne fais rien
		 * Si echec du portefeuille on supprime toutes donné associé
		 */
		// Cet appelle ne vise QUE à stoper la notification de Payline
		$aPaylineWallet = $oPayline->get_WebWallet( $aToken['token'] ) ;
		/*
		 * Si le code indique que le token est en attente, on retourne true
		 * il faudra vérifier à nouveau dans 1 minutes,
		 * sinon on continue
		 */
		// Si code = 02306, l'utilisateur na pas terminé de taper ses donnée de CB
		if ($aPaylineWallet['result']['code']=='02306')	return true ;
		// Récupère les information sur le portefeuille
		$aPaylineWallet = $this->getPaylineWallet( $aToken['UID'] ) ;
		/*
		 * Le portefeuil éxiste, on créer le dossier de paiement
		 */
		if ( ($aPaylineWallet['result']['code']=='02500') || ($aPaylineWallet['result']['code']=='02501') )
		{
			/*
			 * Récupére les données nécéssaire
			 */
			$aPaymentFolder = $this->oPDO->query('SELECT * FROM bo_payline_folder WHERE paymentRecordId="'.$aToken['token'].'"')->fetch(PDO::FETCH_ASSOC) ;
			/*
			 * Calcule le montant de l'abonnement et la durée
			 */
			$aAbonnement = $this->calcAbonnement( $aToken['token'] ) ;
			
			// PAYMENT
			$aParam['payment']['amount'] = $aAbonnement['iTotalPrice'] ; // Montant total
			$aParam['payment']['currency'] = PAYMENT_CURRENCY ;
			$aParam['payment']['action'] = PAYMENT_ACTION ;
			$aParam['payment']['mode'] =  PAYMENT_MODE ;
			$aParam['payment']['contractNumber'] =  CONTRACT_NUMBER ;
			$aParam['payment']['differedActionDate'] = CONTRACT_NUMBER_LIST ; 
			
			// ORDER
			$aParam['orderRef'] = $aPaymentFolder['reforder'] ;
			$aParam['orderDate'] = date('d/m/Y H:m') ;
			 
			//ORDER
			$aParam['order']['ref'] = $aPaymentFolder['reforder'] ;
			$aParam['order']['origin'] = '' ;
			$aParam['order']['country'] = 'FR' ;
			$aParam['order']['taxes'] = round( $aAbonnement['iTotalPrice'] * 0.196 ) ;
			$aParam['order']['amount'] = $aAbonnement['iTotalPrice'] ;
			$aParam['order']['date'] = date('d/m/Y H:m') ;
			$aParam['order']['currency'] = ORDER_CURRENCY ;
			 
			// WALLET ID
			$aParam['walletId'] = $aToken['UID'] ;
			 
			// scheduled
			$aParam['scheduled'] = '' ;
			 
			// RECCURENT	
			$aParam['recurring']['firstAmount'] = $aAbonnement['iPriceFirst'] ;
			$aParam['recurring']['amount'] = $aAbonnement['iRecurrentPrice'] ;
			$aParam['recurring']['billingCycle'] = 40 ;
			$aParam['recurring']['billingLeft'] = $aAbonnement['iRecurrentDuree'] ;
			$aParam['recurring']['billingDay'] = 5 ;
			$aParam['recurring']['startDate'] = '' ;
			
			// EXECUTE
			$aRecurrentPayment = $oPayline->do_recurrent_wallet_payment($aParam);
			
			// Si ce n'est pas bon on donne l'ordre de tout supprimer
			if ( ($aRecurrentPayment['result']['code']!='02500') || ($aRecurrentPayment['result']['code']!='02501') ) $bNeedDelete = true ;
			else
			{
				/*
				 * Le dossier de payment est créer,
				 * on modifie tout les paymentRecordId pour remplacer le numéro de token par le
				 * véritable paymentRecordId
				 */
				$this->oPDO->query('UPDATE bo_payline_folder SET paymentRecordId="'.$aRecurrentPayment['paymentRecordId'].'" WHERE paymentRecordId="'.$aToken['token'].'"') ;
				$this->getPaymentRecord( $aRecurrentPayment['paymentRecordId'] ) ;
				$this->oPDO->query('UPDATE bo_payline_folder_product SET paymentRecordId="'.$aRecurrentPayment['paymentRecordId'].'" WHERE paymentRecordId="'.$aToken['token'].'"') ;
				$this->oPDO->query('UPDATE bo_payline_token WHERE token="'.$aToken['token'].'"') ;
				$this->oPDO->query('DELETE FROM bo_payline_token WHERE token="'.$aToken['token'].'"') ;
				$bNeedDelete = false ;
			}
		}
		else $bNeedDelete = true ;
		if ($bNeedDelete) 
		{
			/*
			 * Le portefeuille n'existe pas, on supprime toutes les donné lié
			 */
			$this->oPDO->query('DELETE FROM bo_user_rib WHERE UID="'.$aToken['UID'].'"') ;
			$this->oPDO->query('DELETE FROM bo_user_adresse WHERE UID="'.$aToken['UID'].'"') ;
			$this->oPDO->query('DELETE FROM bo_user_info WHERE UID="'.$aToken['UID'].'"') ;
			$this->oPDO->query('DELETE FROM bo_user WHERE UID="'.$aToken['UID'].'"') ;
			$this->oPDO->query('DELETE FROM bo_payline_wallet WHERE UID="'.$aToken['UID'].'"') ;
			$this->oPDO->query('DELETE FROM bo_payline_folder WHERE paymentRecordId="'.$aToken['token'].'"') ;
			$this->oPDO->query('DELETE FROM bo_payline_folder_product WHERE paymentRecordId="'.$aToken['token'].'"') ;
			$this->oPDO->query('DELETE FROM bo_payline_token WHERE paymentRecordId="'.$aToken['token'].'"') ;
		}
		return true ;
	}

	public function createWebWalletFromSession()
	{
		/*
		 * Créer un portefeuille pour un utilisateur en allant
		 * chercher dans les tables toutes les valeur correspondante,
		 * l'utilisateur n'a plus cas tapé les informations de sa carte
		 * qui sont associé à   màªme token chez payline et dans nos table
		 */
		$oPaylineSDK = new paylineSDK() ;
		// Sécurité contre wallet sans UID
		if (!isset($_SESSION['iUID'])) return false ;
		/*
		 * Paramà¨tre Payline
		 */
		$aParam['contractNumber'] = CONTRACT_NUMBER ;
		$aParam['contracts'] = CONTRACT_NUMBER_LIST ;
		$aParam['updatePersonalDetails'] = 0 ;
		// Information sur le client
		$aParam['buyer']['lastName'] = $_SESSION['aUserInfo']['nom'] ;
		$aParam['buyer']['firstName'] = $_SESSION['aUserInfo']['prenom'] ;
		$aParam['buyer']['walletId'] = $_SESSION['iUID'];
		$aParam['buyer']['email'] = $_SESSION['aUser']['mail'] ;
		$aParam['buyer']['accountCreateDate'] = date('d/m/y') ;
		/*
		 * Option désactivé:
		 * $aParam['buyer']['accountAverageAmount'] = '' ;
		 * $aParam['buyer']['accountOrderCount'] = '' ;
		 */
		// Adresse du client
		$aParam['address']['name'] =  'Adresse de facturation' ;
		$aParam['address']['street1'] = $_SESSION['aUserAdresse']['adresse'] ;
		$aParam['address']['street2'] = '' ;
		$aParam['address']['cityName'] = $_SESSION['aUserAdresse']['ville'];
		$aParam['address']['zipCode'] = $_SESSION['aUserAdresse']['zipcode'];
		$aParam['address']['country'] = 'France' ;
		$aParam['address']['phone'] =  $_SESSION['aUser']['portable'] ;
		
		// Définission des URL de retour et du mode SSL
		$aParam['notificationURL'] = NOTIFICATION_URL ;
		$aParam['returnURL'] = RETURN_URL ;
		$aParam['cancelURL'] = CANCEL_URL ;
		$aParam['customPaymentPageCode'] = CUSTOM_PAYMENT_PAGE_CODE ;
		$aParam['securityMode'] = SECURITY_MODE ;
		$aParam['languageCode'] = LANGUAGE_CODE ;
		
		// Exécution de l'appelle
		$aResult = $oPaylineSDK->create_WebWallet($aParam);
		// Si aucun retour Payline, on stop la fonction
		if (!isset($aResult)) return false ;

		return $aResult ;
	}
	
	public function abonnementExiste()
	{
		/*
		 * Vérifie si un client à  déjà  créer un dossier d'abonnement
		 * Dans le cas ou un abonnement est en cours on le redirige (actif ou non)
		 * Dans le cas ou un abonnement est terminé en termes de date, on continue
		 * sur la page de souscription d'abonnement
		 */
		// Récupà¨re tout les dossier de l'utilisateur en cours
		$aPaymentRecordId = $this->getAllWalletPaymentRecordId( $_SESSION['UID'] ) ;
		
		/*
		 * Pour chaque dossié de payment récupéré, on vérifie dans la liste des produits associé
		 * si il y en à  qui sont récurent et si oui, si ils ont dépassé ou non la date de fin de contrat
		 */
		// Exécute un traitement sur chaque dossié de payement
		foreach( $aPaymentRecordId as $aValue )
		{
			// Récupére tout les produit lié au dossié $aValue['paymentRecordId']
			$aProduct = $this->getAllProductPaymentRecordId( $aValue['paymentRecordId'] ) ;
			// Vérifie pour chaque produit récupéré si ils sont récurrent et si la date est dépassé ou non
			foreach( $aProduct as $iKey => $aProductDetail )
			{
				/*
				 * On vérifie si la souscription à  ce produit et récurent et encore actif
				 * grace à  isActifRecurrent et si c'est le cas on retourne immédiatement true
				 * ce qui stop toute la fonction car au moins 1 produit à  encore une récurrence,
				 * donc la page d'abonnement dois àªtre bloké...
				 */
				if ($this->isActifRecurrent($aProduct[$iKey])) return true ;
			}
		}
		return false ; // SI true n'a pas était return juske ici, alors aucun abonnement en cours n'existe
	}
	
	public function isActifRecurrent( $aProduct )
	{
		/*
		 * Vérifie pour un Produit situé dans un dossié d'abonnement,
		 * si il est récurrent et si oui, si la date est dépassé ou non
		 * retourne true si le produit et encore actif
		 * retourne false si ce n'est pas le cas
		 * NB: Si le paramétre passé à  cette methode n'est pas un array 
		 * contenant les info du produit, c'est qu'il sagit de l'ID dans la table
		 * dans ce cas on va chercher les info du produit en premier lieu
		 */
		// Récupére les info du produit si nécéssaire
		if (!is_array($aProduct)) $aProduct = $this->oPDO->query('SELECT * FROM bo_payline_folder_product WHERE PFPID="'.$aProduct.'"')->fetch();
		// Si produit récurrent
		if ($aProduct['recurrent']=='1')
		{
			// Récupére la date du dernier jour de ce mois
			$sDateToday = date( 'Y-m-d', strtotime( '+1 month -' . date('d') . ' day' ) ) ;
			// Récupà¨re la date de fin du contract
			$aDateStart = explode( '-', $aProduct['createDate'] ) ;
			$sDateEnd = date( 'Y-m-d', mktime( 0, 0, 0, $aDateStart[1]+$aProduct['recurrentDuree'], 0, $aDateStart[0] ) ) ;
			// Explose les deux date pour les comparer avec un mktime			
			$aDateToday = explode( '-', $sDateToday ) ;
			$aDateEnd = explode( '-', $sDateEnd ) ;
			// Récupà¨re le mktime des deux date
			$sMktimeToday = mktime( 0, 0, 0, $aDateToday[1], $aDateToday[2], $aDateToday[0] ) ;
			$sMktimeEnd = mktime( 0, 0, 0, $aDateEnd[1], $aDateEnd[2], $aDateEnd[0] ) ;
			/*
			 * Fais la comparaison, si le $sMktimeEnd < $sMktimeToday, alors
			 * l'abonnement est terminé 
			 */
			if ( $sMktimeEnd < $sMktimeToday ) return false ;
			else return true ;
			
			echo $sMktimeToday ; exit();
		}
		else return false ;
	}
	
	public function getAllProductPaymentRecordId( $sPaymentRecordId )
	{
		/*
		 * Liste tous les produit associé à  un dossié de payement
		 */
		return $this->oPDO->query('SELECT * FROM bo_payline_folder_product WHERE paymentRecordId="'.$sPaymentRecordId.'"')->fetchAll(PDO::FETCH_ASSOC) ;
	}
	
	public function getAllWalletPaymentRecordId( $sWalletId )
	{
		/*
		 * Renvoie sous un tableau la liste de tous les PaymentRecordId
		 * lié à  un walletId qui sont stoqué dans la table
		 */
		return $this->oPDO->query('SELECT paymentRecordId FROM bo_payline_folder WHERE walletId="'.$sWalletId.'"')->fetchAll() ;
	}
	
	public function updateCoolizWallet( $sWalletId, $aPaylineWallet )
	{
		/*
		 * Met à  jour les information du portefeuille dans notre base
		 * Si le portefeuille existe chez Payline
		 * 		1) Il n'existe pas chez nous - on le créer
		 * 		2) Il existe chez nous - on met à  jour
		 * Si il n'existe pas
		 * 		1) Il existe chez nous - on met à  jour
		 * 		2) Il n'existe pas chez nous - on ne fais rien
		 * et génére des mail d'alert si le portefeuille va expirer
		 */
		// Vérifie si le portefeuille existe chez cooliz
		$aCoolizWallet = $this->oPDO->query('SELECT COUNT(*) FROM bo_payline_wallet WHERE walletId='.$sWalletId)->fetch() ;
		// Vérifie si le portefeuille existe ou non chez payline
		if ( ($aPaylineWallet['result']['code']=='02500') || ($aPaylineWallet['result']['code']=='02501') )
		{			
			/*
			 * ICI LE PORTEFEUILLE EXISTE CHEZ PAYLINE
			 * On créer le portefeuille si il n'est pas dans la base de cooliz
			 * Ensuite on met à  jour toutes les donné du portefeuille
			 * à  partir de Payline vers la base de Cooliz
			 */
			if ($aCoolizWallet[0]==0) $this->oPDO->query('INSERT INTO bo_payline_wallet SET createDate="'.date('Y-m-d').'", walletId="'.$sWalletId.'", UID="'.$_SESSION['UID'].'"');
			
			$sSQL = 'isDisabled=:isDisabled
			, result_code=:result_code
			, result_shortMessage=:result_shortMessage
			, result_longMessage=:result_longMessage
			, lastName=:lastName
			, firstName=:firstName
			, email=:email
			, shippingAddress_name=:shippingAddress_name
			, shippingAddress_street1=:shippingAddress_street1
			, shippingAddress_street2=:shippingAddress_street2
			, shippingAddress_cityName=:shippingAddress_cityName
			, shippingAddress_zipCode=:shippingAddress_zipCode
			, shippingAddress_country=:shippingAddress_country
			, shippingAddress_phone=:shippingAddress_phone
			, card_number=:card_number
			, card_type=:card_type
			, card_expirationDate=:card_expirationDate
			, card_cvx=:card_cvx
			, card_ownerBirthdayDate=:card_ownerBirthdayDate
			, card_password=:card_password' ;
			
			$sSQL = 'UPDATE bo_payline_wallet SET ' . $sSQL . ' WHERE walletId="'.$sWalletId.'"' ;

			$oSQL = $this->oPDO->prepare($sSQL) ;
			$oSQL->bindValue( ':isDisabled', $aPaylineWallet['isDisabled'] ) ;
			$oSQL->bindValue( ':result_code', $aPaylineWallet['result']['code'] ) ;
			$oSQL->bindValue( ':result_shortMessage', $aPaylineWallet['result']['shortMessage'] ) ;
			$oSQL->bindValue( ':result_longMessage', $aPaylineWallet['result']['longMessage'] ) ;
			$oSQL->bindValue( ':lastName', $aPaylineWallet['wallet']['lastName'] ) ;
			$oSQL->bindValue( ':firstName', $aPaylineWallet['wallet']['firstName'] ) ;
			$oSQL->bindValue( ':email', $aPaylineWallet['wallet']['email'] ) ;
			$oSQL->bindValue( ':shippingAddress_name', $aPaylineWallet['wallet']['shippingAddress']['name'] ) ;
			$oSQL->bindValue( ':shippingAddress_street1', $aPaylineWallet['wallet']['shippingAddress']['street1'] ) ;
			$oSQL->bindValue( ':shippingAddress_street2', $aPaylineWallet['wallet']['shippingAddress']['street2'] ) ;
			$oSQL->bindValue( ':shippingAddress_cityName', $aPaylineWallet['wallet']['shippingAddress']['cityName'] ) ;
			$oSQL->bindValue( ':shippingAddress_zipCode', $aPaylineWallet['wallet']['shippingAddress']['zipCode'] ) ;
			$oSQL->bindValue( ':shippingAddress_country', $aPaylineWallet['wallet']['shippingAddress']['country'] ) ;
			$oSQL->bindValue( ':shippingAddress_phone', $aPaylineWallet['wallet']['shippingAddress']['phone'] ) ;
			$oSQL->bindValue( ':card_number', $aPaylineWallet['wallet']['card']['number'] ) ;
			$oSQL->bindValue( ':card_type', $aPaylineWallet['wallet']['card']['type'] ) ;
			$oSQL->bindValue( ':card_expirationDate', $aPaylineWallet['wallet']['card']['expirationDate'] ) ;
			$oSQL->bindValue( ':card_cvx', $aPaylineWallet['wallet']['card']['cvx'] ) ;
			$oSQL->bindValue( ':card_ownerBirthdayDate', $aPaylineWallet['wallet']['card']['ownerBirthdayDate'] ) ;
			$oSQL->bindValue( ':card_password', $aPaylineWallet['wallet']['card']['password'] ) ;
			$oSQL->execute() ;
			
			/*
			 * Si le result.code est 02501, la carte va expiré,
			 * on créer une alerte par mail / SMS pour l'utilisateur
			 */
			if ($aPaylineWallet['result']['code']=='02501')
			{
				/*
				$oWarning = new WarningModel() ;
				$oWarning->walletExpire($aParam['walletId']) ;
				$oWarning->oPDO = NULL ;
				*/
			}
			
		}
		else
		{
			/*
			 * ICI LE PORTEFEUILLE NEXISTE PAS CHEZ PAYLINE
			 * Si jamais il est dans la base de Cooliz on
			 * met à  jour le result code et message
			 * mais sans supprimer le portefeuille de notre base 
			 * (il sera donc stoké avec son code inactif mais
			 * les donnée restent consultable pour une raison X ou Y)
			 */
			if ($aCoolizWallet[0]==1)
			{
				$sSQL = 'UPDATE bo_payline_wallet SET result_code=:result_code, result_shortMessage=:result_shortMessage, result_longMessage=:result_longMessage WHERE walletId="'.$sWalletId.'"' ;
				$oSQL = $this->oPDO->prepare($sSQL) ;
				$oSQL->bindValue( ':result_code', $aPaylineWallet['result']['code'] ) ;
				$oSQL->bindValue( ':result_shortMessage', $aPaylineWallet['result']['shortMessage'] ) ;
				$oSQL->bindValue( ':result_longMessage', $aPaylineWallet['result']['longMessage'] ) ;
				$oSQL->execute() ;
			}
		}
	}
	
	private function getPaylineWallet( $sWalletId )
	{
		/*
		 * Récupà¨re les information lié à  un portefeuille
		 * et les met à  jours dans notre base
		 */
		// Définie les paramà¨tre et récupére les donnée
		$aParam['contractNumber'] = CONTRACT_NUMBER ;
		$aParam['walletId'] = $sWalletId ;
		$oPayline = new paylineSDK() ;
		$aPaylineWallet = $oPayline->get_Wallet($aParam) ;
		// Met à  jour les donnée du portefeuil
		$this->updateCoolizWallet($sWalletId, $aPaylineWallet) ;
		// Retourne les donnée du portefeuil
		return $aPaylineWallet ;
	}
}