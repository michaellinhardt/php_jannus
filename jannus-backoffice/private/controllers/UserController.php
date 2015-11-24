<?php
class UserController
{
	public function IndexMethod()
	{
	}
	
	public function DebuguserMethod()
	{
	}
	
	public function DebuguserrequestMethod()
	{
		$this->bAjaxMethod = true ;
		$oUser = new UserModel();
		echo json_encode( $oUser->DebugUser() );
		$oUser->oPDO = NULL ;
	}
	
	public function DebuguserresetMethod()
	{
		$this->bAjaxMethod = true ;
		$oUser = new UserModel();
		echo $oUser->DebugUserReset() ;
		$oUser->oPDO = NULL ;
	}
}