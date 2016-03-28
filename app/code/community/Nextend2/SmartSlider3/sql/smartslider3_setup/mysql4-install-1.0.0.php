<?php

$installer = $this;
$installer->startSetup();

defined('NEXTEND_INSTALL') || define('NEXTEND_INSTALL', true);

require_once(dirname(__FILE__) . '/../../../magento/library.php');
require_once(dirname(__FILE__) . '/../../library/magento/init.php');
N2Base::getApplication("smartslider")->getApplicationType('backend')->render(array(
    "controller" => "install",
    "action"     => "index",
    "useRequest" => false
), array(true));

$installer->endSetup();