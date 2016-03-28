<?php

class N2ElementContainer extends N2Element
{

    function fetchElement() {

        return NHtml::tag('div', array(
            'id' => $this->_id
        ));
    }
}
