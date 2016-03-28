<?php

N2Loader::import('libraries.form.element.list');

class N2ElementMagentoAttributesets extends N2ElementList {


    function fetchElement() {
    
        $this->_xml->addChild('option', 'All')->addAttribute('value', 0);
        
        $entityType = Mage::getModel('catalog/product')->getResource()->getTypeId();
        $collection = Mage::getResourceModel('eav/entity_attribute_set_collection')->setEntityTypeFilter($entityType);
        
        foreach ($collection as $id => $attributeSet) {
            $this->_xml->addChild('option', ' - '.$attributeSet->getAttributeSetName())->addAttribute('value', $attributeSet->getAttributeSetId());
        }

        $this->_value = $this->_form->get($this->_name, $this->_default);

        return parent::fetchElement();
    } 
}
