<?php

return [

    //MainController
    //Главная страница
    '' => [
        'controller' => 'main',
        'action' => 'index',
    ],
    'blog/{id:\d+}' => [
        'controller' => 'main',
        'action' => 'blog',
    ],
    'about' => [
        'controller' => 'main',
        'action' => 'about',
    ],
    'contact' => [
        'controller' => 'main',
        'action' => 'contact',
    ],

    //AdminController
    'admin/login' => [
        'controller' => 'admin',
        'action' => 'login',
    ],
    'admin/logout' => [
        'controller' => 'admin',
        'action' => 'logout',
    ],
    'admin/add' => [
        'controller' => 'admin',
        'action' => 'add',
    ],
    'admin/edit/{id:\d+}' => [
        'controller' => 'admin',
        'action' => 'edit',
    ],
    'admin/posts' => [
        'controller' => 'admin',
        'action' => 'posts',
    ],
    'admin/delete/{id:\d+}' => [
        'controller' => 'admin',
        'action' => 'delete',
    ],

];