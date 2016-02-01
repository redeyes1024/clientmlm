<?php

class ContentController extends Zend_Controller_Action
{

	public function init()
	{
		if (!Zend_Auth::getInstance()->hasIdentity()) {
			$this->_redirect('/users/login');
		}
		if (!$this->_request->getPathInfo()) {
			$this->_redirect('/index/');
		}

		$action = $this->getRequest()->getParam('type');

		$activeNav = $this->view->navigation()->findBy('id', $action);

		$activeNav->active = true;
		$activeNav->setClass("active");
	}

	public function viewAction()
	{
		if (Zend_Auth::getInstance()->hasIdentity()) {
			$type = $this->_getParam('type');
			$id = $this->_getParam('id');
			if ($type && $id) {

				$contentName = null;
				$contentPath = null;
				$contentParentUrl = null;
				switch ($type) {
					case 'video':
						$video = new Model_Video($id);
						$contentName = $video->vVideoName;
						$contentPath = $video->vVideoPath;
						$contentParentUrl = $video->iVideoCategoryId;
						break;
					case 'audio':
						$audio = new Model_Audio($id);
						$contentName = $audio->vAudioName;
						$contentPath = $audio->vAudiopath;
						$contentParentUrl = $audio->iAudioCategoryId;
						break;
					default:
						$this->view->error = "Content type is wrong.";
				}

				if (!$this->view->error) {

					$this->view->pageCurrent = $id;
					$this->view->title = $contentName;
					$this->view->headTitle($this->view->title, 'PREPEND');

					$parentNav = $this->view->navigation()->findBy('id', $type . 'list');

					$this->view->pageParent = $parentNav->uri . 'i' . ucfirst($type) . 'CategoryId/' . $contentParentUrl;
					$parentNav->setUri($this->view->pageParent);
					$this->view->file = "/files/" . $type . "/" . urlencode($contentPath);
				}

			} else {
				$this->view->error = "Not all requred parameters are transfered.";
			}
		}
	}
}
