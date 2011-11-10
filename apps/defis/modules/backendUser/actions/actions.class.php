<?php

/**
 * backendUser actions.
 *
 * @package		qtweb
 * @subpackage backendUser
 * @author		 Thibaut Cuvelier
 * @version		SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class backendUserActions extends sfActions
{
	/**
	* Executes index action
	*
	* @param sfRequest $request A request object
	*/
	public function executeIndex(sfWebRequest $request)
	{
		$user = $this->getUser();
		$lng = $user->getCulture();
		$this->slotLng = $lng;
		$this->slotTitle = 'Ma présentation'; 
		
		$q = Doctrine_Query::create()
			->from('config c')
			->where('c.param = ?', 'challenge_latest');
		$res = $q->fetchOne();
		$latest = (int) $res->getValue();
		
		$q = Doctrine_Query::create()
			->from('presentation p')
			->where('p.challenge = ?', $latest)
			->andWhere('p.member = ?', $user->getAttribute('id'));
		$res = $q->fetchOne();
		
		if(@$_POST['sent'])
		{
			if(! (bool) $res)
				$res = new presentation();
			$res['member'] = $user->getAttribute('id'); 
			$res['challenge'] = $latest; 
			$res['forum'] = $_POST['presentation_forum']; 
			$res['shortdescription'] = $_POST['presentation_shortdescription']; 
			$res['description'] = $_POST['presentation_description'];
			$res->save();
		}
		
		if((bool) $res)
		{
			$this->setTemplate('edit');
			$this->forum = $res->getForum(); 
			$this->title = $res->getTitle(); 
			$this->descf = $res->getDescription(); 
			$this->sdesc = $res->getShortdescription(); 
		}
		else
			$this->setTemplate('create');
	}
}
