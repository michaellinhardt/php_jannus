<?php
class MoncompteController
{
	public function ConnexionMethod()
	{
		if ( ( isset( $_SESSION['UID'] ) ) && ( $_SESSION['UID'] != 0 ) )
		{
			$this->bAjaxMethod = true ;
			header( 'Location: http://clients.cooliz.fr' ) ;
			exit() ;
		}
	}
}