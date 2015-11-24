<?php
class StrModel extends CoreModel
{
	public function tronquer($sChaine, $iLongueur, $sSymbol = '...' )
	{
		/*
		 * Tronque une chaine de caractére
		 */
		if (strlen($sChaine) > $iLongueur)
		{
			$sChaine = substr($sChaine, 0, $iLongueur);
			$last_space = strrpos($sChaine, " ");
			$sChaine = substr($sChaine, 0, $last_space).$sSymbol;
		}
		
		return $sChaine;
	}
	
	public function httpName( $sChaine )
	{
		/*
		 * Transforme une chaine en nom conforme HTTP
		 */
		$sChaine = strtr($sChaine, 
			'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
			'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
     	$sChaine = preg_replace('/([^.a-z0-9]+)/i', '-', $sChaine);
     	
     	return $sChaine ;
	}
	
	public function is_NumPortable( $sTel )
	{
		$sTel = str_replace( '.', '', $sTel ) ;
		$sTel = str_replace( ' ', '', $sTel ) ;
		$sTel = str_replace( ',', '', $sTel ) ;
		$sTel = str_replace( '-', '', $sTel ) ;
		if ( !preg_match( '/06\d{7,9}/', $sTel ) ) return false ;
		if ($sTel=='0600000000') return false ;
		if ($sTel=='0611111111') return false ;
		if ($sTel=='0622222222') return false ;
		if ($sTel=='0633333333') return false ;
		if ($sTel=='0644444444') return false ;
		if ($sTel=='0655555555') return false ;
		if ($sTel=='0666666666') return false ;
		if ($sTel=='0677777777') return false ;
		if ($sTel=='0688888888') return false ;
		if ($sTel=='0699999999') return false ;
		if ($sTel=='0612345678') return false ;
		return $sTel ;
	}
	
	public function is_NumFix( $sTel )
	{
		$sTel = str_replace( '.', '', $sTel ) ;
		$sTel = str_replace( ' ', '', $sTel ) ;
		$sTel = str_replace( ',', '', $sTel ) ;
		$sTel = str_replace( '-', '', $sTel ) ;
		if ( !preg_match( '/01\d{7,9}/', $sTel ) ) return false ;
		if ($sTel=='0100000000') return false ;
		if ($sTel=='0111111111') return false ;
		if ($sTel=='0122222222') return false ;
		if ($sTel=='0133333333') return false ;
		if ($sTel=='0144444444') return false ;
		if ($sTel=='0155555555') return false ;
		if ($sTel=='0166666666') return false ;
		if ($sTel=='0177777777') return false ;
		if ($sTel=='0188888888') return false ;
		if ($sTel=='0199999999') return false ;
		if ($sTel=='0112345678') return false ;
		if ($sTel=='0123456789') return false ;
		return $sTel ;
	}
	
	public function strMinLen( $sString, $iLongueur )
	{
		if (strlen($sString)<$iLongueur) return false ;
		else return true ;
	}
}