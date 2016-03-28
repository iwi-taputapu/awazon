<?php

class N2Platform
{

    public static $isAdmin = false;

    public static $hasPosts = false, $isJoomla = false, $isWordpress = false, $isMagento = false, $isNative = false;

    public static $name;

    public static function init() {
        self::$isMagento = Mage::getVersion();
        if (Mage::app()
                ->getStore()
                ->isAdmin()
        ) {
            self::$isAdmin = true;
        }
    }

    public static function getPlatform() {
        return 'magento';
    }

    public static function getPlatformName() {
        return 'Magento';
    }

    public static function getDate() {
        return Mage::getModel('core/date')
                   ->date('Y-m-d H:i:s');
    }

    public static function getTime() {
        return Mage::getModel('core/date')
                   ->timestamp(time());
    }

    public static function getPublicDir() {
        return Mage::getBaseDir('media');
    }

    public static function adminHideCSS() {
        echo 'body{background: #fff;}.header, .footer{display: none;} #anchor-content{padding: 0;} .notification-global{display:none;}';
    }

    public static function updateFromZip($fileRaw, $updateInfo) {
        ob_end_clean();
        header('Content-disposition: attachment; filename=' . preg_replace('/[^a-zA-Z0-9_-]/', '', $updateInfo['name']) . '_UPDATE.tgz');
        header('Content-type: application/zip');
        echo $fileRaw;
        n2_exit(true);
    }

}

N2Platform::init();
