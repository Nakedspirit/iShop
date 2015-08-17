<?php

namespace Gksoft\Models;

use Doctrine\DBAL\Connection;

/**
 * Модель корзины
 *
 * @package Gksoft\Models
 * @author  Galina Kozyreva <kozyreva.galinka@gmail.com>
 */
class Cart {

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
}