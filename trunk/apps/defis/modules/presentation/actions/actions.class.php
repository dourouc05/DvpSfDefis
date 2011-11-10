<?php

/**
 * presentation actions.
 *
 * @package    qtweb
 * @subpackage presentation
 * @author     Thibaut Cuvelier
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class presentationActions extends sfActions
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
		$this->unavailable = false; 
		
		$q = Doctrine_Query::create()
			->from('config c')
			->where('c.param = ?', 'challenge_latest');
		$res = $q->fetchOne();
		$latest = (int) $res->getValue();
		
		$q = Doctrine_Query::create()
			->from('presentation p')
			->leftJoin('p.Translation t WITH t.lang = ?', $lng)
			->where('p.challenge = ?', $latest);
		$res = $q->execute();
		
		if($res)
		{
			$res = $res->toArray();
			$rst = array();
			$i = 0;
			foreach($res as $r)
			{
				$rst[$i]['u'] = $r['member'];
				$rst[$i]['id'] = (int) $r['id'];
				$rst[$i]['fo'] = $r['forum'];
				$rst[$i]['slug'] = $r['slug'];
				
				$rst[$i]['desc'] = ternT($r['Translation'], $lng, 'shortdescription');
				$rst[$i]['title'] = ternT($r['Translation'], $lng, 'title');
				
				++$i; 
			}
			$this->presentations = $rst; 
		}
		else
		{
			$this->unavailable = true; 
		}
		
		$this->intro        = loadString('presentations_intro', $lng);
		$this->forum        = loadString('presentations_forum', $lng);
		$this->pres         = loadString('presentations_internal', $lng);
		$this->sUnavailable = loadString('presentations_unavailable', $lng);
		$this->slotTitle    = loadTitle('title_pres_all', $lng);
		
		return sfView::SUCCESS;
	}
	
	public function executeOne(sfWebRequest $request)
	{
		$lng = $this->getUser()->getCulture();
		$this->slotLng = $lng;
		Doctrine_Core::initializeModels(array('presentation'));
		$this->unavailable = false; 
		
		// chargement de la présentation demandée
		$q = Doctrine_Query::create()
			->from('presentation p')
			->leftJoin('p.Translation t WITH t.lang = ?', $lng)
			->where('p.id = ?', (int) $request->getParameter('id'));
		$result = $q->fetchOne();
		if(! $result)
			$this->redirect('indexPresentations');
		$this->pres = $result; 
		
		$this->see = loadString('presentation_voirdefi', $lng);
		$this->slotTitle = loadTitle('title_pres_one', $lng) . ' ' . lcfirst($this->pres['title']);
		
		//chargement des évaluations... si c'est autorisé ! 
		$q = Doctrine_Query::create()
			->from('config c')
			->where('c.param = ?', 'challenge_latest');
		$latest = (int) $q->fetchOne()->getValue();
		
		$q = Doctrine_Query::create()
			->from('config c')
			->where('c.param = ?', 'challenge_latest_releaseeval');
		$release = (bool) $q->fetchOne()->getValue();
		
		if($result->getChallenge() != $latest || $release)
		// toujours autorisé si ce n'est pas le dernier
		{
			$q = Doctrine_Query::create()
				->from('evaluation e')
				->leftJoin('e.Translation t WITH t.lang = ?', $lng)
				->where('e.member = ?', (int) $request->getParameter('id'))
				->andWhere('e.challenge = ?', (int) $result->getChallenge())
				->orderBy('e.jury', 'e.criteria');
			$res = $q->execute();
			
			// avant tout, il faut retrier ça correctement : d'abord en fonction du hangman
			$evals = array();
			foreach($res as $r)
			{
				$evals[$r->getJury()][$r->getCriteria()] = $r;
			}
			
			// on aura besoin des critères... 
			$q = Doctrine_Query::create()
				->from('categoryofcriteria c')
				->where('c.challenge = ?', $result->getChallenge())
				->leftJoin('c.Translation t WITH t.lang = ?', $lng);
			$cats = $q->execute();
			
			$q = Doctrine_Query::create()
				->from('criteria c')
				->where('c.challenge = ?', $result->getChallenge())
				->leftJoin('c.Translation t WITH t.lang = ?', $lng);
			$crits = $q->execute();
			
			$q = Doctrine_Query::create()
				->from('juryman j')
				->where('j.challenge = ?', $result->getChallenge());
			$jures = $q->execute();
			$tableJures = array();
			foreach($jures as $id => $jure)
			{
				$tableJures[$jure->getProfile()] = $jure->getId();
			}
			$this->tableJures = $tableJures; 
			
			// grille de cotation : $crits et $cats
			// on veut que les catégories aient leur id en indice du tableau pour simplifier et accélérer fortement la suite
			$newcats = array();
			foreach($cats as $cat)
			{
				$newcats[$cat->getId()] = $cat;
			}
			$cats = $newcats;
			unset($newcats);
			
			// on veut que les critères soient rangés en fonction de leur catégorie, en indice du tableau
			$newcrits = array();
			foreach($crits as $crit)
			{
				$newcrits[$crit->getCat()][] = $crit; 
			}
			$crits = $newcrits; 
			unset($newcrits);
			
			// ensuite, on recrée un tableau avec le titre et les sous-critères correspondants
			$cotation = array();
			foreach($crits as $cat => $cnt)
			{
				$cotation[$cat]['title'] = $cats[$cat]; 
				$cotation[$cat]['content'] = $cnt;
			}
			
			// voilà, on a les tableaux et les critères... ça devrait suffire, non ? 
			$this->evals = $evals; 
			$this->cotation = $cotation;
			
			// et maintenant les strings
			$this->tAoptional = loadString('challenge_eval_addtotitle_optional', $lng);
			$this->tAcriteria = loadString('challenge_eval_title_criteria', $lng);
			$this->tAtotal = loadString('challenge_eval_title_total', $lng);
		}
		
		return sfView::SUCCESS;
	}
}
