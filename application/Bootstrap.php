<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	protected function _initAutoload()
	{
		$moduleloader = new Zend_Application_Module_Autoloader(
			array(
				"namespace" => '',
				'basePath' => APPLICATION_PATH
			));
		$autoloader = Zend_Loader_Autoloader::getInstance();
		$autoloader->registerNamespace(
			array(
				'Danil_'
			));
	}

	protected function _initViewHelpers()
	{
		$this->bootstrap('layout');
		$layout = $this->getResource('layout');
		$view = $layout->getView();

		if (!Zend_Auth::getInstance()->hasIdentity()) {
			$view->identity = false;
			$detector = new Danil_MobileDetect();
			$view->isMobile = ($detector->isMobile() == 1) ? true : false;
		} else {
			$view->identity = Zend_Auth::getInstance()->getIdentity();
			$view->isMobile = $view->identity->isMobile;
			if ($view->identity->showShotcut) {
				$view->identity->showShotcut = false;
				$view->headScript()
					->appendFile('/js/add2home.js');
				$view->headLink()
					->appendStylesheet('/css/add2home.css');
			}
		}


		$view->headMeta()
			->appendHttpEquiv('X-UA-Compatible', 'IE=EmulateIE7, IE=9')
			->appendHttpEquiv('content-type', 'text/html; charset=utf-8')
			->appendHttpEquiv('Author', 'HospitalU')
			->appendHttpEquiv('omni_page', 'Mac - Index/Tab')
			->appendHttpEquiv('Description', 'Discover the world of HospitalU.')
			->appendName('keywords', 'framework, PHP, productivity')
			->appendName('apple-mobile-web-app-capable', 'yes')
			->appendName('viewport', 'width = device-width ,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no');


		$view->headScript()
			->appendFile('/js/jquery-1.8.2.min.js')
			->appendFile('/js/jwplayer.js');


		$view->headLink()
			->appendStylesheet('/css/content.css');

		$view->headLink(array('rel' => 'apple-touch-icon', 'href' => '/images/bookmark.png'));
		$view->headLink(array('rel' => 'apple-touch-icon', 'href' => '/images/bookmark72.png', 'extras' => '72x72'));
		$view->headLink(array('rel' => 'apple-touch-icon', 'href' => '/images/bookmark114.png', 'extras' => '114x114'));


		if ($view->isMobile) {
			$view->headLink()
				->appendStylesheet('/css/style_mobile_portret.css');

		} else {

			$view->headLink()
				->appendStylesheet('/css/topnav.css')
				->appendStylesheet('/css/style.css');
		}


		$view->headLink(array('rel' => 'icon',
			'href' => '/images/favicon.ico', 'type' => "image/x-icon"
		));


		$view->headTitle('MLM')->setSeparator(' :: ');

	}

	protected function _initNavigation()
	{
		$this->bootstrap('layout');
		$layout = $this->getResource('layout');
		$view = $layout->getView();
		$config = new Zend_Config_Xml(
			APPLICATION_PATH . '/configs/navigation.xml', 'nav');
		$container = new Zend_Navigation($config);
		$view->navigation($container);
	}
}

