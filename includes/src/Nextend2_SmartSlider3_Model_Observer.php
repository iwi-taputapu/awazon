<?php

class Nextend2_SmartSlider3_Model_Observer
{

    static $sliders = array();

    private static $products = array();
    private static $categories = array();

    function buildCSS() {
        if (count(self::$sliders)) {
            foreach (self::$sliders AS $callable) {
                if (is_callable($callable)) {
                    call_user_func($callable);
                } else {
                    $css = NextendCss::getInstance();
                    foreach (self::$sliders AS $id) {
                        $css->generateCSS($id);
                    }
                }
            }
        }
    }

    public function nextendLoaded() {
        require_once(Mage::getBaseDir("app") . '/code/community/Nextend2/SmartSlider3/library/magento/init.php');
    }

    function shortcode($observer) {
        if (Mage::app()
                ->getStore()
                ->isAdmin()
        ) {
            return;
        }
        /** @var Mage_Core_Controller_Response_Http $response */
        $response = $observer->getResponse();

        $body = $response->getBody();
        //var_dump(strpos($body, 'smartslider3'));exit;


        // Simple performance check to determine whether bot should process further
        if (strpos($body, 'smartslider3[') === false) {
            return;
        }
        $parts    = explode('<body', $body);
        $parts[1] = preg_replace_callback('/smartslider3\[([0-9]+)\]/', 'Nextend2_SmartSlider3_Model_Observer::prepare', $parts[1]);
        $response->setBody(implode('<body', $parts));
    }

    public static function prepare($matches) {
        require_once(Mage::getBaseDir("app") . '/code/community/Nextend2/magento/library.php');
        ob_start();
        nextend_smartslider3($matches[1]);

        return preg_replace_callback('/\[([a-z_]+) ([0-9]+)\]/', array(
            'Nextend2_SmartSlider3_Model_Observer',
            'makeUrl'
        ), ob_get_clean());
    }

    public static function makeUrl($out) {
        $id = intval($out[2]);
        if ($id) {
            switch ($out[1]) {
                case 'url':
                    return self::getProduct($id)
                               ->getProductUrl();
                    break;
                case 'addtocart':
                    return Mage::helper('checkout/cart')
                               ->getAddUrl(self::getProduct($id));
                    break;
                case 'wishlist_url':
                    return Mage::helper('wishlist')
                               ->getAddUrl(self::getProduct($id));
                    break;
                case 'category_url':
                    return self::getCategory($id)
                               ->getUrl();
                    break;
            }
        }
        return '#';
    }

    private static function getProduct($id) {
        if (!isset(self::$products[$id])) {
            self::$products[$id] = Mage::getModel('catalog/product')
                                       ->load($id);
        }
        return self::$products[$id];
    }

    private static function getCategory($id) {
        if (!isset(self::$categories[$id])) {
            self::$categories[$id] = Mage::getModel('catalog/category')
                                         ->load($id);
        }
        return self::$categories[$id];
    }
}