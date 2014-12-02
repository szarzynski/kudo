<?php

class Routes extends Module
{
    public function __construct($app)
    {
        parent::__construct($app);
        $this->run();
    }


    private function run()
    {

        Route::get('/', 'Front:viewHome');

        Route::get('/login/', 'Logon:viewLogin');
        Route::post('/login/', 'Logon:postLogin')->name('login');
        Route::get('/logout/', 'Logon:logout');

        Route::group('/admin', function() {
            Route::get('/', 'Admin:viewDashboard');
        });
        
    }
}