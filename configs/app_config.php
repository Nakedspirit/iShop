<?php

/**
 * Конфигурация приложения
 *
 * @package Gksoft
 * @author  Galina Kozyreva <kozyreva.galinka@gmail.com>
 */

return array(
    'debug' => true,
    'config' => array(
        'db' => array(
            'driver'    => 'pdo_mysql',
            'host'      => '127.0.0.1',
            'dbname'    => 'gksoft',
            'user'      => 'root',
            'password'  => null,
            'charset'   => 'utf8',
        )
    )
);