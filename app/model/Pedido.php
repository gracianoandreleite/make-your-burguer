<?php

namespace App\Model;

/**
 * Representa um Pedido no sistema.
 */
class Pedido {
    private int $id;
    private bool $status;
    public object $cliente;
    public object $burguer;

    /**
     * Obtém o ID do pedido.
     *
     * @return int O ID do pedido.
     */
    public function getId() : int {
        return $this->id; 
    }

    /**
     * Define o ID do pedido.
     *
     * @param int $id O novo ID do pedido.
     */
    public function setId(int $id) : void {
        $this->id = $id; 
    }

    /**
     * Obtém o status do pedido.
     *
     * @return bool O status do pedido.
     */
    public function getStatus() : bool {
        return $this->status; 
    }

    /**
     * Define o status do pedido.
     *
     * @param bool $status O novo status do pedido (true para realizado, false para pendente).
     */
    public function setStatus(bool $status) : void {
        $this->status = $status; 
    }
}

?>
