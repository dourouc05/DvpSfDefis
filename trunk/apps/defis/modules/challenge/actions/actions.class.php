<?php

/**
 * challenge actions.
 *
 * @package    qtweb
 * @subpackage challenge
 * @author     Thibaut Cuvelier
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class challengeActions extends sfActions
{	
	// le défi actuel
	public function executeLatest(sfWebRequest $request)
	{
		$lng = $this->getUser()->getCulture();
		$this->slotLng = $lng;
		Doctrine_Core::initializeModels(array('challenge'));
		
		$q = Doctrine_Query::create()
			->from('config c')
			->where('c.param = ?', 'challenge_latest');
		$res = $q->fetchOne();
		$latest = (int) $res->getValue();
		
		$q = Doctrine_Query::create()
			->from('challenge c')
			->where('c.id = ?', $latest)
			->leftJoin('c.Translation t WITH t.lang = ?', $lng);
		$ch = $q->fetchOne();
		$this->nochallenge = false; 
		
		if($ch)
		{
			$q = Doctrine_Query::create()
				->from('juryman j')
				->where('j.challenge = ?', $latest);
			$jury = $q->execute();
		
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
			
			// variables pour le défi en cours
			$this->name      =  $ch->getName();
			$this->forum     =  $ch->getForum();
			$this->desc      =  $ch->getDescription();
			$this->instr     =  $ch->getInstructions();
			$this->behaviour =  $ch->getExpectedbehaviour();
			$this->files     =  $ch->getFilestohand();
			$this->env       =  $ch->getTargets();
			$this->criteria  =  $ch->getDesccriteria();
			$this->start     =  $ch->getStart();
			$this->end       =  $ch->getEnd();
			
			// chargement des traductions
			$this->loadMaxStrings($lng);
			$this->slotTitle = loadTitle('title_chall_latest', $lng) . ' ' . lcfirst($this->name);
			
			$this->cotation = $this->loadCriteria($latest, $lng);
		}
		else
		{
			$this->nochallenge = true; 
			$this->sorry = loadString('challenge_sorry', $lng); 
			$this->slotTitle = loadTitle('title_chall_sorry', $lng);
		}
		
		return sfView::SUCCESS;
	}
	
	// un seul défi passé 
	public function executeOne(sfWebRequest $request)
	{
		$lng = $this->getUser()->getCulture();
		$this->slotLng = $lng;
		Doctrine_Core::initializeModels(array('challenge'));
		
		$q = Doctrine_Query::create()
			->from('config c')
			->where('c.param = ?', 'challenge_latest');
		$res = $q->fetchOne();
		$latest = (int) $res->getValue();
		
		if($latest == (int) $request->getParameter('number'))
			$this->redirect('@challenge');
		
		$q = Doctrine_Query::create()
			->from('challenge c')
			->where('c.id = ?', (int) $request->getParameter('number'))
			->leftJoin('c.Translation t WITH t.lang = ?', $lng);
		$ch = $q->fetchOne();
		
		if($ch)
		{
			$q = Doctrine_Query::create()
				->from('juryman j')
				->where('j.challenge = ?', (int) $request->getParameter('number'));
			$jury = $q->execute();
		
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
			
			// variables pour le défi en cours
			$this->name      =  $ch->getName();
			$this->forum     =  $ch->getForum();
			$this->desc      =  $ch->getDescription();
			$this->instr     =  $ch->getInstructions();
			$this->behaviour =  $ch->getExpectedbehaviour();
			$this->files     =  $ch->getFilestohand();
			$this->env       =  $ch->getTargets();
			$this->criteria  =  $ch->getDesccriteria();
			$this->start     =  $ch->getStart();
			$this->end       =  $ch->getEnd();
			
			$this->loadMinStrings($lng);
			$this->slotTitle = loadTitle('title_chall_oneold', $lng) . ' ' . lcfirst($this->name);
			
			$this->cotation = $this->loadCriteria((int) $request->getParameter('number'), $lng);
		}
		else
		{
			$this->redirect('@challenge');
		}
		
		return sfView::SUCCESS;
	}
	
	// seulement les défis passés
	public function executeOld(sfWebRequest $request)
	{
		$lng = $this->getUser()->getCulture();
		$this->slotLng = $lng;
		Doctrine_Core::initializeModels(array('challenge'));
		
		$q = Doctrine_Query::create()
			->from('challenge c')
			->leftJoin('c.Translation t WITH t.lang = ?', $lng);
		$ch = $q->execute();
		
		$this->loadLightStrings($lng);
		$this->slotTitle = loadTitle('title_chall_old', $lng) ;
		
		$this->defis = array(); 
		$i = 0; 
		foreach($ch as $def)
		{
			++$i;
			$this->defis[$i]['name'] = $def->getName();
			$this->defis[$i]['desc'] = $def->getDescription();
		}
		
		return sfView::SUCCESS;
	}
	
	private function loadLightStrings($lng)
	{
		$this->oldT = loadString('challenge_old_title', $lng);
		$this->presC = loadString('challenge_presentation_content', $lng);
	}
	
	private function loadMinStrings($lng)
	{
		$this->loadLightStrings($lng);
		$this->presT = loadString('challenge_presentation_title', $lng);
		$this->cnsgT = loadString('challenge_consignes_title', $lng);
		$this->cnsgBehT = loadString('challenge_consignes_behaviour_title', $lng);
		$this->cnsgFlsT = loadString('challenge_consignes_files_title', $lng);
		$this->cnsgEnvT = loadString('challenge_consignes_env_title', $lng);
		$this->evalT = loadString('challenge_eval_title', $lng);
		$this->evalCritT = loadString('challenge_eval_criteria_title', $lng);
		$this->evalGrillT = loadString('challenge_eval_grill_title', $lng);
		$this->tAoptional = loadString('challenge_eval_addtotitle_optional', $lng);
		$this->tAcriteria = loadString('challenge_eval_title_criteria', $lng);
		$this->tAtotal = loadString('challenge_eval_title_total', $lng);
	}
	
	private function loadMaxStrings($lng)
	{
		$this->loadMinStrings($lng);
		$this->juryT = loadString('challenge_jury_title', $lng);
		$this->juryC = loadString('challenge_jury_content', $lng);
	}
	
	private function loadCriteria($ch, $lng)
	{
		$ch = (int) $ch; 
		
		$q = Doctrine_Query::create()
			->from('categoryofcriteria c')
			->where('c.challenge = ?', $ch)
			->leftJoin('c.Translation t WITH t.lang = ?', $lng);
		$cats = $q->execute();
		
		$q = Doctrine_Query::create()
			->from('criteria c')
			->where('c.challenge = ?', $ch)
			->leftJoin('c.Translation t WITH t.lang = ?', $lng);
		$crits = $q->execute();
		
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
		
		return $cotation;
	}
}