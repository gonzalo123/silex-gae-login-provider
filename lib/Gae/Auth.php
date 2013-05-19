<?php
namespace Gae;

require_once 'google/appengine/api/users/UserService.php';

use google\appengine\api\users\User;
use google\appengine\api\users\UserService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Silex\Application;

class Auth
{
    private $user = null;
    private $loginUrl;
    private $logoutUrl;
    private $logged;

    public function __construct(Application $app, User $user=null)
    {
        $this->user = $user;

        if (is_null($user)) {
            $this->loginUrl = UserService::createLoginUrl($app['auth.onlogin.callback.url']);
            $this->logged = false;
        } else {
            $this->logged = true;
            $this->logoutUrl = UserService::createLogoutUrl($app['auth.onlogout.callback.url']);
        }
    }

    /**
     * @return RedirectResponse
     */
    public function getRedirectToLogin()
    {
        return new RedirectResponse($this->getLoginUrl());
    }
    /**
     * @return boolean
     */
    public function isLogged()
    {
        return $this->logged;
    }

    /**
     * @return string
     */
    public function getLoginUrl()
    {
        return $this->loginUrl;
    }

    /**
     * @return string
     */
    public function getLogoutUrl()
    {
        return $this->logoutUrl;
    }

    /**
     * @return \google\appengine\api\users\User|null
     */
    public function getUser()
    {
        return $this->user;
    }
}