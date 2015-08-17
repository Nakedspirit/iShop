<?php

namespace Gksoft\Controllers;

use Symfony\Component\Templating\EngineInterface as TemplatingEngineInterface;
use Gksoft\Models\Cart;
use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

/**
 * Контроллер корзины
 *
 * @package Gksoft\Controllers
 * @author  Galina Kozyreva <kozyreva.galinka@gmail.com>
 */
class CartController {

    /**
     * @var \Symfony\Component\Templating\EngineInterface
     */
    protected $view;

    /**
     * @var \Gksoft\Models\Cart
     */
    protected $cartModel;

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * @var \Silex\Application
     */
    protected $app;

    /**
     * @param TemplatingEngineInterface $view         Представление
     * @param Cart                      $cartModel    Модель корзины
     * @param Application               $app          Приложение
     * @param Request                   $request      Запрос
     */
    public function __construct(TemplatingEngineInterface $view, Cart $cartModel, Application $app, Request $request)
    {
        $this->view = $view;
        $this->request = $request;
        $this->cartModel = $cartModel;
        $this->app = $app;
    }

    public function addAction()
    {
        return 'TODO';
        //$productId = $this->request->get('product_id');
    }
}