<?php

/**
 * Class N2Filesystem
 */
class N2Filesystem extends N2FilesystemAbstract
{

    public function __construct() {
        $this->_basepath    = Mage::getBaseDir();
        $this->_cachepath   = Mage::getBaseDir('media') . DIRECTORY_SEPARATOR . 'nextend';
        $this->_librarypath = str_replace($this->_basepath, '', N2LIBRARY);
    }

    public static function getWebCachePath() {
        $i = N2Filesystem::getInstance();
        self::check(Mage::getBaseDir('media'), 'nextend');
        self::check(Mage::getBaseDir('cache'), 'nextend');
        return $i->_cachepath;
    }

    public static function getNotWebCachePath() {
        return Mage::getBaseDir('cache') . '/nextend';
    }

    public static function getImagesFolder() {
        return Mage::getBaseDir('media');
    }
}