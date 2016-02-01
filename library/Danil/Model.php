<?php
class Danil_Model{
    protected $_dbTable;

    protected $_row;

    public function __construct (Zend_Db_Table_Abstract $dbTable,$id = null)
    {
    	$this->_dbTable = $dbTable ;
    	if ($id) {
    		$this->_row = $this->_dbTable->find($id)->current();
    	} else {
    		$this->_row = $this->_dbTable->createRow();
    	}
    }

    public function __set ($name, $val)
    {
    	if (isset($this->_row->$name)) {
    		$this->_row->$name = $val;
    	}
    }
    public function find($field,$value){
    	$this->_row=$this->_dbTable->fetchRow($field." = '".$value."'");
    }
    public function findExact($fields,$values){
        if(count($fields)==count($values)){
            $where='1=1';
            for($i=0;$i<count($fields);$i++){
                $where.=" and ".$fields[$i]." = '".$values[$i]."'";
            }
    	    $this->_row=$this->_dbTable->fetchRow($where);
        }
    }

    public function save ()
    {
    	$this->_row->save();
    }

    public function fill ($data)
    {
    	foreach ($data as $key => $value) {
    		if (isset($this->_row->$key)) {
    			$this->_row->$key = $value;
    		}
    	}
    }

    public function __get ($name)
    {
    	if (isset($this->_row->$name)) {
    		return $this->_row->$name;
    	}
    }
    public function getAdapter(){
      return  $this->_dbTable->getAdapter();
    }

}