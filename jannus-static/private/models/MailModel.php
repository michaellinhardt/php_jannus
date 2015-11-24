<?php
class MailModel extends CoreModel
{
	public function contactMail()
	{
		// V�rifie l'adresse mail
		if ( !filter_var( $_POST['sMail'], FILTER_VALIDATE_EMAIL) ) return 1 ;
		// V�rifie le t�l�phone
		$sTel = StrModel::is_NumPortable($_POST['sMobile']) ;
		if (!$sTel) return 2 ;
		if (!StrModel::strMinLen($_POST['sNom'], 2)) return 3 ; // Vérifie le nom
		if (!StrModel::strMinLen($_POST['sPrenom'], 2)) return 4 ; // Vérifie le prénom
		if (!StrModel::strMinLen($_POST['sMessage'], 30)) return 5 ; // Vérifie le message
		// r�cup�ration du mail � contacter
		if ($_POST['sContact']=='commercial')
		{
			$sMail = ConfigModel::get(4,0) ;
			$sLogCat = 2 ;
		}
		else
		{
			$sMail = ConfigModel::get(3,0) ;
			$sLogCat = 1 ;
		}
		
		// Formatage du nom / prénom
		$_POST['sNom'] = strtoupper($_POST['sNom']) ;
		$_POST['sPrenom'] = ucfirst( strtolower($_POST['sPrenom']) ) ;
		$sWho = $_POST['sCivilite'].' '.$_POST['sNom'].' '.$_POST['sPrenom'] ;
		// Log l'action
		LogModel::logThis( $sLogCat, array( 
		$sMail, $_POST['sMail'], $sWho, $_POST['sLogin'], $sTel, $_POST['sMotif'], $_POST['sMessage'] 
		) );
		// Construit le mail
		$aMessage = array(
		'Envoyé depuis le formulaire de contact [ '.$_POST['sContact'].' ]',
		'',
		'Date: '. date('d-m-Y - H:i'),
		'Éméteur: '. $sWho,
		'Login: '. $_POST['sLogin'],
		'Mobile: '.$sTel,
		'Mail: '.$_POST['sMail'],
		'Motif: '.$_POST['sMotif'],
		'',
		'Message:',
		'',
		$_POST['sMessage']
		);
		// Envoie le mail
		if (!$this->sendMail( $sWho, $_POST['sMail'], $_POST['sContact'], 'Support '.$_POST['sContact'], $aMessage )) return 6 ;
		else return 7 ;
	}
	
	public function sendMail( $sEmeteurNom, $sEmeteurMail, $sDestinataireMail, $sSujet, $aMessage )
	{
		/*
		 * Envoie un mail
		 * Le contenue du message est sour forme de tableau, chaque entr� du tableau indique un retour � la ligne
		 * exemple $aMessage = array ( 'Bonjour,', 'Nous vous informons...' );
		 * donne $sMessage = 'Bonjour, \n Nous vous informons...' ;
		 */
		$sHeader ='From: "'.$sEmeteurNom.'"<'.$sEmeteurMail.'>'."\n";
		$sHeader .='Reply-To: '.$sEmeteurMail."\n";
		$sHeader .='Content-Type: text/plain; charset="iso-8859-1"'."\n";
		$sHeader .='Content-Transfer-Encoding: 8bit';
		
		$sMessage = '' ;
		foreach( $aMessage as $sValue )
		{
			$sMessage .= $sValue . "\n" ;
		}
		
		if ( mail( $sDestinataireMail, $sSujet, $sMessage, $sHeader)) return true ;
		else return false ;
	}
}