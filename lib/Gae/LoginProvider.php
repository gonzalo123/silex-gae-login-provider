<?php
namespace Gae;

require_once 'google/appengine/api/users/UserService.php';

use google\appengine\api\users\UserService;
use Gae\Auth;
use Silex\Application;
use Silex\ServiceProviderInterface;

class LoginProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['gae.auth'] = $app->protect(function () use ($app) {
            return new Auth($app, UserService::getCurrentUser());
        });
    }

    public function boot(Application $app)
    {
    }
}