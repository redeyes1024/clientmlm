<?php

class Model_User extends Danil_Model
{
	public function __construct($id = null)
	{
		parent::__construct(new Zend_Db_Table('User'), $id);
	}

	public function authorize($vUsername, $vPassword)
	{
		$auth = Zend_Auth::getInstance();
		$authAdapter = new Zend_Auth_Adapter_DbTable(
			Zend_Db_Table::getDefaultAdapter(), 'User', 'vUserName',
			'vPassword', 'eStatus=1');
		$authAdapter->setIdentity($vUsername)->setCredential($vPassword);
		$result = $auth->authenticate($authAdapter);

		if ($result->isValid()) {
			$storage = $auth->getStorage();
			$storage->write(
				$authAdapter->getResultRowObject(null,
					array(
						'vPassword'
					)));

			$auth = $storage->read();
			$detector = new Danil_MobileDetect();
			$auth->isMobile = ($detector->isMobile()==1)?true:false;
			$auth->showShotcut=true;


			$subgroupid=new Model_SubGroupUserAssign();
			$groupid=$subgroupid->getGroupId($auth->iUserId);
			$company=new Model_Company($groupid);

			$auth->vGoogleAPI=$company->vGoogleAPI;
			$auth->vGoogleAPIvalue=$company->vGoogleAPIvalue;

			$storage->write($auth);

			return true;
		} else {
			return false;
		}
	}

}
