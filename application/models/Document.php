<?php

class Model_Document extends Danil_Model
{

	public function __construct($id = null)
	{
		parent::__construct(new Zend_Db_Table('Document'), $id);
	}

	public function getDocListByCat($id)
	{
		try {
			$table = $this->_dbTable;
			$select = $table->select()
				->from($table,
				array(
					'DISTINCT(iDocumentId),vDocumentName,vDocumentpath'
				))
				->where('iLibCategoryId = ? and eStatus = 1 ',
				$id)
				->order('vDocumentName ASC');
			return $table->fetchAll($select);
		} catch (Exception $e) {
			return false;
		}
	}
}
