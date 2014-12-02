<?php

namespace Auth;

use Zend\Permissions\Acl\Acl as ZendAcl;

class Acl extends ZendAcl
{
    public function __construct()
    {
        // APPLICATION ROLES
        $this->addRole('guest');
        $this->addRole('admin');

        // APPLICATION RESOURCES
        // Application resources == Slim route patterns

        $resourcesFront = array(
            '/' => 'GET',
            '/401/' => 'GET',
            '/login/' => array('GET', 'POST'),
            '/logout/' => 'GET'
        );

        $resourcesBack = array(
            '/admin/' => 'GET'
        );

        foreach ($resourcesFront as $route => $method) {
            $this->addResource($route);
        }

        foreach ($resourcesBack as $route => $method) {
            $this->addResource($route);
        }

        // APPLICATION PERMISSIONS
        // Now we allow or deny a role's access to resources. The third argument
        // is 'privilege'. We're using HTTP method for resources.

        foreach ($resourcesFront as $route => $method) {
            $this->allow('guest', $route, $method);
        }

        $this->allow('admin');
    }
}