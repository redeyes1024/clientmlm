<?php

class Model_Audio extends Danil_Model
{

	public function __construct($id = null)
	{
		parent::__construct(new Zend_Db_Table('Audio'), $id);
	}

	public function getDocListByCat($iAudioCategoryId)
	{
		try {
			$table = $this->_dbTable;
			$select = $table->select()
				->from($table,
				array(
					'DISTINCT(iAudioId),vAudioName,vAudiopath'
				))
				->where('iAudioCategoryId = ? and eStatus = 1 ',
				$iAudioCategoryId)
				->order('vAudioName ASC');
			return $table->fetchAll($select);
		} catch (Exception $e) {
			return false;
		}
	}
}
