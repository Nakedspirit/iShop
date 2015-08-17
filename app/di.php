<?php

/**
 * Венедрение зависимостей
 *
 * @package Gksoft
 * @author  Galina Kozyreva <kozyreva.galinka@gmail.com>
 */

use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\Helper\SlotsHelper;
use Symfony\Bundle\FrameworkBundle\Templating\Helper\ActionsHelper;

$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new Silex\Provider\DoctrineServiceProvider(), array('db.options' => $app['config']['db']));
$app->register(new Silex\Provider\SessionServiceProvider());

/* Представление */

$app['templating.engine.php'] = $app->share(function() use ($app) {
    $phpEngine = new PhpEngine(new TemplateNameParser(), new FilesystemLoader(__DIR__.'/../templates/%name%'));

    /* Хелперы представления */
    $phpEngine->set(new SlotsHelper());
    $inlineFragmentRenderer = new \Symfony\Component\HttpKernel\Fragment\InlineFragmentRenderer($app);
    $requestStack = new \Symfony\Component\HttpFoundation\RequestStack();
    $requestStack->push($app['request']);
    $fragmentHandler = new \Symfony\Component\HttpKernel\Fragment\FragmentHandler(array($inlineFragmentRenderer), $app['debug'], $requestStack);
    $phpEngine->set(new ActionsHelper($fragmentHandler));

    return $phpEngine;
});

/* Модели */

$app['models.products'] = $app->share(function() use ($app) {
    return new Gksoft\Models\Catalog($app['db']);
});

$app['models.users'] = $app->share(function() use ($app) {
    return new Gksoft\Models\Users($app['db']);
});

/* Контроллеры */

$app['controllers.index'] = $app->share(function() use ($app) {
    return new Gksoft\Controllers\IndexController($app['templating.engine.php'], $app['models.products'], $app, $app['request']);
});

$app['controllers.catalog'] = $app->share(function() use ($app) {
    return new Gksoft\Controllers\CatalogController($app['templating.engine.php'], $app['models.products'], $app, $app['request']);
});

$app['controllers.users'] = $app->share(function() use ($app) {
    return new Gksoft\Controllers\UsersController($app['templating.engine.php'], $app['models.users'], $app, $app['request']);
});

$app['controllers.cart'] = $app->share(function() use ($app) {
    return new Gksoft\Controllers\CartController($app['templating.engine.php'], $app['models.cart'], $app, $app['request']);
});


