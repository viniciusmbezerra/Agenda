<?php

namespace App\Models;

use MF\Model\Model;

class Tema extends Model {
    private $idtema;
    private $cor_fundo;
    private $cor_texto;
    private $cor_barra_nav;
    private $fk_idusuario;

    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
    }

    public function salvar() {
        $query = "
                insert into 
                    tema(cor_fundo, cor_texto, cor_barra_nav, fk_idusuario) 
                values(:cor_fundo, :cor_texto, :cor_barra_nav, :fk_idusuario)
                ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cor_fundo', $this->__get('cor_fundo'));
        $stmt->bindValue(':cor_texto', $this->__get('cor_texto'));
        $stmt->bindValue(':cor_barra_nav', $this->__get('cor_barra_nav'));
        $stmt->bindValue(':fk_idusuario', $this->__get('fk_idusuario'));
        $stmt->execute();

        return $this;
    }

    public function atualizar() {
        $query = "
                update 
                    tema 
                set 
                    cor_fundo = :cor_fundo,
                    cor_texto = :cor_texto,
                    cor_barra_nav = :cor_barra_nav
                where 
                    fk_idusuario = :fk_idusuario
                ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cor_fundo', $this->__get('cor_fundo'));
        $stmt->bindValue(':cor_texto', $this->__get('cor_texto'));
        $stmt->bindValue(':cor_barra_nav', $this->__get('cor_barra_nav'));
        $stmt->bindValue(':fk_idusuario', $_SESSION['idusuario']);
        $stmt->execute();
    }

    public function getTemaPorCor_fundo() {
        $query = "
                select 
                    * 
                from 
                    tema 
                where 
                    cor_fundo = :cor_fundo and 
                    fk_idusuario = :fk_idusuario
                ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cor_fundo', $this->__get('cor_fundo'));
        $stmt->bindValue(':fk_idusuario', $_SESSION['idusuario']);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAll() {
        $query = "
            select 
                *
            from 
                tema as c
            where 
                c.fk_idusuario = :idusuario";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':idusuario', $_SESSION['idusuario']);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getInfoTema() {
        $query = "select * from tema where fk_idusuario = :fk_idusuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':fk_idusuario', $this->__get('fk_idusuario'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

}

?>