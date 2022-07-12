<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

	protected function initRoutes() {

		//rotas da index
		$routes['login'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'login'
		);

		$routes['cadastro'] = array(
			'route' => '/cadastro',
			'controller' => 'indexController',
			'action' => 'cadastro'
		);

		$routes['sair'] = array(
            'route' => '/sair',
            'controller' => 'AuthController',
            'action' => 'sair'
        );

		$routes['autenticar'] = array(
            'route' => '/autenticar',
            'controller' => 'AuthController',
            'action' => 'autenticar'
        );

        $routes['cadastrar'] = array(
            'route' => '/cadastrar',
            'controller' => 'indexController',
            'action' => 'cadastrar'
        );

		//rotas para contato
		$routes['contato'] = array(
			'route' => '/contato',
			'controller' => 'AppController',
			'action' => 'contato'
		);

		$routes['form_contato'] = array(
			'route' => '/form_contato',
			'controller' => 'AppController',
			'action' => 'form_contato'
		);

		$routes['cadastrar_contato'] = array(
			'route' => '/cadastrar_contato',
			'controller' => 'AppController',
			'action' => 'cadastrar_contato'
		);

		$routes['atualizar_contato'] = array(
			'route' => '/atualizar_contato',
			'controller' => 'AppController',
			'action' => 'atualizar_contato'
		);

		$routes['deletar_contato'] = array(
			'route' => '/deletar_contato',
			'controller' => 'AppController',
			'action' => 'deletar_contato'
		);

		//rotas para compromisso
		$routes['compromisso'] = array(
			'route' => '/compromisso',
			'controller' => 'AppController',
			'action' => 'compromisso'
		);

		$routes['form_compromisso'] = array(
			'route' => '/form_compromisso',
			'controller' => 'AppController',
			'action' => 'form_compromisso'
		);

		$routes['cadastrar_compromisso'] = array(
			'route' => '/cadastrar_compromisso',
			'controller' => 'AppController',
			'action' => 'cadastrar_compromisso'
		);

		$routes['atualizar_compromisso'] = array(
			'route' => '/atualizar_compromisso',
			'controller' => 'AppController',
			'action' => 'atualizar_compromisso'
		);

		$routes['deletar_compromisso'] = array(
			'route' => '/deletar_compromisso',
			'controller' => 'AppController',
			'action' => 'deletar_compromisso'
		);

		//utilidades
		$routes['configuracoes'] = array(
			'route' => '/configuracoes',
			'controller' => 'ConfigController',
			'action' => 'configuracoes'
		);

		$routes['atualizar_tema'] = array(
			'route' => '/atualizar_tema',
			'controller' => 'ConfigController',
			'action' => 'atualizar_tema'
		);

		$this->setRoutes($routes);
	}

}

?>