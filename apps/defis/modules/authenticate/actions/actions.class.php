<?php

/**
 * authenticate actions.
 *
 * @package    qtweb
 * @subpackage authenticate
 * @author     Thibaut Cuvelier
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class authenticateActions extends sfActions
{	
	// se connecter
	public function executeLogin(sfWebRequest $request)
	{
		$lng = $this->getUser()->getCulture();
		$this->slotLng = $lng;
		
		$this->trPsd = loadString('conn_pseudo', $lng);
		$this->trPwd = loadString('conn_password', $lng);
		$this->trLog = loadString('conn_connect', $lng);
		$this->trDvp = loadString('conn_useyourdvpaccount', $lng);
		
		$this->slotTitle = loadTitle('title_connection', $lng);
		
		return sfView::SUCCESS;
	}
	
	// procéder à la connexion (retour depuis le forum)
	public function executeConnect(sfWebRequest $request)
	{
		$user = $this->getUser();
		
		if($request->hasParameter('erreur'))
		{
			$this->redirect('authenticate/error');
		}
		elseif($user->isAuthenticated())
		{
			$this->redirect('@homepage');
		}
		elseif($request->hasParameter('d'))
		{
			$info = $request->getParameter('d');
			$info = @gzuncompress(base64_decode($info));
			$info = @unserialize($info);
			
			$user->setAuthenticated(true);
			$user->addCredential('connected');
			
			$user->setAttribute('id', (int) $info['id']);
			$user->setAttribute('pseudo', $info['pseudo']);
			$user->setAttribute('email', $info['email']);
			$user->setAttribute('redaction', (bool) $info['redac']);
			
			// on va chercher des infos supplémentaires dans la base si disponibles
			$q = Doctrine_Query::create()
				->from('user u')
				->where('u.id = ?', $info['id']);
			$usr = $q->fetchOne();
			
			// c'est bon, on l'a en db ! 
			if($usr->getId())
			{
				if($usr->getAdmin())
					$user->addCredential('admin');
				if($usr->getJury())
					$user->addCredential('jury');
			}
			else
			{
				$usr = new user();
				$usr->setId((int) $info['id']);
				$usr->setUsername($info['pseudo']);
				$usr->setJury(false);
				$usr->setAdmin(false);
				$usr->save();
			}
			
			if($usr->getUsername() != $info['pseudo'])
			// tiens, il a osé changer de pseudo
			// et quoi ? 
			{
				$usr->setUsername($info['pseudo']);
				$usr->save();
			}
			
			$this->redirect('@homepage');
		}
		else
		{
			$this->redirect('login'); 
		}
	}
	
	// Page non accessible, il faut s'authentifier
	public function executeSecure(sfWebRequest $request)
	{
		$lng = $this->getUser()->getCulture();
		$this->slotLng = $lng;
		
		$this->trPsd = loadString('conn_pseudo', $lng);
		$this->trPwd = loadString('conn_password', $lng);
		$this->trLog = loadString('conn_connect', $lng);
		$this->trNAu = loadString('conn_notauthorized', $lng);
		$this->trDvp = loadString('conn_useyourdvpaccount', $lng);
		
		$this->slotTitle = loadTitle('title_conn_secure', $lng);
		
		return sfView::SUCCESS;
	}
	
	// erreur lors de la connexion
	public function executeError(sfWebRequest $request)
	{
		$lng = $this->getUser()->getCulture();
		$this->slotLng = $lng;
		
		$this->useyourdvpaccount = loadString('conn_useyourdvpaccount', $lng);
		$this->erroneous = loadString('conn_erroneous', $lng);
		$this->slotTitle = loadTitle('title_conn_error', $lng);
		
		return sfView::SUCCESS;
	}
	
	// déconnexion
	public function executeLogout(sfWebRequest $request)
	{
		$user = $this->getUser();
		$lng = $user->getCulture();
		$this->slotLng = $lng;
		
		$user->setAuthenticated(false);
		$this->logout = loadString('conn_logout_text', $lng); 
		$this->slotTitle = loadTitle('conn_logout', $lng);
		
		return sfView::SUCCESS;
	}
}
