<?php

class N2AjaxResponse
{

    /**
     * @var N2ApplicationType
     */
    private $appType;

    private $isError = false;

    private $response = array(
        'data'         => null,
        'notification' => array()
    );

    public function __construct($appType) {
        $this->appType = $appType;
    }

    public function error($showNotification = true) {
        $this->isError = true;
        $this->respond(null, $showNotification);
    }

    public function respond($data = null, $showNotification = true) {
        $this->response['data'] = $data;
        if (count(ob_list_handlers())) {
            ob_clean();
        }
        if ($showNotification) {
            $this->response['notification'] = N2Message::showAjax();
        }
        header("Content-Type: application/json");
        if ($this->isError) {
            header("HTTP/1.0 403 Forbidden");
        }
        echo json_encode($this->response);
        n2_exit(true);
    }

    public function redirect($url) {
        if (count(ob_list_handlers())) {
            ob_clean();
        }
        $this->response['redirect'] = $this->appType->router->createUrl($url);
        echo json_encode($this->response);
        n2_exit(true);
    }
}