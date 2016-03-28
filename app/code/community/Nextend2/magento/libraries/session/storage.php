<?php

class N2SessionStorage extends N2SessionStorageAbstract
{

    private $session;

    public function __construct() {
        $this->session = Mage::getSingleton("admin/session");
        $user          = $this->session->getUser();
        parent::__construct($user->getId());
    }

    /**
     * Load the whole session
     */
    protected function load() {
        $stored = $this->session->getData($this->hash);

        if (!is_array($stored)) {
            $stored = array();
        }
        $this->storage = $stored;
    }

    /**
     * Store the whole session
     */
    protected function store() {
        if (count($this->storage) > 0) {
            $this->session->setData($this->hash, $this->storage);
        } else {
            $this->session->setData($this->hash, null);
        }
    }

}