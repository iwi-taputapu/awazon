<?php

N2Loader::import('libraries.form.element.list');

class N2ElementMagentoProducttypes extends N2ElementList
{


    function fetchElement() {

        $this->_xml->addChild('option', 'All')->addAttribute('value', 0);

        $types = Mage::getModel('catalog/product_type')->getTypes();

        foreach ($types as $id => $type) {
            $this->_xml->addChild('option', ' - ' . $type['label'])->addAttribute('value', $id);
        }

        $this->_value = $this->_form->get($this->_name, $this->_default);

        return parent::fetchElement();
    }
}
