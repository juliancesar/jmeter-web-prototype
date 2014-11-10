<?php

class ServerController extends CController {

    public function actions() {
        return array(
            'service' => array(
                'class' => 'CWebServiceAction',
            ),
        );
    }

    /**
     * @return boolean success
     * @soap
     */
    public function ping() {
        return true;
    }

}