<?php

class Model_Company extends Danil_Model
{

	public function __construct($id = null)
	{
		parent::__construct(new Zend_Db_Table('Company'), $id);
	}

}