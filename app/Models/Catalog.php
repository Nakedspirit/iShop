<?php

namespace Gksoft\Models;

use Doctrine\DBAL\Connection;

/**
 * Модель каталога
 *
 * @package Gksoft\Models
 * @author  Galina Kozyreva <kozyreva.galinka@gmail.com>
 */
class Catalog {

    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $db;

    /**
     * @param Connection $db
     */
    public function __construct(Connection $db) {
        $this->db = $db;
    }

    /**
     * Получить данные о продукте
     *
     * @param $url URL продукта
     *
     * @return array
     */
    public function getProduct($url) {
        return $this->db->fetchAssoc('SELECT * FROM `products` WHERE `url` = ?', array($url));
    }

    /**
     * Получить все категории
     *
     * @return array
     */
    public function getAllCategories() {
        $allCategories = $this->db->fetchAll('SELECT * FROM `categories`');

        $categoriesTree = array();
        foreach ($allCategories as $category) {
            if ($category['parent_id']) {
                $categoriesTree[$category['parent_id']]['_children'][$category['id']] = $category;
            } else {
                $categoriesTree[$category['id']] = $category;
            }
        }

        return $categoriesTree;
    }

    /**
     * Получить продукты по ID категории
     *
     * @param $categoryId ID категории
     *
     * @return array
     */
    public function getProductsByCategoryId($categoryId) {
        return $this->db->fetchAll(
            'SELECT `products`.* FROM `products`
                INNER JOIN `products_categories`
                    ON `products`.`id` = `products_categories`.`product_id`
            WHERE `products_categories`.`category_id` = ?',
            array($categoryId)
        );
    }

    /**
     * Получить данные категории по ее URL
     *
     * @param $url URL категории
     *
     * @return array
     */
    public function getCategory($url){
        return $this->db->fetchAssoc('SELECT * FROM `categories` WHERE `url` = ?', array($url));
    }

    /**
     * Преобразовать цену из копеек в рубли
     *
     * @param int $priceKop Цена в копейках
     *
     * @return int
     */
    public function convertPrice($priceKop) {
        return $priceKop / 100;
    }
}