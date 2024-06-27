<?php

namespace App\Model;

/**
 * Representa um Cliente no sistema.
 */
class Cliente {
    private int $id;
    private string $email;
    
    /**
     * Obtém o ID do cliente.
     *
     * @return int|string O ID do cliente.
     */
    public function getId() : int {
        return $this->id; 
    }

    /**
     * Define o ID do cliente.
     *
     * @param int $id O novo ID do cliente.
     */
    public function setId(int $id) : void {
        $this->id = $id; 
    }

    /**
     * Obtém o endereço de e-mail do cliente.
     *
     * @return string O endereço de e-mail do cliente.
     */
    public function getEmail() : string {
        return $this->email; 
    }

    /**
     * Define o endereço de e-mail do cliente.
     *
     * @param string $email O novo endereço de e-mail do cliente.
     */
    public function setEmail(string $email) : void {
        $this->email = $email; 
    }
}

?>
