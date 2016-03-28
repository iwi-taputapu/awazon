<?php

class N2SmartSliderWidgetHomeController extends N2Controller
{

    public function initialize() {
        parent::initialize();

        N2Loader::import(array(
            'models.Sliders',
            'models.Slides'
        ), 'smartslider');

    }

    public function actionIndex() {

    }

    public function actionJoomla($sliderid, $usage) {
    }

    public function actionWordpress($sliderid, $usage) {
    }

    public function actionMagento($sliderid, $usage) {
        $this->addView("magento", array(
            "sliderid" => $sliderid,
            "usage"    => $usage
        ), "content");
        $this->render();
    
    }

    public function actionNative($sliderid, $usage) {
    }

} 