<?php

class Errors extends Module
{
    public function __construct($app)
    {
        parent::__construct($app);
        $this->run();
    }


    private function run()
    {

        App::notFound(function() {

            View::display('error.404.tpl');

        });

        Route::get('/401/', function() {

            View::display('error.401.tpl');

        });
        
    }
}