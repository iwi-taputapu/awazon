<?php
// @todo
N2Localization::addJS(array());

class N2ElementUrl extends N2ElementUrlAbstract
{

    protected function extendParams($params) {
        $params['labelButton']      = 'Joomla';
        $params['labelDescription'] = n2_('Select article or menu item from your site.');
        $params['image']            = '/element/link_platform.png';
        return $params;
    }
}