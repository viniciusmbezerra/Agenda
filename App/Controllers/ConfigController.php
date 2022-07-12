<?php

namespace App\Controllers;

//recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class ConfigController extends Action {
    
    public function configuracoes() {

        AppController::validaAutenticacao();

        $tema = Container::getModel('Tema');
        $tema->__set('fk_idusuario', $_SESSION['idusuario']);
        $this->view->tema = $tema->getInfoTema();

        $this->render('configuracoes', 'layout_app');
    }

    public static function render_tema() {

        $tema = Container::getModel('Tema');
        $tema->__set('fk_idusuario', $_SESSION['idusuario']);
        $tema = $tema->getInfoTema();

        $count = 1;
        $css = file_get_contents('css/user.css');
        $css = str_replace('{cor_fundo}', $tema['cor_fundo'], $css, $count);
        $css = str_replace('{cor_texto}', $tema['cor_texto'], $css, $count);
        $css = str_replace('{cor_barra_nav}', $tema['cor_barra_nav'], $css, $count);
        file_put_contents('css/user.css', $css);
        print_r($css);
    }

    public static function reset_tema() {

        $tema = Container::getModel('Tema');
        $tema->__set('fk_idusuario', $_SESSION['idusuario']);
        $tema = $tema->getInfoTema();

        $count = 1;
        $css = file_get_contents('css/user.css');
        $css = str_replace($tema['cor_fundo'], '{cor_fundo}', $css, $count);
        $css = str_replace($tema['cor_texto'], '{cor_texto}', $css, $count);
        $css = str_replace($tema['cor_barra_nav'], '{cor_barra_nav}', $css, $count);
        file_put_contents('css/user.css', $css);
        print_r($css);
    }

    public function atualizar_tema() {

        AppController::validaAutenticacao();

        $tema = Container::getModel('Tema');

        $tema->__set('cor_fundo', $_GET['cor_fundo']);
        $tema->__set('cor_texto', $_GET['cor_texto']);
        $tema->__set('cor_barra_nav', $_GET['cor_barra_nav']);
        $tema->__set('fk_idusuario', $_SESSION['idusuario']);
        echo '<pre>';
        self::reset_tema();

        $tema->atualizar();
        print_r($tema->getInfoTema());

        self::render_tema();

        header('Location: /configuracoes');
    }

}

?> 