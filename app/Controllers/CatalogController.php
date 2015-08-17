<?php

namespace Gksoft\Controllers;

use Symfony\Component\Templating\EngineInterface as TemplatingEngineInterface;
use Gksoft\Models\Catalog;
use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

/**
 * Контроллер каталога товаров
 *
 * @package Gksoft\Controllers
 * @author  Galina Kozyreva <kozyreva.galinka@gmail.com>
 */
class CatalogController {

    /**
     * @var \Symfony\Component\Templating\EngineInterface
     */
    protected $view;

    /**
     * @var \Gksoft\Models\Catalog
     */
    protected $catalogModel;

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
     * @param Catalog                   $catalogModel Модель каталога
     * @param Application               $app          Приложение
     * @param Request                   $request      Запрос
     */
    public function __construct(TemplatingEngineInterface $view, Catalog $catalogModel, Application $app, Request $request)
    {
        $this->view = $view;
        $this->request = $request;
        $this->catalogModel = $catalogModel;
        $this->app = $app;
    }

    /**
     * Действие для страницы продукта
     *
     * @param string $url URL товара
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return string
     */
    public function productAction($url) {
        $product = $this->catalogModel->getProduct($url);
        if (!$product) {
            $this->app->abort(404, "Товар с URL '{$url}' не найден");
        }
        $product['price'] = $this->catalogModel->convertPrice($product['price']);
        return $this->view->render('catalog/product.phtml', array('product' => $product));
    }

    /**
     * Действие для страницы категории
     *
     * @param string $url URL категории
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return string
     */
    public function categoryAction($url) {
        $category = $this->catalogModel->getCategory($url);
        if (!$category) {
            $this->app->abort(404, "Категория c URL '{$url}' не найдена");
        }
        $products = $this->catalogModel->getProductsByCategoryId($category['id']);
        foreach ($products as &$product) {
            $product['price'] = $this->catalogModel->convertPrice($product['price']);
        }
        return $this->view->render('catalog/category.phtml', array(
            'category' => $category,
            'products' => $products
        ));
    }
}