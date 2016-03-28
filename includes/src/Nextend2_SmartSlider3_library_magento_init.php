<?php

if (!defined('N2SSPRO')) {
    define('N2SSPRO', 0);

}

N2Base::registerApplication(dirname(__FILE__) . '/../smartslider/N2SmartsliderApplicationInfo.php');

function nextend_smartslider3($sliderId, $usage = 'Used in PHP') {
    N2Base::getApplication("smartslider")->getApplicationType('widget')->render(array(
        "controller" => 'home',
        "action"     => 'magento',
        "useRequest" => false
    ), array(
        $sliderId,
        $usage
    ));
}