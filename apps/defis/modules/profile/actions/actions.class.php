<?php

/**
 * profile actions.
 *
 * @package    qtweb
 * @subpackage profile
 * @author     Thibaut Cuvelier
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class profileActions extends sfActions
{
	public function executeOne(sfWebRequest $request)
	{
		$user = $this->getUser();
		$this->authd = (bool) $user->isAuthenticated();
		$lng = $user->getCulture();
		$this->slotLng = $lng;
		$rid = (int) $request->getParameter('id'); 
		$this->id = $rid; 
		Doctrine_Core::initializeModels(array('presentation'));
		
		if($this->authd)
		{
			if($rid == (int) $user->getAttribute('id') || $user->hasCredential('jury'))
				$this->mine = true;
		}
		
		$q = Doctrine_Query::create()
			->from('user u')
			->select('username')
			->where('u.id = ?', $rid);
		$mem = $q->fetchOne();
		
		$this->unknown = false; 
		
		if($mem)
		{
			$q = Doctrine_Query::create()
				->from('config c')
				->where('c.param = ?', 'challenge_latest');
			$res = $q->fetchOne();
			$latest = (int) $res->getValue();
			
			$q = Doctrine_Query::create()
				->from('presentation p')
				->leftJoin('p.Translation t WITH t.lang = ?', $lng)
				->where('p.member = ?', $rid);
			$res = $q->execute();
			
			$this->uname = $mem->getUsername();
			$this->mem = $mem; 
			$this->slotTitle = loadTitle('title_profile', $lng) . ' ' . $mem->getUsername();
			
			$this->sPartCurr = loadString('profile_partcurr', $lng);
			$this->sPartOlds = loadString('profile_partolds', $lng);
			$this->sAddress  = loadString('profile_address',  $lng);
			$this->sAverto   = loadString('profile_averto',   $lng);
			$this->sEdit     = loadString('profile_edit',     $lng);
			
			$this->participations = array();
			$this->now = null;
			
			if($res)
			{
				foreach($res as $r)
				{
					if($r['challenge'] != $latest)
						$this->participations[] = $r; 
					else 
						$this->now = $r; 
				}
			}
		}
		else
		{
			$this->unknown = true; 
			$this->slotTitle = loadTitle('title_profile_unknown', $lng);
		}
		
		return sfView::SUCCESS;
	}
	
	public function executeEdit(sfWebRequest $request)
	{
		$user = $this->getUser();
		$this->authd = (bool) $user->isAuthenticated();
		$lng = $user->getCulture();
		$this->slotLng = $lng;
		$rid = (int) $request->getParameter('id'); 
		$this->id = $rid; 
		
		if(! $this->authd)
			$this->redirect('@secure');
			
		$q = Doctrine_Query::create()
			->from('user u')
			->select('username')
			->where('u.id = ?', $rid);
		$this->mem = $q->fetchOne();
		
		if(! $this->mem)
			$this->redirect('oneProfile', array('id' => $rid, 'pseudo' => $rid));
		
		$this->pseudo = $this->mem->getUsername();
		
		$this->sUpdated = loadString('profile_updated', $lng); 
		$this->sSend = loadString('profile_send', $lng); 
		$this->sName = loadString('profile_name', $lng); 
		$this->sStreet = loadString('profile_street', $lng); 
		$this->sNumber = loadString('profile_number', $lng); 
		$this->sPostcode = loadString('profile_postcode', $lng); 
		$this->sCity = loadString('profile_city', $lng); 
		$this->sCountry = loadString('profile_country', $lng); 
		$this->sWarningNoFormat = loadString('profile_warningnorformat', $lng); 
		
		if(isset($_POST['id']) && $_POST['id'] == $rid)
		{
			$this->updated = true; 
			$this->mem->setAddressName     ($_POST['name']);
			$this->mem->setAddressStreet   ($_POST['street']);
			$this->mem->setAddressNumber   ($_POST['number']);
			$this->mem->setAddressPostcode ($_POST['postcode']);
			$this->mem->setAddressCity     ($_POST['city']);
			$this->mem->setAddressCountry  ($_POST['country']);
			$this->mem->save();
		}
		else
			$this->updated = false;
		
		$this->slotTitle = loadTitle('title_profile', $lng) . ' ' . $this->mem->getUsername();
	}
}
