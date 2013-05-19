Google App Engine Login provider for Silex

Usage example:

Google app engine configuration:
```yaml
application: silexgae
version: 1
runtime: php
api_version: 1
threadsafe: true

handlers:
- url: .*
  script: main.php
```

Silex Application:
```php
<?php
require_once __DIR__ . '/vendor/autoload.php';

use Silex\Application;
use Gae\LoginProvider;
use Gae\Auth;

$app = new Application();
$app->register(new LoginProvider(), array(
    'auth.onlogin.callback.url' => '/private',
    'auth.onlogout.callback.url' => '/loggedOut',
));

/** @var Auth $auth */
$auth = $app['gae.auth']();

$app->get('/', function () use ($app, $auth) {
    return $auth->isLogged() ?
        $app->redirect("/private") :
        "<a href='" . $auth->getLoginUrl() . "'>login</a>";
});
$app->get('/private', function () use ($app, $auth) {
    return $auth->isLogged() ?
        "Hello " . $auth->getUser()->getNickname() . " <a href='" . $auth->getLogoutUrl() . "'>logout</a>" :
        $auth->getRedirectToLogin();
});

$app->get('/loggedOut', function () use ($app) {
    return "Thank you!";
});

$app->run();
```