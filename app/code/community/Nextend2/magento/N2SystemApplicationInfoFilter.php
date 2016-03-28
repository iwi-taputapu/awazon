<?php

class N2SystemApplicationInfoFilter
{

    /**
     * @param $info N2ApplicationInfo
     */
    public static function filter($info) {
        $info->setUrl(Mage::helper("adminhtml")->getUrl("adminhtml/nextend2/index"));
        $info->setAssetsPath(Mage::getBaseDir('media') . '/nextend2/media');
    }
}