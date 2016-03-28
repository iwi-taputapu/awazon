<?php

class N2Form extends N2FormAbstract
{

    public static function tokenize() {
        $admin = new Mage_Adminhtml_Block_Template();
        return '<input type="hidden" name="form_key" value="' . $admin->getFormKey() . '" />';
    }

    public static function tokenizeUrl() {
        $admin         = new Mage_Adminhtml_Block_Template();
        $a             = array();
        $a['form_key'] = $admin->getFormKey();
        return $a;
    }

    public static function checkToken() {
        return true;
    }
}
