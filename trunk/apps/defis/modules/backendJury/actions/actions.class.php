<?php

require_once MOD_ROOT . '/challenge/actions/actions.class.php';

/**
 * backendJury actions.
 *
 * @package		qtweb
 * @subpackage backendJury
 * @author		 Thibaut Cuvelier
 * @version		SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class backendJuryActions extends sfActions
{
	/**
	* Executes index action
	*
	* @param sfRequest $request A request object
	*/
	public function executeIndex(sfWebRequest $request)
	{
		if(! $this->getUser()->hasCredential('jury'))
			$this->redirect('secure');
		
		$lng = $this->getUser()->getCulture();
		$this->slotLng = $lng;
		$this->slotTitle = loadTitle('jury_list_title', $lng);
		$this->sTitle = ucfirst(loadString('jury_list_title', $lng));
		
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
		
		$this->mem = array();
		foreach($res as $r)
		{
			$q = Doctrine_Query::create()
				->from('user u')
				->where('u.id = ?', $r->getMember());
			$u = $q->fetchOne();
			$this->mem[] = array('id' => $r->getId(), 'pseudo' => $u->getUsername());
		}
	}
	
	public function executeOne(sfWebRequest $request)
	{
		if(! $this->getUser()->hasCredential('jury'))
			$this->redirect('secure');
		
		$lng = $this->getUser()->getCulture();
		$this->slotLng = $lng;
		$this->slotTitle = loadTitle('jury_one_title', $lng);
		$id = (int) $request->getParameter('id');
		$this->victim = $id; 
		
		$this->tAoptional = loadString('challenge_eval_addtotitle_optional', $lng);
		$this->tAcriteria = loadString('challenge_eval_title_criteria', $lng);
		$this->tAtotal = loadString('challenge_eval_title_total', $lng);
		$this->tAmy = loadString('challenge_eval_title_my', $lng);
		$this->tAcomm = loadString('challenge_eval_title_comm', $lng);
		$this->sVictim = loadString('challenge_eval_title_victim', $lng);
		
		$q = Doctrine_Query::create()
			->from('config c')
			->where('c.param = ?', 'challenge_latest');
		$res = $q->fetchOne();
		$latest = (int) $res->getValue();
		$this->ch = $latest;
		
		$this->hangman = $this->getUser()->getAttribute('id'); 
			
		$q = Doctrine_Query::create()
			->from('evaluation e')
			->where('e.challenge = ?', $latest)
			->andWHere('e.member = ?', $id)
			->andWhere('e.jury = ?', (int) $this->getUser()->getAttribute('id'))
			->leftJoin('e.Translation t WITH t.lang = ?', $lng);
		$cotes = $q->execute();
		
		if(@$_POST['sentttt'])
		{
			$todo = array(); 
			foreach($_POST as $i => $d)
			{
				if($d && $i != 'victim' && $i != 'hangman' && $i!= 'sentttt' && $i != 'challen')
				{
					if(is_int($i))
						$todo[$i]['cote'] = $d; 
					else
					{
						$i = explode('_', $i, 2); 
						$todo[$i[0]]['comm'] = $d;
					}
				}
			}
			
			foreach($cotes as $c)
			{
				$e = $todo[$c->getCriteria()];
				unset($todo[$c->getCriteria()]);
				
				$c->setNote(@$e['cote']);
				$c->setComment(@$e['comm']);
				$c->save();
			}
			
			if(count($todo) != 0)
			{
				foreach($todo as $i => $d)
				{
					$c = new evaluation();
					$c->setMember((int) $_POST['victim']);
					$c->setJury((int) $_POST['hangman']);
					$c->setChallenge((int) $_POST['challen']);
					$c->setCriteria((int) $i);
					$c->setNote((int) @$d['cote']);
					$c->setComment(@$d['comm']);
					$c->save();
				}
			}
			
			$this->redirect('evalOne', array('id' => $id));
		}
		else
		{
			$q = Doctrine_Query::create()
				->from('categoryofcriteria c')
				->where('c.challenge = ?', $latest)
				->leftJoin('c.Translation t WITH t.lang = ?', $lng);
			$cats = $q->execute();
			
			$q = Doctrine_Query::create()
				->from('criteria c')
				->where('c.challenge = ?', $latest)
				->leftJoin('c.Translation t WITH t.lang = ?', $lng);
			$crits = $q->execute();
			
			// grille de cotation : $crits et $cats
			// on veut que les cat�gories aient leur id en indice du tableau pour simplifier la suite
			$newcats = array();
			foreach($cats as $cat)
			{
				$newcats[$cat->getId()] = $cat;
			}
			$cats = $newcats;
			unset($newcats);
			
			// on veut que les crit�res soient rang�s en fonction de leur cat�gorie, en indice du tableau
			$newcrits = array();
			foreach($crits as $crit)
			{
				$newcrits[$crit->getCat()][] = $crit; 
			}
			$crits = $newcrits; 
			unset($newcrits);
			
			// idem pour les cotes donn�es par le monsieur actuel
			// seulement, on n'a que pour des crit�res... 
			$newcotes = array();
			foreach($cotes as $cote)
			{
				// var_dump(is_object($cote));
				$newcotes[$cote->getCriteria()][] = array('note' => $cote->getNote(), 'comm' => $cote->getComment()); 
			}
			$cotes = $newcotes; 
			unset($newcotes);
			
			// donc on s'arrange quand on remet tout en place ! 
			$cotation = array();
			foreach($crits as $cat => $cnt)
			{
				$tmpcnt = array();
				foreach($cnt as $c)
				{
					$tmpcnt[] = array('crit' => $c, 'cote' => @$cotes[$c->getId()]);
				}
				
				$cotation[$cat]['title'] = $cats[$cat]; 
				$cotation[$cat]['content'] = $tmpcnt;
			}
			$this->cotation = $cotation; 
		}
	}
}
