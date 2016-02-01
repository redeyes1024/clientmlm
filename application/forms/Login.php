<?php

class Form_Login extends Zend_Form
{

	public function init()
	{
		$this->setName("form_login");
		$vUsername = new Zend_Form_Element_Text("vUsername");
		$vUsername->setLabel("E-mail")
			->setRequired(true)
			->addValidator("NotEmpty")
			->addFilter("StringTrim")
			->addFilter("StripTags")
			->addValidator("EmailAddress");

		$vPassword = new Zend_Form_Element_Password("vPassword");
		$vPassword->setLabel("Password")
			->setRequired(true)
			->addValidator("NotEmpty");

		$submit = new Zend_Form_Element_Submit("submit");
		$submit->setLabel("Log In");

		$this->addElements(
			array(
				$vUsername,
				$vPassword,
				$submit
			));
	}
}

