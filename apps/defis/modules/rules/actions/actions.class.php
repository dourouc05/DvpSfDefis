<?php

/**
 * rules actions.
 *
 * @package    qtweb
 * @subpackage rules
 * @author     Thibaut Cuvelier
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class rulesActions extends sfActions
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
		
		$this->title     = loadString('rules_title', $lng);
		$this->content   = loadString('rules_content', $lng);
		$this->slotTitle = loadTitle('title_rules', $lng);
		
		return sfView::SUCCESS;
	}
}
