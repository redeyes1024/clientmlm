<?php

class Model_Directory extends Danil_Model
{

	public function __construct($id = null)
	{
		parent::__construct(new Zend_Db_Table('Directory'), $id);
	}

	public function getList($userId)
	{
		try {
			$ass = new Model_SubGroupUserAssign();
			$table = $this->_dbTable;
			$select = $table->select()
				->from($table,
				array(
					'DISTINCT(iDirectoryId),vFirstname,vLastname,vEmail,vJobTitle,vPhone'
				))
				->where(
				'iSGroupId in(' . $ass->getAssignedGroupsIdsString($userId) .
					') and eStatus = 1 ')
				->order('vFirstname ASC');
			return $table->fetchAll($select);
		} catch (Exception $e) {
			return false;
		}
	}
}
