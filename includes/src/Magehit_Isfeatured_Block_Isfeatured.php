<?php
/*
 * Featured product Extension Developed by Magehit
 */
?>
<?php

class Magehit_Isfeatured_Block_Isfeatured extends Mage_Core_Block_Template {

    public function ftotalProduct() {
        $collection = Mage::getModel('catalog/product');
        $products = $collection->getCollection()
                ->addAttributeToSelect('*')
                ->addAttributeToFilter('is_featured', 1)
                ->addAttributeToFilter('status', 1)
                ->load();
        return $products;
    }

    public function getStoreconfig() {
        $enable = Mage::getStoreConfig('isfeatured/genneral_setting/enabled');
        
		//horizontal_carousels_setting
		$horizontal_carousels_setting_title = Mage::getStoreConfig('isfeatured/horizontal_carousels_setting/title');
        $horizontal_carousels_setting_limit = Mage::getStoreConfig('isfeatured/horizontal_carousels_setting/product_no');
        $horizontal_carousels_setting_slide_itemsonpage = Mage::getStoreConfig('isfeatured/horizontal_carousels_setting/slide_itemsonpage');
        $horizontal_carousels_setting_slide_auto = Mage::getStoreConfig('isfeatured/horizontal_carousels_setting/slide_auto');
        $horizontal_carousels_setting_slide_navigation = Mage::getStoreConfig('isfeatured/horizontal_carousels_setting/slide_navigation');
		
		//vertical_carousels_setting
		$vertical_carousels_setting_title = Mage::getStoreConfig('isfeatured/vertical_carousels_setting/title');
        $vertical_carousels_setting_limit = Mage::getStoreConfig('isfeatured/vertical_carousels_setting/product_no');
        $vertical_carousels_setting_slide_itemsonpage = Mage::getStoreConfig('isfeatured/vertical_carousels_setting/slide_itemsonpage');
        $vertical_carousels_setting_slide_auto = Mage::getStoreConfig('isfeatured/vertical_carousels_setting/slide_auto');
        $vertical_carousels_setting_slide_navigation = Mage::getStoreConfig('isfeatured/vertical_carousels_setting/slide_navigation');
		
		
        $featuredValues = array(
			//Genneral setting
			'enabled' => $enable,
			//horizontal_carousels_setting
			'horizontal_carousels_setting_title' => $horizontal_carousels_setting_title,
			'horizontal_carousels_setting_limit' => $horizontal_carousels_setting_limit,
			'horizontal_carousels_setting_slide_itemsonpage' => $horizontal_carousels_setting_slide_itemsonpage,
			'horizontal_carousels_setting_slide_auto' => $horizontal_carousels_setting_slide_auto,
			'horizontal_carousels_setting_slide_navigation' => $horizontal_carousels_setting_slide_navigation,
			//vertical_carousels_setting
			'vertical_carousels_setting_title' => $vertical_carousels_setting_title,
			'vertical_carousels_setting_limit' => $vertical_carousels_setting_limit,
			'vertical_carousels_setting_slide_itemsonpage' => $vertical_carousels_setting_slide_itemsonpage,
			'vertical_carousels_setting_slide_auto' => $vertical_carousels_setting_slide_auto,
			'vertical_carousels_setting_slide_navigation' => $vertical_carousels_setting_slide_navigation,
			
		);
        return $featuredValues;
    }

}

?>
