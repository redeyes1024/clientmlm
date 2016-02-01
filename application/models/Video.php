<?php

class Model_Video extends Danil_Model
{

	public function __construct($id = null)
	{
		parent::__construct(new Zend_Db_Table('Video'), $id);
	}

	public function getDocListByCat($iVideoCategoryId)
	{
		try {
			$table = $this->_dbTable;
			$select = $table->select()
				->from($table,
				array(
					'DISTINCT(iVideoId),vVideoName,vVideoPath'
				))
				->where('iVideoCategoryId = ? and eStatus = 1 ',
				$iVideoCategoryId)
				->order('vVideoName ASC');
			return $table->fetchAll($select);
		} catch (Exception $e) {
			return false;
		}
	}
}
