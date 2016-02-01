<?php

class Model_VideoCategory extends Danil_Model
{

	public function __construct($id = null)
	{
		parent::__construct(new Zend_Db_Table('VideoCategory'), $id);
	}

	public function getList($userId)
	{
		$ass = new Model_SubGroupUserAssign();
		return $this->_dbTable->fetchAll(
			'iSGroupId in(' . $ass->getAssignedGroupsIdsString($userId) . ')');
	}


}
