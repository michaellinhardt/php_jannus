
<?php
class ConfigModel extends CoreModel
{
	/*
	 * Cette class gére la connexion/déconnexion au back office
	 * Ainsi que la liste des droit attribué à un compte
	 * log_detail.LDID = 1 // ID des log de connexion
	 */
	
	public function getconfig( $sTable, $iID )
	{
		if (!isset($this->oPDO))
		{
			/*
			 * Innitialise la connexion
			 */
			include CONFIG_PATH . '/DatabaseConfig.php' ;
			$this->oPDO = new PDO(
				'mysql:host=' . $aDbConfig['host'] . ';dbname=' . $aDbConfig['name'] ,
				$aDbConfig['user'],
				$aDbConfig['pass']
			);
			$this->oPDO->exec("SET CHARACTER SET utf8");
		}
		$aConfigId = explode( '_', $sTable );
		$sConfigId = 'C' ;
		foreach( $aConfigId as $sValue )
		{
			$sConfigId .= strtoupper( substr( $sValue , 0, 1 ) ) ;
		}
		$sConfigId .= 'ID' ;
		$aConfigValue = $this->oPDO->query('SELECT configValue FROM bo_config_'.$sTable.' WHERE '.$sConfigId.'="'.$iID.'"')->fetch(PDO::FETCH_ASSOC) ;
		$this->oPDO = NULL ;
		return $aConfigValue['configValue'] ;
	}
}