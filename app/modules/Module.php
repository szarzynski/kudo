<?php

class Module
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }


    protected function optionsRequest($url)
    {
        $app = $this->app;
        $this->app->options($url, function() use($app) {

            $app->response->setBody(json_encode(array(
                'status' => 'ok',
                'data' => array(),
            )));
            
        });
    }
}