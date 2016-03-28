<?php

class N2ElementHidden extends N2Element
{

    public $_mode = 'hidden';

    public $_tooltip = false;

    function fetchTooltip() {
        if ($this->_tooltip) {
            return parent::fetchTooltip();
        } else {
            return $this->fetchNoTooltip();
        }
    }

    function fetchElement() {

        return NHtml::tag('input', array(
            'id'           => $this->_id,
            'name'         => $this->_inputname,
            'value'        => $this->getValue(),
            'type'         => $this->_mode,
            'autocomplete' => 'off'
        ), false);
    }
}
