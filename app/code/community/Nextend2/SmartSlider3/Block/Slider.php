<?php

class Nextend2_SmartSlider3_Block_Slider extends Mage_Core_Block_Abstract implements Mage_Widget_Block_Interface
{

    protected function _toHtml() {
        $sliderId = intval($this->getData('slider'));
        if ($sliderId > 0) {
            return 'smartslider3[' . $sliderId . ']';
        }
        return '';
    }

}
