<?php

class N2Localization extends N2LocalizationAbstract
{

    static function getLocale() {
        return Mage::app()->getLocale()->getLocaleCode();
    }
}