<?php

class Form_Signup extends Zend_Form
{

	public function init()
	{
		$this->setName("form_signup");

		$vUsername = new Zend_Form_Element_Text("vUsername");
		$vUsername->setLabel("E-mail")
			->setRequired(true)
			->addValidator("NotEmpty")
			->addValidator("Db_NoRecordExists", false, array(
			'table' => 'User',
			'field' => 'vUserName'))
			->addFilter("StringTrim")
			->addFilter("StripTags")
			->addValidator("EmailAddress");

		$vPassword = new Zend_Form_Element_Password("vPassword");
		$vPassword->setLabel("Password")
			->setRequired(true)
			->addValidator("NotEmpty");

		$vPassword_confirm = new Zend_Form_Element_Password("vPassword_confirm");
		$vPassword_confirm->setLabel("Confirm password")
			->setRequired(true)
			->addValidator("NotEmpty")
			->addPrefixPath('Danil_Validator', 'Danil/Validator', 'validate')
			->addValidator('Passwordconfirm');

		$iEmployeeId = new Zend_Form_Element_Text("iEmployeeId");
		$iEmployeeId->setLabel("EmployeeId")->addFilter("StripTags");

		$iSGroupCode = new Zend_Form_Element_Text("iSGroupCode");
		$iSGroupCode->setLabel("Group Code")
			->setRequired(true)
			->addValidator("NotEmpty")
			->addValidator("Db_RecordExists", false, array(
			'table' => 'SubGroup',
			'field' => 'vGroupCodeId'))
			->addFilter("StringTrim")
			->addFilter("StringToUpper")
			->addFilter("StripTags");

		$submit = new Zend_Form_Element_Submit("submit");
		$submit->setLabel("Submit");

		$this->addElements(
			array(
				$vUsername,
				$vPassword, $vPassword_confirm,
				$iEmployeeId,
				$iSGroupCode,
				$submit
			));
	}
}