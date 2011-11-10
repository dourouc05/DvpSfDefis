<?php

// require_once SYM_ROOT . '/autoload/sfCoreAutoload.class.php';
require_once 'F:\\Dvp\\_RUBRIQUES\\qt-web\\symfony\\lib\\autoload\\sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
	public function setup()
	{
		$this->enablePlugins(
								'sfDoctrinePlugin', 
								'sfNicEditPlugin', 
								'isicsWidgetFormTinyMCEPlugin', 
								'sfDoctrineGuardPlugin',
                                'sfAjaxAdminDoctrineThemePlugin'
							);
		
		if(defined('WEBDIR'))
			$this->setWebDir(WEBDIR);
	}
}
