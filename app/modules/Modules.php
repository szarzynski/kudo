<?php

function loadModules($app)
{
    
    new Errors($app);
    new Routes($app);

}