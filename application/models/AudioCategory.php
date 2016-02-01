<?php

class Model_AudioCategory extends Danil_Model
{

	public function __construct($id = null)
	{
		parent::__construct(new Zend_Db_Table('AudioCategory'), $id);
	}

	public function getList($userId)
	{
		try {
			$ass = new Model_SubGroupUserAssign();
			$table = $this->_dbTable;
			$select = $table->select()
				->from($table,
				array(
					'DISTINCT(iAudioCategoryId),vCategoryName'
				))
				->where(
				'iSGroupId in ( ' . $ass->getAssignedGroupsIdsString(
					$userId) . ' ) and eStatus = ?', 1)
				->order('vCategoryName ASC');
			return $table->fetchAll($select);
		} catch (Exception $e) {
			return false;
		}
	}
}
