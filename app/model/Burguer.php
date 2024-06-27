<?php

namespace App\Model;

/**
 * Representa um Hambúrguer no sistema.
 */
class Burguer {
    private int $id;
    private string $tipoPao;
    private string $tipoCarne;
    private array $preferencia;
    
    /**
     * Obtém o ID do hambúrguer.
     *
     * @return int|string O ID do hambúrguer.
     */
    public function getId() : int {
        return $this->id; 
    }

    /**
     * Define o ID do hambúrguer.
     *
     * @param int $id O novo ID do hambúrguer.
     */
    public function setId(int $id) : void {
        $this->id = $id; 
    }

    /**
     * Obtém o tipo de pão do hambúrguer.
     *
     * @return string O tipo de pão do hambúrguer.
     */
    public function getTipoPao() : string {
        return $this->tipoPao; 
    }

    /**
     * Define o tipo de pão do hambúrguer.
     *
     * @param string $tipoPao O novo tipo de pão do hambúrguer.
     */
    public function setTipoPao(string $tipoPao) : void {
        $this->tipoPao = $tipoPao; 
    }

    /**
     * Obtém o tipo de carne do hambúrguer.
     *
     * @return string O tipo de carne do hambúrguer.
     */
    public function getTipoCarne() : string {
        return $this->tipoCarne; 
    }

    /**
     * Define o tipo de carne do hambúrguer.
     *
     * @param string $tipoCarne O novo tipo de carne do hambúrguer.
     */
    public function setTipoCarne(string $tipoCarne) : void {
        $this->tipoCarne = $tipoCarne; 
    }

    /**
     * Obtém as preferências adicionais do hambúrguer.
     *
     * @return array As preferências adicionais do hambúrguer.
     */
    public function getPreferencia() : array {
        return $this->preferencia; 
    }

    /**
     * Define as preferências adicionais do hambúrguer.
     *
     * @param array $preferencia As novas preferências adicionais do hambúrguer.
     */
    public function setPreferencia(array $preferencia) : void {
        $this->preferencia = $preferencia; 
    }
}

?>
