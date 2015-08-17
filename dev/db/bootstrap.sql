CREATE DATABASE `gksoft` DEFAULT CHARACTER SET utf8;

SET NAMES utf8;

USE `gksoft`;

CREATE TABLE `vendors` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

CREATE TABLE `categories` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10),
  `name` text NOT NULL,
  `url` varchar(255) NOT NULL UNIQUE,
  PRIMARY KEY (`id`),
  KEY `categories_parent_id_idx` (`parent_id`),
  CONSTRAINT `fk_categories_parent_id_categories_id` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

CREATE TABLE `products` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `url` varchar(255) NOT NULL UNIQUE,
  `keywords` text,
  `description` text,
  `vendor_id` int(10) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `views` int(10) NOT NULL DEFAULT '0',
  `price` int(10) NOT NULL,
  `catalog_image` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vendor_id_idx` (`vendor_id`),
  CONSTRAINT `fk_products_vendor_id_vendors_id` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `products_categories` (
  `product_id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL,
  KEY `product_categories_product_id_idx` (`product_id`),
  CONSTRAINT `fk_products_categories_product_id_products_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  KEY `product_categories_category_id_idx` (`category_id`),
  CONSTRAINT `fk_products_categories_category_id_categories_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `roles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` ENUM('admin', 'user') NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `phone` varchar(255),
  `address` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `users_role_id_idx` (`role_id`),
  CONSTRAINT `fk_users_role_id_roles_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `cart` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10),
  PRIMARY KEY (`id`),
  KEY `cart_user_id_users_id_idx` (`user_id`),
  CONSTRAINT `fk_cart_user_id_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `cart_items` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cart_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cart_items_cart_id_cart_id_idx` (`cart_id`),
  KEY `cart_items_product_id_products_id_idx` (`product_id`),
  CONSTRAINT `fk_cart_items_cart_id_cart_id` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`),
  CONSTRAINT `fk_cart_items_product_id_products_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;