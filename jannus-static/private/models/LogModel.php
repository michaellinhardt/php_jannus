<?php
class LogModel extends CoreModel
{
	public function logThis( $iLCID, $aValue )
	{
		/*
		 * Innitialise la connexion
		 */
		include CONFIG_PATH . '/DatabaseConfig.php' ;
		$oPDO = new PDO(
			'mysql:host=' . $aDbConfig['host'] . ';dbname=' . $aDbConfig['name'] ,
			$aDbConfig['user'],
			$aDbConfig['pass']
		);
		// Créer la requette SQL
		$sSQL = 'INSERT INTO bo_log_value SET LCID=:LCID' ;
		for( $i = 0 ; $i<10 ; $i++)
		{
			$sSQL .= ', value_' . $i . '=:value_' . $i ;
		}
		$sSQL .= ', ip=:ip, ladate=:ladate' ;
		$oSQL = $oPDO->prepare($sSQL) ;
		// Boucle destiné à logué toutes les value passé
		for( $i = 0 ; $i<10 ; $i++)
		{
			if (isset($aValue[$i]))
				$oSQL->bindValue( ':value_'.$i, $aValue[$i] );
			else
				$oSQL->bindValue( ':value_'.$i, '' );
		}
		// Log l'IP, la date et l'id dans log_detail
		$oSQL->bindValue( ':ladate', date('Y-m-d') );
		$oSQL->bindValue( ':ip', $_SERVER['REMOTE_ADDR'] );
		$oSQL->bindValue( ':LCID', $iLCID );
		// Execute la requette et se déconnect
		$oSQL->execute();
		$oPDO = NULL ; // Déconnexion SQL
	}
}