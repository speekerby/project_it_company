<?php
/**
 * Created by PhpStorm.
 * User: speek
 * Date: 08.06.2018
 * Time: 14:43
 */

namespace application\controllers;


use application\core\controller;
use application\lib\Pagination;
use application\models\main;

class AdminController extends controller
{
    public function __construct($route)
    {
        parent::__construct($route);
        $this->view->layout = 'admin';
    }

    //Авторизация в админ панель
    public function loginAction()
    {
        if (isset($_SESSION['admin'])) {
            $this->view->redirect('admin/add');
        }
        if (!empty($_POST)) {
            if (!$this->model->loginValidate($_POST)) {
                $this->view->message('error', $this->model->error);
            }
            $_SESSION['admin'] = true;
            $this->view->location('admin/add');
        }
        $this->view->render('Вход');
    }

    //Завершение сессии
    public function logoutAction()
    {
        unset($_SESSION['admin']);
        $this->view->redirect('admin/login');
    }

    //Добавление поста
    public function addAction()
    {
        if (!empty($_POST)) {
            if (!$this->model->postValidate($_POST, 'add')) {
                $this->view->message('error', $this->model->error);
            }
            $id = $this->model->postAdd($_POST);
            //Проверка на ID
            if (!$id) {
                $this->view->message('success', 'Ошибка обработки запроса');
            }

            //Загрузка изображения
            $this->model->postUploadImage($_FILES['img']['tmp_name'], $id);

            //Вывод сообщения
            $this->view->message('success', 'Пост добавлен');

        }
        $this->view->render('Добавить пост');
    }

    //Редактирование поста
    public function editAction()
    {
        //Проверка на ID
        if (!$this->model->isPostExists($this->route['id'])) {
            $this->view->errorCode(404);
        }

        if (!empty($_POST)) {
            if (!$this->model->postValidate($_POST, 'edit')) {
                $this->view->message('error', $this->model->error);
            }

            $this->model->postEdit($_POST, $this->route['id']);

            //Загрузка изображения
            if ($_FILES['img']['tmp_name']) {
                $this->model->postUploadImage($_FILES['img']['tmp_name'], $this->route['id']);
            }

            $this->view->message('success', 'Сохранено');
        }

        $vars = [
            'data' => $this->model->postData($this->route['id'])[0],
        ];

        $this->view->render('Редактировать пост', $vars);
    }

    //Вывод постов
    public function postsAction()
    {
        $mainModel = new main();
        $pagination = new Pagination($this->route, $mainModel->postsCount(), 6);
        $vars = [
            'pagination' => $pagination->get(),
            'list' => $mainModel->postsList($this->route)
        ];
        $this->view->render('Посты', $vars);
    }

    //Удаление поста
    public function deleteAction()
    {
        if (!$this->model->isPostExists($this->route['id'])) {
            $this->view->errorCode(404);
        }
        $this->model->postDelete($this->route['id']);
        $this->view->redirect('admin/posts');
    }
}