USE `gksoft`;

SET NAMES utf8;

INSERT INTO `vendors` (`id`, `name`) VALUES 
  (1, 'Microsoft'),
  (2, 'Kaspersky'),
  (3, '1С');

INSERT INTO `categories` (`id`, `parent_id`, `name`, `url`) VALUES

  (1, NULL, 'Безопасность', 'security'),
  (2, 1, 'Антивирусы', 'security-antivirus'),
  (3, 1, 'Интернет и сеть', 'security-intrnet'),

  (4, NULL, 'Игры', 'games'),
  (5, 4, 'Экшены', 'games-action'),
  (6, 4, 'Семейные', 'games-family'),
  (7, 4, 'Ролевые игры', 'games-rpg'),
  (8, 4, 'Стратегии', 'games-strategy'),
  (9, 4, 'Симуляторы', 'games-simulators'),

  (10, NULL, 'Операционные системы', 'os'),
  (11, 10, 'Семейство UNIX', 'os-unix'),
  (12, 10, 'Windows', 'os-windows'),

  (13, NULL, 'Офисные приложения', 'office'),

  (14, NULL, 'Графика и дизайн', 'design');

INSERT INTO `products` (`id`, `title`, `url`, `keywords`, `description`, `vendor_id`, `active`, `views`, `price`, `created`, `updated`) VALUES
  (1, 'Microsoft Windows 8', 'win8', 'Windows, Microsoft', 'Операционная система Microsoft Windows 8', 1, 1, 0, 1000000, NOW(), NOW()),
  (2, 'Microsoft Windows 7', 'win7', 'Windows, Microsoft', 'Операционная система Microsoft Windows 7', 1, 1, 0, 700000, NOW(), NOW()),
  (3, 'Mandriva Academie', 'mandriva_academie', 'Linux, Unix', 'Академическая программа Mandriva Linux.', 1, 1, 0, 9500000, NOW(), NOW()),
  (4, 'Kaspersky Internet Security', 'kaspersky_is', 'Internet Security, Kaspersky', 'Kaspersky Internet Security для всех устройств — единое комплексное решение для защиты любых устройств на платформах Windows®, Android™ и Mac OS. Купив Kaspersky Internet Security, вы обретёте беспрецедентный антивирусный иммунитет.', 2, 1, 0, 3000000, NOW(), NOW());

INSERT INTO `products_categories` (`product_id`, `category_id`) VALUES
  (1, 12),
  (1, 10),
  (2, 12),
  (2, 10),
  (3, 11),
  (3, 10),
  (4, 1),
  (4, 3);

INSERT INTO `roles` (`id`, `name`) VALUES
  (1, 'admin'),
  (2, 'user');

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone`, `address`, `password`, `role_id`) VALUES
  (1, 'Михаил', 'Михалков', 'misha@mail.ru', '+79269888888', 'г. Москва, ул. Свободы, 24, кв.147', '827ccb0eea8a706c4c34a16891f84e7b', 2),
  (2, 'Василий', 'Васильев', 'vasya@mail.ru', '+79269777777', 'г. Москва, ул. Свободы, 115', '827ccb0eea8a706c4c34a16891f84e7b', 2),
  (3, 'Жопа', 'Жопов', 'zhopa@mail.ru', '+79269555555', 'г. Москва, ул. Правды, 14, кв.7', '827ccb0eea8a706c4c34a16891f84e7b', 1);
