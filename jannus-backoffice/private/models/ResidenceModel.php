<?php
class ResidenceModel extends CoreModel
{
	public function getResidence()
	{
		/*
		 * Détermine la résidence de l'utilisateur et renvoie
		 * les infos lié à cette résidence (IP, MODE)
		 * Si l'adresse IP n'est pas associé à une résidence
		 * on retourne false
		 */
		return $this->oPDO->query('SELECT * FROM bo_residence JOIN bo_residence_ip WHERE IP="'.$_SERVER['REMOTE_ADDR'].'" AND bo_residence_ip.RID=bo_residence.RID')->fetch(PDO::FETCH_ASSOC) ;
	}
	
	public function getProduct()
	{
		$aResidence = $this->getResidence() ;
		return $this->oPDO->query(
		'SELECT * FROM bo_product JOIN bo_residence_product 
		WHERE bo_residence_product.RID="'.$aResidence['RID'].'" 
		AND bo_product.PID=bo_residence_product.PID'
		)->fetchAll() ;
	}
	
	public function getProductInfo( $iPID )
	{
		return $this->oPDO->query('SELECT * FROM bo_product WHERE PID="'.$iPID.'"')->fetch(PDO::FETCH_ASSOC) ;
	}
}