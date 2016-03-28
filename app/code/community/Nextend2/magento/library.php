<?php
define('N2WORDPRESS', 0);
define('N2JOOMLA', 0);
define('N2MAGENTO', 1);
define('N2NATIVE', 0);

if (!defined('N2PRO')) {
    define('N2PRO', 0);

}

if (!defined("N2_PLATFORM_LIBRARY")) define('N2_PLATFORM_LIBRARY', dirname(__FILE__));
if (!defined('N2LIBRARYASSETS')) define('N2LIBRARYASSETS', Mage::getBaseDir('media') . '/nextend2/media');

require_once N2_PLATFORM_LIBRARY . '/../library/library.php';

N2Base::registerApplication(N2LIBRARY . '/applications/system/N2SystemApplicationInfo.php');

Mage::dispatchEvent('nextend_loaded');