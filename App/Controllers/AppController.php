<?php

namespace App\Controllers;

//recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action {
    
    public static function validaAutenticacao() {
    
        session_start();
    
        if(!isset($_SESSION['idusuario']) || $_SESSION['idusuario'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == ''){
            header('Location: /?login=erro');
        }
    }

    //métodos do compromisso
    public function compromisso() {

        $this->validaAutenticacao();

        $compromisso = Container::getModel('Compromisso');
        $this->view->compromissos = $compromisso->getAll();

        $this->render('compromisso', 'layout_app');
    }

    public function form_compromisso() {

        $this->validaAutenticacao();

        $compromisso = Container::getModel('compromisso');
        
        if(isset($_GET['acao']) and $_GET['acao']=='criar') {

            $this->view->infoCompromisso = array(
                'idcompromisso' => '',
                'descricao' => '',
                'data_compromisso' => '',
            );
            $this->view->acao = "cadastrar";

        } else if(isset($_GET['acao']) and $_GET['acao']=='editar') {

            $compromisso->__set('idcompromisso', $_GET['idcompromisso']);
            $compromisso = $compromisso->getInfoCompromisso();

            $this->view->infoCompromisso = array(
                'idcompromisso' => $compromisso['idcompromisso'],
                'descricao' => $compromisso['descricao'],
                'data_compromisso' => $compromisso['data_compromisso'],
            );
            $this->view->acao = "atualizar";

        }

        $this->view->erroCadastro = false;

        $this->render('form_compromisso', 'layout_app');
    }

    public function cadastrar_compromisso() {

        $this->validaAutenticacao();

        $compromisso = Container::getModel('Compromisso');

        $compromisso->__set('descricao', $_POST['descricao']);
        $compromisso->__set('data_compromisso', $_POST['data_compromisso']);

        if($compromisso->validarCadastro() && count($compromisso->getCompromissoPorDescricao()) == 0) {
            $compromisso->salvar();

            header('Location: /compromisso');
        } else {

            $this->view->compromisso = array(
                'compromisso' => $_POST['compromisso'],
                'data_compromisso' => $_POST['data_compromisso'],
            );

            $this->view->erroCadastro = true;

            header('Location: /compromisso');
        }
    }

    public function atualizar_compromisso() {

        $this->validaAutenticacao();

        $compromisso = Container::getModel('Compromisso');

        $compromisso->__set('idcompromisso', $_POST['idcompromisso']);
        $compromisso->__set('descricao', $_POST['descricao']);
        $compromisso->__set('data_compromisso', $_POST['data_compromisso']);

        $compromisso->atualizar();

        header('Location: /compromisso');
    }

    public function deletar_compromisso() {

        $this->validaAutenticacao();

        $compromisso = Container::getModel('compromisso');

        $compromisso->__set('idcompromisso', $_GET['idcompromisso']);

        $compromisso->deletar();

        header('Location: /compromisso');
    }

    //métodos do contato
    public function contato() {

        $this->validaAutenticacao();

        $contato = Container::getModel('contato');
        $this->view->contatos = $contato->getAll();

        $this->render('contato', 'layout_app');
    }

    public function form_contato() {

        $this->validaAutenticacao();

        $contato = Container::getModel('Contato');
        
        if(isset($_GET['acao']) and $_GET['acao']=='criar') {

            $this->view->infoContato = array(
                'idcontato' => '',
                'nome' => '',
                'telefone' => '',
                'email' => ''
            );
            $this->view->acao = "cadastrar";

        } else if(isset($_GET['acao']) and $_GET['acao']=='editar') {

            $contato->__set('idcontato', $_GET['idcontato']);
            $contato = $contato->getInfoContato();

            $this->view->infoContato = array(
                'idcontato' => $contato['idcontato'],
                'nome' => $contato['nome'],
                'telefone' => $contato['telefone'],
                'email' => $contato['email']
            );
            $this->view->acao = "atualizar";

        }

        $this->view->erroCadastro = false;

        $this->render('form_contato', 'layout_app');
    }

    public function cadastrar_contato() {

        $this->validaAutenticacao();

        $contato = Container::getModel('contato');

        $contato->__set('nome', $_POST['nome']);
        $contato->__set('telefone', $_POST['telefone']);
        $contato->__set('email', $_POST['email']);

        if($contato->validarCadastro() && count($contato->getContatoPorNome()) == 0) {
            $contato->salvar();

            header('Location: /contato');
        } else {

            $this->view->contato = array(
                'nome' => $_POST['nome'],
                'telefone' => $_POST['telefone'],
                'email' => $_POST['email']
            );

            $this->view->erroCadastro = true;

            header('Location: /contato');
        }
    }

    public function atualizar_contato() {

        $this->validaAutenticacao();

        $contato = Container::getModel('Contato');

        $contato->__set('idcontato', $_POST['idcontato']);
        $contato->__set('nome', $_POST['nome']);
        $contato->__set('telefone', $_POST['telefone']);
        $contato->__set('email', $_POST['email']);

        $contato->atualizar();

        header('Location: /contato');
    }

    public function deletar_contato() {

        $this->validaAutenticacao();

        $contato = Container::getModel('Contato');

        $contato->__set('idcontato', $_GET['idcontato']);

        $contato->deletar();

        header('Location: /contato');
    }

}

?>