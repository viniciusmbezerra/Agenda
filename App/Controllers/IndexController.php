<?php

namespace App\Controllers;

//recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action {

    public function login() {

        $this->view->login = isset($_GET['login']) ? $_GET['login'] : '';

        $this->render('login', 'layout_index');
    }

    public function cadastro() {

        $this->view->erroCadastro = false;

        $this->render('cadastro', 'layout_index');
    }

    public function cadastrar() {

        $usuario = Container::getModel('Usuario');

        $usuario->__set('nome', $_POST['nome']);
        $usuario->__set('email', $_POST['email']);
        $usuario->__set('senha', $_POST['senha']);

        if($usuario->validarCadastro() && count($usuario->getUsuarioPorEmail()) == 0) {
            $usuario->salvar();

            header('Location: /');
        } else {

            $this->view->erroCadastro = true;

            header('Location: cadastro');
        }
    }

}

?> 