<?php

$installer = $this;
$installer->startSetup();

defined('NEXTEND_INSTALL') || define('NEXTEND_INSTALL', true);
require_once(dirname(__FILE__) . '/../../../magento/library.php');
N2Base::getApplication("system")->getApplicationType('backend')->render(array(
    "controller" => "install",
    "action"     => "index"
), array(true));

$installer->endSetup();