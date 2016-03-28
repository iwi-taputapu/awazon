<?php

class N2SmartsliderApplicationInfoFilter
{

    /**
     * @param $info N2ApplicationInfo
     */
    public static function filter($info) {
        $info->setAssetsPath(Mage::getBaseDir('media') . '/smartslider3/media');
        $info->setUrl(Mage::helper("adminhtml")->getUrl("adminhtml/smartslider3/index"));
    }
}