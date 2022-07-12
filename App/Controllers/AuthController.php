<?php

namespace App\Controllers;

//recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AuthController extends Action {

    public function autenticar() {

        $usuario = Container::getModel('Usuario');

        $usuario->__set('email', $_POST['email']);
        $usuario->__set('senha', md5($_POST['senha']));

        $usuario = $usuario->autenticar();

        if($usuario->__get('idusuario') != '' && $usuario->__get('nome') != ''){
            session_start();

            $_SESSION['idusuario'] = $usuario->__get('idusuario');
            $_SESSION['nome'] = $usuario->__get('nome');

            ConfigController::render_tema();

            header('Location: /compromisso');
        } else {

            header('Location: /?login=erro');
        }
    }

    public function sair() {
        session_start();

        ConfigController::reset_tema();

        session_destroy();
        header('Location: /');
    }
}