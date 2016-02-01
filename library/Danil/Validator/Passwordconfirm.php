<?php

class Danil_Validator_Passwordconfirm  extends Zend_Validate_Abstract
{

    const NOT_MATCH = 'notMatch';

    protected $_messageTemplates = array(
            self::NOT_MATCH => "Passwords not equls."
    );

    public function isValid ($value, $context = null)
    {
        $value = (string) $value;

        if (is_array($context)) {
            if (isset($context['vPassword']) && ($value == $context['vPassword'])) {
                return true;
            }
        } elseif (is_string($context) && ($value == $context)) {
            return true;
        }

        $this->_error(self::NOT_MATCH);
        return false;
    }
}