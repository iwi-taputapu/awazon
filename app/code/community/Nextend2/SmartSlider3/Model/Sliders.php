<?php

class Nextend2_SmartSlider3_Model_Sliders
{

    public function toOptionArray() {
        require_once(Mage::getBaseDir("app") . '/code/community/Nextend2/magento/library.php');

        N2Loader::import(array(
            'models.Sliders'
        ), 'smartslider');

        $slidersModel = new N2SmartsliderSlidersModel();
        $sliders      = $slidersModel->getAll();

        $return = array();
        foreach ($sliders AS $slider) {
            $return[] = array(
                'value' => $slider['id'],
                'label' => $slider['title'] . ' [#' . $slider['id'] . ']'
            );
        }

        return $return;
    }
}