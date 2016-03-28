<?php

class Nextend2_Nextend2_Adminhtml_Nextend2Controller extends Mage_Adminhtml_Controller_Action
{


    public function initNextend() {
        require_once(Mage::getBaseDir("app") . '/code/community/Nextend2/magento/library.php');
    }


    public function indexAction() {
        $this->initNextend();


        if ($this->getRequest()
                 ->getParam('nextendajax', 0)
        ) {
            $controller = 'dashboard';
            $action     = 'index';
            N2Base::getApplication("system")
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