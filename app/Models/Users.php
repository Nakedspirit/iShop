<?php

namespace Gksoft\Models;

use Doctrine\DBAL\Connection;

/**
 * Модель пользователей
 *
 * @package Gksoft\Models
 * @author  Galina Kozyreva <kozyreva.galinka@gmail.com>
 */
class Users {

    const
        ROLE_ID_ADMIN = 1,
        ROLE_ID_USER  = 2;

    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $db;

    /**
     * @param Connection $db DBAL
     */
    public function __construct(Connection $db) {
        $this->db = $db;
    }

    /**
     * Получить данные пользователя по его адресу электронной почты
     *
     * @param $email
     *
     * @return array
     */
    public function getUserByEmail($email) {
        return $this->db->fetchAssoc('SELECT * FROM `users` WHERE `email` = ?', array($email));
    }

    /**
     * Зарегистрировать пользователя
     *
     * @param string      $email                Адрес электронной почты
     * @param string      $password             Пароль
     * @param string      $passwordConfirmation Подтверждение пароля
     * @param string      $firstName            Имя
     * @param string      $lastName             Фамилия
     * @param string      $address              Адрес
     * @param string|null $phone                Телефон
     *
     * @return bool
     */
    public function register($email, $password, $passwordConfirmation, $firstName, $lastName, $address, $phone = null) {
        return (
            $this->validateEmail($email)
            && $this->validatePassword($password, $passwordConfirmation)
            && $this->validateName($firstName)
            && $this->validateName($lastName)
            && $this->validateAddress($address)
            && (!$phone || $this->validatePhone($phone))
            && $this->db->insert('users', array(
                'email' => $email,
                'password' => md5($password),
                'first_name' => $firstName,
                'last_name' => $lastName,
                'address' => $address,
                'phone' => $phone,
                'role_id' => self::ROLE_ID_USER
            ))
        );
    }

    /**
     * Проверить правильность адреса электронной почты
     *
     * @param string $email Адрес электронной почты
     *
     * @return bool
     */
    protected function validateEmail($email) {
        $filteredEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
        return $email === $filteredEmail;
    }

    /**
     * Проверить правлильность пароля
     *
     * @param string $password             Пароль
     * @param string $passwordConfirmation Подтверждение пароля
     *
     * @return bool
     */
    protected function validatePassword($password, $passwordConfirmation) {
        return !empty($password) && ($password == $passwordConfirmation);
    }

    /**
     * Проверить правлильность имени или фамилии
     *
     * @param string $name Имя или фамилия
     *
     * @return bool
     */
    protected function validateName($name) {
        return !empty($name);
    }

    /**
     * Проверить правильность адреса
     *
     * @param string $address Адрес
     *
     * @return bool
     */
    protected function validateAddress($address) {
        return !empty($address);
    }

    /**
     * Проверить правильность номера телефона
     *
     * @param string $phone Номер телефона
     *
     * @return bool
     */
    protected function validatePhone($phone) {
        return !empty($phone);
    }
}