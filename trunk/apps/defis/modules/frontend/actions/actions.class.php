<?php

/**
 * frontend actions.
 *
 * @package    qtweb
 * @subpackage frontend
 * @author     Thibaut Cuvelier
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class frontendActions extends sfActions
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
		Doctrine_Core::initializeModels(array('presentation'));
	
		$this->title = loadString('index_title', $lng);
		$this->l1    = loadString('index_label1', $lng);
		$this->l2    = loadString('index_label2', $lng);
		$this->l3    = loadString('index_label3', $lng);
		$this->i1    = loadString('index_image1', $lng);
		$this->i2    = loadString('index_image2', $lng);
		$this->i3    = loadString('index_image3', $lng);
		$this->by    = loadString('index_by_min', $lng);
		
		$this->slotTitle = loadTitle('title_index', $lng);
		
		///////////////////////////////////////////////////////////////// 
		// PRÉSENTATIONS
		///////////////////////////////////////////////////////////////// 
		
		// récupération du défi en cours
		$q = Doctrine_Query::create()
			->from('config c')
			->where('c.param = ?', 'challenge_latest');
		$res = $q->fetchOne();
		$latest = (int)$res->getValue();
		
		// récupération de toutes les présentations du défi en cours pour la langue sélectionnée
		$q = Doctrine_Query::create()
			->from('presentation p')
			->leftJoin('p.Translation t WITH t.lang = ?', $lng)
			->where('p.challenge = ?', $latest);
		$res = $q->execute()->toArray();
		
		if($res)
		{
			// génération de max 2 nombres aléatoires, correspondant à des présentations
			$alea = array();
			$this->pres = array();
			while(count($alea) < 2  && count($alea) <= count($res) - 1)
			{
				$alea[mt_rand(0, count($res) - 1)] = true;
			}
			// on récupère les présentations correspondantes et on se sépare de la partie ['Translation'], on n'en a pas besoin, donc un seul tableau suffit
			foreach($alea as $id => $devnull)
			{
				$toad = $res[$id]; 
				unset($toad['Translation']);
				if($res[$id]['Translation'][$lng])
					$toad = array_merge($toad, $res[$id]['Translation'][$lng]);
				else
					$toad = array_merge($toad, $res[$id]['Translation']['fr']);
					
				$q = Doctrine_Query::create()
					->from('user u')
					->where('u.id = ?', $toad['member']);
				$usr = $q->fetchOne();
				$toad['username'] = $usr->getUsername();
				$toad['uid'] = (int) $usr->getId();
				
				$this->pres[] = $toad; 
			}
		}
		
		///////////////////////////////////////////////////////////////// 
		// POSTS FORUM
		///////////////////////////////////////////////////////////////// 
		
		// on n'a pas accès au RSS du forum car il est sur dvp.net
		// par contre, on peut aller getter du dvp.com, donc index modifié pour tout récupérer
		
		// $forum = @file_get_contents('http://qt.developpez.com/defis.index.php');
		// $this->forum = unserialize(($forum) ? $forum : serialize(array()));
		
		$forum = @file_get_contents('http://www.developpez.net/forums/external.php?type=RSS2&forumids=376');
		// $forum = @file_get_contents('http://www.developpez.net/forums/external.php?type=RSS2&forumids=1378');
		$forum = str_replace('dc:creator', 'creator', $forum);
		$forum = new SimpleXMLElement($forum);
		$forum = $forum->channel;
		$this->forum = array();
		
		foreach($forum->item as $item)
		{
			$this->forum[] = array	(
										'url' => $item->link, 
										'titre' => $item->title,
										'posteur' => $item->creator
									);
			// var_dump($item);
		}
		
		return sfView::SUCCESS;
	}
	
	public function executeError404(sfWebRequest $request)
	{
		$lng = $this->getUser()->getCulture();
		$this->slotLng = $lng;
		
		$this->text = loadString('404', $lng);
		$this->slotTitle = loadTitle('title_404', $lng);
		
		return sfView::SUCCESS;
	}
}
