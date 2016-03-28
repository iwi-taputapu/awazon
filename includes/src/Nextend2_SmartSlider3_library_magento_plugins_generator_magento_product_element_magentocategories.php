<?php

N2Loader::import('libraries.form.element.list');

class N2ElementMagentoCategories extends N2ElementList
{

    function fetchElement() {
        $rootcatId     = Mage::app()->getWebsite(1)->getDefaultStore()->getRootCategoryId();
        $realRootcatId = Mage::getModel('catalog/category')->load($rootcatId)->getParentCategory()->getId();
        $categories    = Mage::getModel('catalog/category')->getCategories($realRootcatId);
        $this->_xml->addChild('option', 'Root')->addAttribute('value', 0);
        $this->add_categories($categories, ' - ');

        $this->_value = $this->_form->get($this->_name, $this->_default);

        return parent::fetchElement();
    }

    function  add_categories($categories, $pre) {
        foreach ($categories as $category) {
            $this->_xml->addChild('option', htmlspecialchars($pre . $category->getName()))->addAttribute('value', $category->getId());
            if ($category->hasChildren()) {
                $children = Mage::getModel('catalog/category')->getCategories($category->getId());
                $this->add_categories($children, $pre . '- ');
            }
        }
    }

}
