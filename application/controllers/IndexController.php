<?php

class IndexController extends Zend_Controller_Action
{

	public function init()
	{
		if (!Zend_Auth::getInstance()->hasIdentity()) {
			$this->_redirect('/users/login');
		}
		if (!$this->_request->getPathInfo()) {
			$this->_redirect('/index/');
		}

		$action = $this->getRequest()->getParam('action');

		$activeNav = $this->view->navigation()->findBy('id', $action);

		$activeNav->active = true;
		$activeNav->setClass("active");
		$this->view->resource = $activeNav->resource;
		$this->view->pageCurrent = $activeNav->uri;
		$this->view->title = $activeNav->label;
		$this->view->headTitle($this->view->title);
		if (get_class($activeNav->getParent()) == 'Zend_Navigation_Page_Uri') {
			$this->view->pageParent = $activeNav->getParent()->uri;
		}
	}

	public function indexAction()
	{
	}

	public function directoryAction()
	{
		if (Zend_Auth::getInstance()->hasIdentity()) {
			$user = Zend_Auth::getInstance()->getIdentity();
			$directoryList = new Model_Directory();
			$this->view->list = $directoryList->getList($user->iUserId);
		}
	}


	public function coursesAction()
	{
		if (Zend_Auth::getInstance()->hasIdentity()) {
			$user = Zend_Auth::getInstance()->getIdentity();
			$eventsList = new Model_Course();
			$this->view->list = $eventsList->getList($user->iUserId);
		}
	}

	public function coursedetileAction()
	{
		if (Zend_Auth::getInstance()->hasIdentity()) {
			$courseid = $this->_getParam('iCourseId');

			$course = new Model_Course($courseid);
			if ($course->iCourseId) {

				$this->view->list = $course->getDetiles();
				$this->view->detiles = $course;
			}
		}
	}


	public function librarycatigoriesAction()
	{
		if (Zend_Auth::getInstance()->hasIdentity()) {
			$user = Zend_Auth::getInstance()->getIdentity();
			$eventsList = new Model_Library();
			$this->view->list = $eventsList->getList($user->iUserId);
		}
	}

	public function videocatigoriesAction()
	{
		if (Zend_Auth::getInstance()->hasIdentity()) {
			$user = Zend_Auth::getInstance()->getIdentity();
			$eventsList = new Model_VideoCategory();
			$this->view->list = $eventsList->getList($user->iUserId);
		}
	}


	public function audiocatigoriesAction()
	{
		if (Zend_Auth::getInstance()->hasIdentity()) {
			$user = Zend_Auth::getInstance()->getIdentity();
			$eventsList = new Model_AudioCategory();
			$this->view->list = $eventsList->getList($user->iUserId);
		}
	}

	public function librarylistAction()
	{
		if (Zend_Auth::getInstance()->hasIdentity()) {

			$id = $this->_getParam('iLibCategoryId');
			$eventsList = new Model_Document();
			$this->view->list = $eventsList->getDocListByCat($id);
		}
	}

	public function videolistAction()
	{
		if (Zend_Auth::getInstance()->hasIdentity()) {

			$id = $this->_getParam('iVideoCategoryId');
			$eventsList = new Model_Video();
			$this->view->list = $eventsList->getDocListByCat($id);
		}
	}

	public function audiolistAction()
	{
		if (Zend_Auth::getInstance()->hasIdentity()) {

			$id = $this->_getParam('iAudioCategoryId');
			$eventsList = new Model_Audio();
			$this->view->list = $eventsList->getDocListByCat($id);
		}
	}


	public function eventsAction()
	{
		if (Zend_Auth::getInstance()->hasIdentity()) {
			$user = Zend_Auth::getInstance()->getIdentity();
			$eventsList = new Model_Event();
			$this->view->list = $eventsList->getList($user->iUserId);
		}
	}

	public function eventdetileAction()
	{
		if (Zend_Auth::getInstance()->hasIdentity()) {

			$courseid = $this->_getParam('iEventId');

			$course = new Model_Event($courseid);
			if ($course->iEventId) {


				$this->view->detiles = $course;
			}
		}
	}

}

