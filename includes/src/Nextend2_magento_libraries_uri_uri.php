<?php

class N2Uri extends N2UriAbstract
{

    function __construct() {
        $this->_baseuri = rtrim(Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB), '/');

        if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) != 'off') {
            $this->_baseuri = str_replace('http://', 'https://', $this->_baseuri);
        }
    }
}