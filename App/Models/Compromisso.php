<?php

namespace App\Models;

use MF\Model\Model;

class Compromisso extends Model {
    private $idcompromisso;
    private $descricao;
    private $data_compromisso;

    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
    }

    public function salvar() {
        $query = "
                insert into 
                    compromisso(descricao, data_compromisso, fk_idusuario) 
                values(:descricao, :data_compromisso, :fk_idusuario)
                ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':descricao', $this->__get('descricao'));
        $stmt->bindValue(':data_compromisso', $this->__get('data_compromisso'));
        $stmt->bindValue(':fk_idusuario', $_SESSION['idusuario']);
        $stmt->execute();

        return $this;
    }

    public function atualizar() {
        $query = "
                update 
                    compromisso 
                set 
                    descricao = :descricao,
                    data_compromisso = :data_compromisso 
                where 
                    idcompromisso = :idcompromisso and 
                    fk_idusuario = :fk_idusuario
                ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':descricao', $this->__get('descricao'));
        $stmt->bindValue(':data_compromisso', $this->__get('data_compromisso'));
        $stmt->bindValue(':idcompromisso', $this->__get('idcompromisso'));
        $stmt->bindValue(':fk_idusuario', $_SESSION['idusuario']);
        $stmt->execute();
    }

    public function deletar() {
        $query = "
                delete from 
                    compromisso 
                where 
                    idcompromisso = :idcompromisso and 
                    fk_idusuario = :fk_idusuario
                    ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':idcompromisso', $this->__get('idcompromisso'));
        $stmt->bindValue(':fk_idusuario', $_SESSION['idusuario']);
        $stmt->execute();
    }

    public function validarCadastro() {
        $valido = true;
        if(strlen($this->__get('descricao'))<3) {
            $valido = false;
        }

        return $valido;
    }

    public function getCompromissoPorDescricao() {
        $query = "
                select 
                    descricao 
                from 
                    compromisso 
                where 
                    descricao = :descricao and 
                    fk_idusuario = :fk_idusuario
                ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':descricao', $this->__get('descricao'));
        $stmt->bindValue(':fk_idusuario', $_SESSION['idusuario']);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAll() {
        $query = "
            select 
                *
            from 
                compromisso as c
            where 
                c.fk_idusuario = :idusuario";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':idusuario', $_SESSION['idusuario']);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getInfoCompromisso() {
        $query = "
                select * from compromisso where idcompromisso = :idcompromisso";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':idcompromisso', $this->__get('idcompromisso'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

}

?>