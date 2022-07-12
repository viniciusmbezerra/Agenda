<?php

namespace App\Models;

//recursos do miniframework
use MF\Model\Container;

use MF\Model\Model;

class Usuario extends Model {
    private $idusuario;
    private $nome;
    private $email;
    private $senha;

    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
    }

    public function salvar() {
        $query = "insert into usuario(nome, email, senha) values(:nome, :email, :senha)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':senha', md5($this->__get('senha')));
        $stmt->execute();

        $tema = Container::getModel('Tema');
        $tema->__set('cor_fundo', '#414141');
        $tema->__set('cor_texto', '#ffffff');
        $tema->__set('cor_barra_nav', '#1c1c1c');
        $tema->__set('fk_idusuario', $this->getUsuarioPorEmail()[0]['idusuario']);
        $tema->salvar();

        return $this;
    }

    //validar se um cadastro pode ser feito
    public function validarCadastro() {
        $valido = true;
        if(strlen($this->__get('nome'))<3) {
            $valido = false;
        }

        if(strlen($this->__get('email'))<3) {
            $valido = false;
        }

        if(strlen($this->__get('senha'))<3) {
            $valido = false;
        }

        return $valido;
    }

    public function getUsuarioPorEmail() {
        $query = "select * from usuario where email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function autenticar() {
        $query = "select * from usuario where email = :email and senha = :senha";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':senha', $this->__get('senha'));
        $stmt->execute();

        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

        if($usuario['idusuario'] != '' && $usuario['nome'] != ''){
            $this->__set('idusuario', $usuario['idusuario']);
            $this->__set('nome', $usuario['nome']);
        }

        return $this;
    }

    public function getAll() {
        $query = "
            select 
                u.id,
                u.nome,
                u.email,
                (
                    select
                        count(*)
                    from
                        usuarios_seguidores as us
                    where
                        us.id_usuario = :id_usuario and us.id_usuario_seguindo = u.id
                ) as seguindo_sn
            from 
                usuarios as u
            where 
                u.nome like :nome and u.id != :id_usuario";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', '%'.$this->__get('nome').'%');
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getInfoUsuario() {
        $query = "select nome from usuarios where id = :id_usuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

}

?>