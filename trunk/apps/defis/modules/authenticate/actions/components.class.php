<?php
 
class authenticateComponents extends sfComponents
{
	public function executeBox()
	{
		$user = $this->getUser();
		$lng = $user->getCulture();
		$this->auth = false;
		
		if($user->isAuthenticated())
		{
			$this->auth = true;
			$this->id = (int) $user->getAttribute('id');
			$this->email = $user->getAttribute('email');
			$this->pseudo = $user->getAttribute('pseudo');
			$this->redaction = (bool) $user->getAttribute('redaction');
			
			$this->jury = (bool) $user->hasCredential('jury'); 
			$this->admin = (bool) $user->hasCredential('admin'); 
			
			$this->trWel = loadString('conn_welcome', $lng);
			$this->trPrf = loadString('conn_profile', $lng);
			$this->trLgo = loadString('conn_logout', $lng);
		}
		else
		{
			$this->wishConnect = loadString('conn_wish', $lng);
			$this->wishCreate = loadString('conn_create', $lng);
		}
	}
}