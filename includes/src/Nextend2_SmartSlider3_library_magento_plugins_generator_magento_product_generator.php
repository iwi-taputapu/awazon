<?php

N2Loader::import('libraries.slider.generator.abstract', 'smartslider');

class N2GeneratorMagentoProduct extends N2GeneratorAbstract
{

    protected function _getData($count, $startIndex) {
        $collection = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect('*')->addAttributeToFilter('status', array('eq' => 1));

        $categories = array_map('intval', explode('||', $this->data->get('magentocategory', '0')));
        if (is_array($categories) && !in_array(0, $categories)) {
            $finset = array();
            foreach ($categories AS $cat) {
                $finset[] = array('finset' => $cat);
            }
            $collection->joinField('category_id', 'catalog/category_product', 'category_id', 'product_id = entity_id', null, 'left');
            $collection->addAttributeToFilter('category_id', array('in' => $finset));
        }

        $producttype = explode('||', $this->data->get('magentoproducttype', '0'));
        if (is_array($producttype) && !in_array('0', $producttype)) {
            $collection->addAttributeToFilter('type_id', array('in' => $producttype));
        }

        $attributeset = array_map('intval', explode('||', $this->data->get('magentoattributeset', '0')));
        if (is_array($attributeset) && !in_array(0, $attributeset)) {
            $collection->addAttributeToFilter('attribute_set_id', array('in' => $attributeset));
        }

        if ($this->data->get('magentoonsale', '0')) {
            $dateToday    = date('m/d/y');
            $tomorrow     = mktime(0, 0, 0, date('m'), date('d') + 1, date('y'));
            $dateTomorrow = date('m/d/y', $tomorrow);

            $collection->addAttributeToFilter('special_price', array('gt' => 0))->addAttributeToFilter('special_from_date', array(
                'date' => true,
                'to'   => $dateToday
            ))->addAttributeToFilter('special_to_date', array(
                'or' => array(
                    0 => array(
                        'date' => true,
                        'from' => $dateTomorrow
                    ),
                    1 => array('is' => new Zend_Db_Expr('null'))
                )
            ), 'left');
        }

        $order = N2Parse::parse($this->data->get('magentoorder', 'price|*|desc'));
        if ($order[0]) {
            if ($order[0] == 'rand') $order[0] = 'rand()';
            $collection->addAttributeToSort($order[0], $order[1]);
            $order = N2Parse::parse($this->data->get('magentoorder2', 'name|*|asc'));
            if ($order[0]) {
                if ($order[0] == 'rand') $order[0] = 'rand()';
                $collection->addAttributeToSort($order[0], $order[1]);
            }
        }

        $imageSize = array_map('intval', N2Parse::parse($this->data->get('magentoimagesize', '0|*|0')));
        $collection->getSelect()->limit($count, $startIndex);

        $data = array();
        $i    = 0;
        foreach ($collection as $product) {

            $categoryIds = $product->getCategoryIds();
            if (count($categoryIds)) {
                $category = Mage::getModel('catalog/category')->load($categoryIds[0]);
            } else {
                $category = Mage::getModel('catalog/category')->load(0);
            }
            $image = '';
            if ($product->getImage() != 'no_selection') {
                if ($imageSize[0] > 0 && $imageSize[1] > 0) {
                    $image = Mage::helper('catalog/image')->init($product, 'image')->resize($imageSize[0], $imageSize[1]);
                } else {
                    $image = $product->getImageUrl();
                }
            }

            $record = array_map('strval', array(
                'title'             => $product->getName(),
                'description'       => $product->getDescription(),
                'short_description' => $product->getShortDescription(),
                'final_price'       => Mage::helper('core')->currency($product->getFinalPrice()),
                'url'               => '[url ' . $product->getId() . ']',
                'addtocart'         => '[addtocart ' . $product->getId() . ']',
                'wishlist_url'      => '[wishlist_url ' . $product->getId() . ']',
                'image'             => $image,
                'thumbnail'         => $image,
                'category_name'     => $category->getName(),
                'category_url'      => '[category_url ' . $category->getId() . ']',
                'addtocart_label'   => 'Add to cart'
            ));

            $attributes = $product->getAttributes();
            foreach ($attributes as $attribute) {
                if ($attribute->getIsVisibleOnFront() || $attribute->getIsFilterable() || $attribute->getIsSearchable() || $attribute->getIsComparable()) {
                    $record[$attribute->getAttributeCode()] = $attribute->getFrontend()->getValue($product);
                }
            }

            $record['price'] = Mage::helper('core')->currency($product->getPrice());

            $data[] = $record;
            $i++;
        }

        return $data;
    }
}