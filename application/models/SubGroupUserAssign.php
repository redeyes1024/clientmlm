<?php

class Model_SubGroupUserAssign extends Danil_Model
{
	public function __construct($id = null)
	{
		parent::__construct(new Zend_Db_Table('SubGroupUserAssign'), $id);
	}

	public function getAssignedGroupsIds($userid)
	{

		$rows = $this->_dbTable->fetchAll("iUserId = '" . $userid . "'");
		foreach ($rows as $row) {
			$result[] = $row->iSGroupId;
		}
		$sgid = new Model_SubGroup($rows[0]->iSGroupId);
		$id = $sgid->iCompanyId;
		$sgid->findExact(array('iCompanyId', 'iIsDefault'), array($id, 1));
		$result[] = $sgid->iSGroupId;

		return $result;
	}

	public function getAssignedGroupsIdsString($userid)
	{
		$arr = $this->getAssignedGroupsIds($userid);
		$result = '999999999999';
		foreach ($arr as $id) {
			$result .= ',' . $id;
		}
		return $result;
	}

	public function getGroupId($userid)
	{
		$rows = $this->_dbTable->fetchAll("iUserId = '" . $userid . "'");
		if(count($rows)>0){
			return $rows[0]->iSGroupId;
		}
		return null;
	}

}
