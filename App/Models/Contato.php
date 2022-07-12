<?php

namespace App\Models;

use MF\Model\Model;

class Contato extends Model {
    private $idcontato;
    private $nome;
    private $telefone;
    private $email;
    private $usuario;

    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
    }

    public function salvar() {
        $query = "
                insert into 
                    contato(nome, telefone, email, fk_idusuario) 
                values(:nome, :telefone, :email, :fk_idusuario)
                ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':telefone', $this->__get('telefone'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':fk_idusuario', $_SESSION['idusuario']);
        $stmt->execute();

        return $this;
    }

    public function atualizar() {
        $query = "
                update 
                    contato 
                set 
                    nome = :nome,
                    telefone = :telefone,
                    email = :email 
                where 
                    idcontato = :idcontato and 
                    fk_idusuario = :fk_idusuario
                ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':telefone', $this->__get('telefone'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':idcontato', $this->__get('idcontato'));
        $stmt->bindValue(':fk_idusuario', $_SESSION['idusuario']);
        $stmt->execute();
    }

    public function deletar() {
        $query = "
                delete from 
                    contato 
                where 
                    idcontato = :idcontato and 
                    fk_idusuario = :fk_idusuario
                    ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':idcontato', $this->__get('idcontato'));
        $stmt->bindValue(':fk_idusuario', $_SESSION['idusuario']);
        $stmt->execute();
    }

    public function validarCadastro() {
        $valido = true;
        if(strlen($this->__get('nome'))<3) {
            $valido = false;
        }

        return $valido;
    }

    public function getContatoPorNome() {
        $query = "
                select 
                    nome 
                from 
                    contato 
                where 
                    nome = :nome and 
                    fk_idusuario = :fk_idusuario
                ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':fk_idusuario', $_SESSION['idusuario']);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAll() {
        $query = "
            select 
                *
            from 
                contato as c
            where 
                c.fk_idusuario = :idusuario";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':idusuario', $_SESSION['idusuario']);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getInfoContato() {
        $query = "
                select * from contato where idcontato = :idcontato";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':idcontato', $this->__get('idcontato'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

}

?>