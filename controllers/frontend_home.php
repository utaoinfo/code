<?php
/**
 * @copyright Copyright(c) 2011 jooyea.net
 * @file site.php
 * @brief
 * @author webning
 * @date 2011-03-22
 * @version 0.6
 * @note
 */
/**
 * @brief Site
 * @class Site
 * @note
 */
class Frontend_home extends IController
{
    public $layout='frontend_home';

	function init()
	{

	}

	function index()
	{

		$siteConfigObj = new Config("site_config");
		$site_config   = $siteConfigObj->getInfo();
		
		$index_slide = isset($site_config['index_slide'])? unserialize($site_config['index_slide']) :array();
		$this->index_slide = $index_slide;
		$this->redirect('index');
	}

}
