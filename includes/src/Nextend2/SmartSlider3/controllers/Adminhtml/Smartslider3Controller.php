<?php

class Nextend2_SmartSlider3_Adminhtml_Smartslider3Controller extends Mage_Adminhtml_Controller_Action
{

    public function initNextend() {
        require_once(Mage::getBaseDir("app") . '/code/community/Nextend2/magento/library.php');
    }


    public function indexAction() {
        $this->initNextend();
        $request = $this->getRequest();
        if ($request->getParam('nextendajax', 0) || $request->getParam('download', 0)) {
            $controller = 'sliders';
            $action     = 'index';
            N2Base::getApplication("smartslider")
                  ->getApplicationType('backend')
                  ->setCurrent()
                  ->render(array(
                      "controller" => $controller,
                      "action"     => $action
                  ));
        } else {
            $this->loadLayout();
            $this->renderLayout();
        }
    }
}