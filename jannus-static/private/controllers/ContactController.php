<?php
class ContactController
{
	public function IndexMethod()
	{
	}
	
	public function TechniqueMethod()
	{
		$this->aView['mail'] = 'technique' ;
		$this->mSetView = 'contact/mail.php' ;
	}
	
	public function CommercialMethod()
	{
		$this->aView['mail'] = 'commercial' ;
		$this->mSetView = 'contact/mail.php' ;
	}
	
	public function SendMethod()
	{
		$this->bAjaxMethod = true ;
		$oMail = new MailModel() ;
		echo $oMail->contactMail();
	}
}