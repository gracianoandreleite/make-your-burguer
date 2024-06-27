<?php

namespace App\Config;

use PDO;
use PDOException;

/**
 * Classe responsável por permitir uma conexão singleton com o banco de dados MySQL usando PDO.
 */
class Connect {
        
    private static $instance;

    /**
     * Obtém a instância da conexão com o banco de dados.
     *
     * @return PDO|null  null em caso de falha na conexão.
     */
    public static function getInstance(): ?PDO {
        // Verifica se a instância já está definida
        if (!isset(self::$instance)) {
            try {
                // Cria uma nova instância PDO se ainda não existir
                self::$instance = new PDO('mysql:host=localhost;dbname=Make_your_Burguer;charset=utf8', 'root', '', [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ]);
            } catch (PDOException $e) {
                echo "Falha na conexão com o banco de dados.";
                return null;
            }
        }
        
        return self::$instance;
    }
    
}

?>
