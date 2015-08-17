<?php

namespace Gksoft\Controllers;

use Symfony\Component\Templating\EngineInterface as TemplatingEngineInterface;
use Gksoft\Models\Users;
use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

/**
 * Контроллер пользователей
 *
 * @package Gksoft\Controllers
 * @author  Galina Kozyreva <kozyreva.galinka@gmail.com>
 */
class UsersController {

    /**
     * @var \Symfony\Component\Templating\EngineInterface
     */
    protected $view;

    /**
     * @var \Gksoft\Models\Users
     */
    protected $usersModel;

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
     * @param Users                     $usersModel   Модель пользователей
     * @param Application               $app          Приложение
     * @param Request                   $request      Запрос
     */
    public function __construct(TemplatingEngineInterface $view, Users $usersModel, Application $app, Request $request)
    {
        $this->view = $view;
        $this->request = $request;
        $this->usersModel = $usersModel;
        $this->app = $app;
    }

    /**
     * Действие страницы авторизации пользователя
     *
     * @return string|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function loginAction() {

        // перенапраялвяем пользователя на главную
        // если он уже авторизован
        $user = $this->app['session']->get('user');
        if ($user) {
            return $this->app->redirect('/');
        }

        $email = $this->request->get('email');
        $password = $this->request->get('password');

        $errors = array();

        // если форма отправлена POST-ом
        if ($this->request->isMethod('POST')) {
            $user = $this->usersModel->getUserByEmail($email);
            if ($user && $user['password'] == md5($password)) {
                // авторизация прошла успешно
                // записываем пользователя в сессию и отправляем на главную страницу
                $this->app['session']->set('user', $user);
                return $this->app->redirect('/');
            } else {
                // Авторизация не прошла
                $errors[] = 'Пользователь с указзанным адресом электронной почты и паролем не найден. Пожалуйста, проверьте правильность введенных данных и повторите попытку.';
            }
        }

        return $this->view->render('user/login.phtml', array(
            'loginFormData' => array(
                'email' => $email,
                'password' => $password
            ),
            'errors' => $errors
        ));
    }

    /**
     * Действие для вывода блока профиля пользователя
     *
     * @return string
     */
    public function loginBlockAction() {
        $user = $this->app['session']->get('user');
        return $this->view->render('user/login_block.phtml', array('user' => $user));
    }

    /**
     * Действие для деавторизации пользователя
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function logoutAction() {
        $this->app['session']->clear('user');
        return $this->app->redirect('/');
    }

    /**
     * Действие страницы регистрации пользователя
     *
     * @return string
     */
    public function registrationAction() {

        // если пользователь уже авторизован, переадресуем на главную
        $user = $this->app['session']->get('user');
        if ($user) {
            return $this->app->redirect('/');
        }

        /**
         * Возможны три варианта значения статуса регистрации
         *
         * @var null|bool $registrationStatus
         */
        $registrationStatus = null;

        // получаем данные запроса
        $firstName             = $this->request->get('first_name');
        $lastName              = $this->request->get('last_name');
        $email                 = $this->request->get('email');
        $password              = $this->request->get('password');
        $passwordConfirmation  = $this->request->get('password_confirmation');
        $address               = $this->request->get('address');
        $phone                 = $this->request->get('phone');

        // данные для рендеринга формы регистрации
        $registrationFormData = array(
            'firstName'             => $firstName,
            'lastName'              => $lastName,
            'email'                 => $email,
            'address'               => $address,
            'phone'                 => $phone
        );

        // если пришел POST-запрос с данными формы регистрации,
        // то пробуем регистрировать пользователя
        if ($this->request->isMethod('POST')) {
            $registrationStatus = $this->usersModel->register(
                $email,
                $password,
                $passwordConfirmation,
                $firstName,
                $lastName,
                $address,
                $phone
            );
        }

        return $this->view->render('user/registration.phtml', array(
            'registrationFormData' => $registrationFormData,
            'registrationStatus' => $registrationStatus
        ));
    }
}