<?php

/**
 * Маршрутизация
 *
 * @package Gksoft
 * @author  Galina Kozyreva <kozyreva.galinka@gmail.com>
 */

// Главная страница
$app->get('/', "controllers.index:indexAction");

/* Каталог */
$app->get('/category/{url}', "controllers.catalog:categoryAction");
$app->get('/product/{url}', "controllers.catalog:productAction");

/* Пользователь */
$app->match('/login/',"controllers.users:loginAction")->method('GET|POST');
$app->match('/registration/',"controllers.users:registrationAction")->method('GET|POST');
$app->post('/logout/',"controllers.users:logoutAction");

/* Корзина */
$app->get('/cart/add/{product_id}', "controllers.cart:addAction");
$app->post('/cart/remove/{product_id}', "controllers.cart:removeAction");