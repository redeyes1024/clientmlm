<?php

class UsersController extends Zend_Controller_Action
{

	public function indexAction()
	{
		// TODO Auto-generated UsersController::indexAction() default action
	}

	public function logoutAction()
	{
		$auth = Zend_Auth::getInstance();
		$auth->clearIdentity();
		$this->_helper->redirector('login');
	}

	public function loginAction()
	{
		$this->view->title = "User Login.";
		$this->view->headTitle($this->view->title, 'PREPEND');

		$form = new Form_Login();


		if ($this->getRequest()->isPost()) {
			if ($form->isValid($this->getRequest()
				->getPost())
			) {
				$user = new Model_User();
				if ($user->authorize($form->getValue('vUsername'),
					$form->getValue('vPassword'))
				) {
					$this->_redirect('/index/');
				} else {
					$this->view->error = "Wrong E-mail or Password.";
				}
			}
		}
		$this->view->form = $form;
	}

	public function signupAction()
	{
		$this->view->title = "User Registration.";
		$this->view->headTitle($this->view->title, 'PREPEND');

		$form = new Form_Signup();
		if ($this->getRequest()->isPost()) {
			if ($form->isValid($this->getRequest()
				->getPost())
			) {
				$formvalues = $form->getValues();
				$user = new Model_User();
				$db = $user->getAdapter();
				$db->beginTransaction();
				try {

					$user->fill($formvalues);

					$user->eStatus = 1;
					$user->eAlerts = 1;
					$user->eRights = 1;
					$user->dRegDate = time();
					// $user->sendActivationEmail();
					$user->save();

					$group = new Model_SubGroup();
					$group->find('vGroupCodeId', $formvalues['iSGroupCode']);
					$assign = new Model_SubGroupUserAssign();
					$assign->iSGroupId = $group->iSGroupId;
					$assign->iUserId = $user->iUserId;
					$assign->save();

					$db->commit();
				} catch (Exception $e) {
					$db->rollBack();
					echo $e->getMessage();
				}

				$this->_helper->redirector('login');
			}
		}
		$this->view->form = $form;
	}


}

