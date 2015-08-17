<?php

namespace Gksoft\Controllers;

use Symfony\Component\Templating\EngineInterface as TemplatingEngineInterface;
use Gksoft\Models\Catalog;
use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

/**
 * Основной контроллер
 *
 * @package Gksoft\Controllers
 * @author  Galina Kozyreva <kozyreva.galinka@gmail.com>
 */
class IndexController {

    /**
     * @var \Symfony\Component\Templating\EngineInterface
     */
    protected $view;

    /**
     * @var \Gksoft\Models\Catalog
     */
    protected $catalogModel;

    /**
     * @var \Silex\Application
     */
    protected $app;

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * @param TemplatingEngineInterface $view         Представление
     * @param Catalog                   $catalogModel Модель каталога
     * @param Application               $app          Приложение
     * @param Request                   $request      Запрос
     */
    public function __construct(TemplatingEngineInterface $view, Catalog $catalogModel, Application $app, Request $request) {
        $this->view = $view;
        $this->request = $request;
        $this->catalogModel = $catalogModel;
        $this->app = $app;
    }

    /**
     * Действие для главной страницы
     *
     * @return string
     */
    public function indexAction() {
        $categoriesTree = $this->catalogModel->getAllCategories();
        $user = $this->app['session']->get('user');
        return $this->view->render('index.phtml', array(
            'categoriesTree' => $categoriesTree,
            'user' => $user
        ));
    }
}