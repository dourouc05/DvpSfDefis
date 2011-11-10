<?php

/**
 * deposit actions.
 *
 * @package    qtweb
 * @subpackage deposit
 * @author     Thibaut Cuvelier
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class depositActions extends sfActions
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
		
		$this->showForm = false;
		$this->error    = false;
		$this->already  = false;
		$this->rules    = false;
		$this->form     = false;
		
		$this->sFile                        =  loadString('upload_file', $lng);
		$this->sRulesread                   =  loadString('upload_rulesread', $lng);
		$this->sSend                        =  loadString('upload_send', $lng);
		$this->sMaxsize                     =  loadString('upload_maxsize', $lng);
		$this->sWarning                     =  loadString('upload_warning', $lng);
		$this->sAlreadysent                 =  loadString('upload_alreadysent', $lng);
		$this->sAcceptmyrulesordieyoumoron  =  loadString('upload_acceptmyrulesordieyoumoron', $lng);
		$this->sError                       =  loadString('upload_error', $lng);
		$this->sFilesent                    =  loadString('upload_filesent', $lng);
		$this->sThanks                      =  loadString('upload_thanks', $lng);
		
		$this->slotTitle = loadTitle('title_deposit', $lng);
		
		if($user->isAuthenticated())
		{
			if($this->already_uploaded($user->getAttribute('pseudo')))
			{
				$this->showForm = false;
				$this->error    = true;
				$this->already  = true;
			}
			else
			{
				// si formulaire envoyé
				if (count($_POST) >= 1)
				{
					if (! $_POST['agree'])
					{
						$this->error = true;
						$this->rules = true;
						return sfView::SUCCESS;
					}
					$file = $_FILES['file_name']['name'];
					$ext  = strchr ($file, '.');
					if(in_array ($ext, $this->extensions) && move_uploaded_file ($_FILES['file_name']['tmp_name'], DOC_ROOT . '/defis/uploads/' . $user->getAttribute('pseudo') . $ext))
					{
						$this->showForm = false;
						$this->error    = false;
						return sfView::SUCCESS;
					}
					else
					{
						$this->showForm = false;
						$this->error    = true;
						return sfView::SUCCESS;
					}
				}
				else
				{
					$this->showForm = true;
					return sfView::SUCCESS;
				}
			}
		}
		else
		{
			$this->redirect('@secure');
		}
	}
	
	private $extensions = array ('.bz2', '.zip', '.rar', '.gz', '.tgz', '.7z', '.zipx');
	
	private function already_uploaded ($pseudo)
	{
		foreach ($this->extensions as $ext)
		{
			if (file_exists (DOC_ROOT . '/defis/uploads/' . $pseudo . $ext))
			{
				return true;
			}
		}
		return false;
	}
}
