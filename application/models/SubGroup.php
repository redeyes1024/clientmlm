<?php

class Model_SubGroup extends Danil_Model
{
	public function __construct($id = null)
	{
		parent::__construct(new Zend_Db_Table('SubGroup'), $id);
	}


}
