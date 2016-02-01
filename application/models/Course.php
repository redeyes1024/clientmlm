<?php

class Model_Course extends Danil_Model
{

	public function __construct($id = null)
	{
		parent::__construct(new Zend_Db_Table('Course'), $id);
	}

	public function getList($userId)
	{
		$ass = new Model_SubGroupUserAssign();
		return $this->_dbTable->fetchAll(
			'iSGroupId in(' . $ass->getAssignedGroupsIdsString($userId) . ') and  eStatus = 1 ', 'vCoursename ASC');

	}

	public function getDetiles()
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$select = new Zend_Db_Select($db);
		$select = $select
			->from(array('cc' => 'CourseClasses'), array('dClassDateTime', 'iDuration', 'eStatus'))
			->joinLeft(array('cl' => 'Class'), 'cl.iClassId = cc.iClassId',
			array('vClassname'))
			->where('cc.iCourseId = ? and cc.eStatus = 1', $this->iCourseId);
		$stmt = $db->query($select);
		return $stmt->fetchAll();
	}
}
