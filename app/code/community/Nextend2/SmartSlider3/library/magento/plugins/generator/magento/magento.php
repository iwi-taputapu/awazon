<?php

N2Loader::import('libraries.plugins.N2SliderGeneratorPluginAbstract', 'smartslider');

class N2SSPluginGeneratorMagento extends N2SliderGeneratorPluginAbstract
{

    public static $group = 'magento';
    public static $groupLabel = 'magento';

    function onGeneratorList(&$group, &$list, $showall = false) {

        $group[self::$group] = self::$groupLabel;

        if (!isset($list[self::$group])) {
            $list[self::$group] = array();
        }

        $product       = new N2GeneratorInfo(self::$groupLabel, n2_('Product'), $this->getPath() . 'product');
        $product->type = 'product';

        $list[self::$group]['product'] = $product;
    }

    function getPath() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR;
    }

}

N2Plugin::addPlugin('ssgenerator', 'N2SSPluginGeneratorMagento');