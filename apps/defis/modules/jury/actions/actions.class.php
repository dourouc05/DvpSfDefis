<?php

/**
 * jury actions.
 *
 * @package    qtweb
 * @subpackage jury
 * @author     Thibaut Cuvelier
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class juryActions extends sfActions
{
	/**
	* Executes index action
	*
	* @param sfRequest $request A request object
	*/
	public function executeIndex(sfWebRequest $request)
	{
		$lng = $this->getUser()->getCulture();
		$this->slotLng = $lng;
		
		$q = Doctrine_Query::create()
			->from('config c')
			->where('c.param = ?', 'challenge_latest');
		$res = $q->fetchOne();
		$latest = (int) $res->getValue();
		
		$q = Doctrine_Query::create()
			->from('juryman j')
			->where('j.challenge = ?', $latest);
		$jury = $q->execute();
		
		$this->title     = loadString('jury_title', $lng);
		$this->intro     = loadString('jury_intro', $lng);
		$this->slotTitle = loadTitle('title_jury', $lng);
		
		$this->jury = array();
		foreach($jury as $m)
		{
			$q = Doctrine_Query::create()
				->select('username')
				->from('user u')
				->where('u.id = ?', $m->getProfile());
			$mem = $q->fetchOne();
			
			$this->jury[] = array
									(
										'id' => (int) $m['profile'], 
										'pseudo' => $mem['username']
									);
		}
		
		return sfView::SUCCESS;
	}
}
