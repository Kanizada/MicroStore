<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use MicroStore\DAO\ArticleDAO;

// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();

// Register service providers.
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

$app['twig'] = $app->share($app->extend('twig', function(Twig_Environment $twig, $app) {
    $twig->addExtension(new Twig_Extensions_Extension_Text());
    return $twig;
}));
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'secured' => array(
            'pattern' => '^/.*$',
            'anonymous' => true,
            'logout' => array(
                    'logout_path' => '/logout',
                    'invalidate_session' => true
            ),
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
            'users' => $app->share(function () use ($app) {
                return new MicroStore\DAO\UserDAO($app['db']);
            }),
        ),
    ),
    'security.role_hierarchy' => array(
        'ROLE_ADMIN' => array('ROLE_USER'),
    ),
    'security.access_rules' => array(
        array('^/login$', 'IS_AUTHENTICATED_ANONYMOUSLY'),
        array('/login_check', 'IS_AUTHENTICATED_ANONYMOUSLY'),
        array('/register', 'IS_AUTHENTICATED_ANONYMOUSLY'),
        array('/register_check', 'IS_AUTHENTICATED_ANONYMOUSLY'),
        array('/produit', 'IS_AUTHENTICATED_ANONYMOUSLY'),
        array('^/.+$', 'ROLE_USER'),
        array('^/user', 'ROLE_USER'),
        array('^/admin', 'ROLE_ADMIN'),
    ),
));
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());

// Register services

$app['dao.user'] = $app->share(function ($app) {
    return new MicroStore\DAO\UserDAO($app['db']);
});
$app['dao.produit'] = $app->share(function ($app) {
    return new MicroStore\DAO\ProduitDAO($app['db']);
});
