<?php

namespace App;

use App\Config\Connect;
use App\Model\Pedido;
use PDO;
use PDOException;

/**
 * Classe de serviço para gerenciar pedidos de hamburguer.
 *
 * Esta classe fornece métodos para validar e gerenciar pedidos, clientes e hamburgueres.
 */
class Service {
    
    /**
     * Valida um endereço de email.
     *
     * @param string $email O endereço de email a ser validado.
     * @return bool Retorna true se o email for válido, caso contrário, false.
     */
    public function validarEmail(string $email) : bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    
    /**
     * Verifica se um cliente existe no banco de dados com base no email.
     *
     * @param string $email O endereço de email do cliente.
     * @return bool Retorna true se o cliente existir, caso contrário, false.
     */
    public function verificarCliente(string $email) : bool {
        try{
            $sql = 'SELECT * FROM cliente WHERE email = ?';
            $stmt = Connect::getInstance()->prepare($sql);
            $stmt->execute([$email]);
            return $stmt->rowCount() == 1;
        } catch (PDOException $e) {
            echo "Erro ao verificar cliente. Detalhes do erro: " . $e->getMessage();
            return false; 
        }
    }

    /**
     * Obtém o ID de um cliente com base no email.
     *
     * @param string $email O endereço de email do cliente.
     * @return int Retorna o ID do cliente.
     */
    public function getIdCliente(string $email) : int {
        try{
            $sql = 'SELECT id_cliente FROM cliente WHERE email = ?';
            $stmt = Connect::getInstance()->prepare($sql);
            $stmt->execute([$email]); 
            return $stmt->fetch(PDO::FETCH_OBJ)->id_cliente; 
        } catch (PDOException $e) {
            echo "Erro ao verificar cliente. Detalhes do erro: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Insere um novo pedido no banco de dados.
     *
     * @param Pedido $pedido O pedido a ser inserido.
     */
    public function inserirPedido(Pedido $pedido) : void{
        try{
            if ($this->verificarCliente($pedido->cliente->getEmail())) {
                $sql = 'INSERT INTO burguer (tipo_pao, tipo_carne, preferencia) VALUES (?, ?, ?)';
                $stmt = Connect::getInstance()->prepare($sql);
                $stmt->execute([
                    $pedido->burguer->getTipoPao(), 
                    $pedido->burguer->getTipoCarne(), 
                    implode(",", $pedido->burguer->getPreferencia())
                ]);  

                $getIdBurguer = Connect::getInstance()->lastInsertId(); 
                
                $sql = 'INSERT INTO pedido (id_cliente, id_burguer) VALUES (?, ?)';
                $stmt = Connect::getInstance()->prepare($sql);
                $stmt->execute([$this->getIdCliente($pedido->cliente->getEmail()), $getIdBurguer]);
            } else {
                $sql = 'INSERT INTO cliente (email) VALUES (?)';
                $stmt = Connect::getInstance()->prepare($sql);
                $stmt->execute([$pedido->cliente->getEmail()]);
                
                $sql = 'INSERT INTO burguer (tipo_pao, tipo_carne, preferencia) VALUES (?, ?, ?)';
                $stmt = Connect::getInstance()->prepare($sql);
                $stmt->execute([
                    $pedido->burguer->getTipoPao(), 
                    $pedido->burguer->getTipoCarne(), 
                    implode(",", $pedido->burguer->getPreferencia())
                ]);        
                $getIdBurguer = Connect::getInstance()->lastInsertId(); 
                $sql = 'INSERT INTO pedido (id_cliente, id_burguer) VALUES (?, ?)';
                $stmt = Connect::getInstance()->prepare($sql);
                $stmt->execute([
                    $this->getIdCliente($pedido->cliente->getEmail()), 
                    $getIdBurguer
                ]);
            } 
        } catch (PDOException $e) { 
            echo "Erro ao inserir pedido. Detalhes do erro: " . $e->getMessage();
            exit;
        }
    }

    /**
     * Obtém todos os pedidos registrados.
     *
     * @return array Retorna um array de objetos representando os pedidos.
     */
    public function pedidosRegistrados() : array {
        try{
            $sql = '
                SELECT id_pedido, email, tipo_pao, tipo_carne, preferencia, status, data FROM pedido 
                INNER JOIN cliente on (pedido.id_cliente = cliente.id_cliente) 
                INNER JOIN burguer on (pedido.id_burguer = burguer.id_burguer) 
                ORDER BY pedido.data
            ';
            $stmt = Connect::getInstance()->query($sql);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) { 
            echo "Erro ao obter todos pedidos registrados. Detalhes do erro: " . $e->getMessage(); 
            exit;
        }
    }

    /**
     * Deleta um pedido do banco de dados.
     *
     * @param Pedido $pedido O pedido a ser deletado.
     */
    public function deletarPedido(Pedido $pedido) : void {
        try{
            $sql = 'SELECT id_burguer FROM pedido WHERE id_pedido = ?';
            $stmt = Connect::getInstance()->prepare($sql);
            $stmt->execute([$pedido->getId()]);
            $getIdBurguer = $stmt->fetch(PDO::FETCH_OBJ)->id_burguer;

            $sql = 'DELETE FROM pedido_realizado WHERE id_pedido = ?';
            $stmt = Connect::getInstance()->prepare($sql);
            $stmt->execute([$pedido->getId()]); 
            
            $sql = 'DELETE FROM pedido WHERE id_pedido = ?';
            $stmt = Connect::getInstance()->prepare($sql);
            $stmt->execute([$pedido->getId()]);

            $sql = 'DELETE FROM burguer WHERE id_burguer = ?';
            $stmt = Connect::getInstance()->prepare($sql);
            $stmt->execute([$getIdBurguer]);
        } catch (PDOException $e) { 
            echo "Erro ao deletar pedido: " . $e->getMessage(); 
            exit;
        }
    }

    /**
     * Obtém o número total de pedidos pendentes.
     *
     * @return int Retorna o número total de pedidos pendentes.
     */
    public function pedidoTotalPendente() : int {
        try{
            $sql = 'SELECT count(*) as total FROM pedido WHERE status = false';
            $stmt = Connect::getInstance()->query($sql); 
            return $stmt->fetch(PDO::FETCH_OBJ)->total;
        } catch (PDOException $e) { 
            echo "Erro ao obter número total de pedidos pendentes. Detalhes do erro: " . $e->getMessage(); 
            exit;
        }
    }

    /**
     * Verifica se o status de um pedido é diferente do status atual.
     *
     * @param Pedido $pedido O pedido a ser verificado.
     * @return bool Retorna true se o status for diferente, caso contrário, false.
     */
    public function verificarStatusPedido(Pedido $pedido) : bool {
        try{
            $sql = 'SELECT * FROM pedido WHERE id_pedido = ? && status != ?';
            $stmt = Connect::getInstance()->prepare($sql);
            $stmt->execute([$pedido->getId(), $pedido->getStatus()]);
            return $stmt->rowCount() == 1;
        } catch (PDOException $e) { 
            echo "Erro ao verificar status do pedido. Detalhes do erro: " . $e->getMessage(); 
            exit;
        }
    }

    /**
     * Atualiza o status de um pedido no banco de dados.
     *
     * @param Pedido $pedido O pedido a ser atualizado.
     */
    public function atualizarPedido(Pedido $pedido) : void {
        try{
            if ($this->verificarStatusPedido($pedido)) {
                $sql = 'UPDATE pedido SET status = ? WHERE id_pedido = ? && status != ?';
                $stmt = Connect::getInstance()->prepare($sql);
                $stmt->execute([$pedido->getStatus(), $pedido->getId(), $pedido->getStatus()]);
                if($pedido->getStatus() == 1){
                    $this->inserirRealizado($pedido);
                } else {
                    $this->deletarRealizado_auto($pedido);
                }
            }
        } catch (PDOException $e) { 
            echo "Erro ao atualizar pedido. Detalhes do erro: " . $e->getMessage(); 
            exit;
        }
    }

    /**
     * Obtém os dados de um pedido realizado.
     *
     * @param Pedido $pedido O pedido a ser obtido.
     * @return object Retorna um objeto com os dados do pedido realizado.
     */
    public function obterRealizado(Pedido $pedido) : object {
        try{
            $sql = '
                SELECT email, tipo_pao, tipo_carne, preferencia, data FROM pedido 
                INNER JOIN cliente on (pedido.id_cliente = cliente.id_cliente) 
                INNER JOIN burguer on (pedido.id_burguer = burguer.id_burguer) 
                WHERE pedido.status = 1 && pedido.id_pedido = ? ORDER BY pedido.data
            ';
            $stmt = Connect::getInstance()->prepare($sql);
            $stmt->execute([$pedido->getId()]); 
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) { 
            echo "Erro ao obter pedidos realizados. Detalhes do erro: " . $e->getMessage(); 
            exit;
        }
        
    }

    /**
     * Insere um pedido realizado no banco de dados.
     *
     * @param Pedido $pedido O pedido a ser inserido.
     */
    public function inserirRealizado(Pedido $pedido) : void {
        try{
            $realizado = $this->obterRealizado($pedido);
            $sql = 'INSERT INTO realizado (email, tipo_pao, tipo_carne, preferencia, data_feito) VALUES (?, ?, ?, ?, ?)';
            $stmt = Connect::getInstance()->prepare($sql);
            $stmt->execute([
                $realizado->email,
                $realizado->tipo_pao,
                $realizado->tipo_carne,
                $realizado->preferencia,
                $realizado->data   
            ]);   
            $idRealizado = Connect::getInstance()->lastInsertId();
            $this->inserirPedidoRealizado($pedido, $idRealizado);
        } catch (PDOException $e) { 
            echo "Erro ao inserir pedido realizado. Detalhes do erro: " . $e->getMessage(); 
            exit;
        }
    }

    /**
     * Insere a relação entre pedido e realizado no banco de dados.
     *
     * @param Pedido $pedido O pedido a ser inserido.
     * @param int $idRealizado O ID da tabela realizado.
     */
    public function inserirPedidoRealizado(Pedido $pedido, int $idRealizado) : void {
        try{
            $sql = 'INSERT INTO pedido_realizado (id_pedido, id_realizado) VALUES (?, ?)';
            $stmt = Connect::getInstance()->prepare($sql);
            $stmt->execute([$pedido->getId(), $idRealizado]); 
        } catch (PDOException $e) { 
            echo "Erro ao atualizar pedido. Detalhes do erro: " . $e->getMessage(); 
            exit;
        }
    }

    /**
     * Deleta automaticamente um pedido realizado quando o status do pedido volta a ser em reprodução.
     *
     * @param Pedido $pedido O pedido a ser deletado.
     */
    public function deletarRealizado_auto(Pedido $pedido) : void {
        try{
            $sql = 'SELECT id_realizado FROM pedido_realizado WHERE id_pedido = ?';
            $stmt = Connect::getInstance()->prepare($sql);
            $stmt->execute([$pedido->getId()]);
            
            $idRealizado = $stmt->fetch(PDO::FETCH_OBJ)->id_realizado;
            $sql = 'DELETE FROM pedido_realizado WHERE id_pedido = ?';
            $stmt = Connect::getInstance()->prepare($sql);
            $stmt->execute([$pedido->getId()]); 

            $sql = 'DELETE FROM realizado WHERE id_realizado = ?';
            $stmt = Connect::getInstance()->prepare($sql);
            $stmt->execute([$idRealizado]);
        } catch (PDOException $e) { 
            echo "Erro ao deletar automaticamente o pedido . Detalhes do erro: " . $e->getMessage(); 
            exit;
        }
    }

    /**
     * Deleta um pedido realizado do banco de dados.
     *
     * @param Pedido $pedido O pedido a ser deletado.
     */
    public function deletarRealizado(Pedido $pedido) : void {
        try{
            $sql = 'DELETE FROM pedido_realizado WHERE id_realizado = ?';
            $stmt = Connect::getInstance()->prepare($sql);
            $stmt->execute([$pedido->getId()]); 

            $sql = 'DELETE FROM realizado WHERE id_realizado = ?';
            $stmt = Connect::getInstance()->prepare($sql);
            $stmt->execute([$pedido->getId()]);
        } catch (PDOException $e) { 
            echo "Erro ao deletar o pedido realizado. Detalhes do erro: " . $e->getMessage(); 
            exit;
        }
    }

    /**
     * Deleta todos os pedidos realizados do banco de dados.
     */
    public function deletarTudoRealizado() : void {
        try{
            $sql = 'DELETE FROM pedido_realizado';
            $stmt = Connect::getInstance()->query($sql);

            $sql = 'DELETE FROM realizado';
            $stmt = Connect::getInstance()->query($sql);
        } catch (PDOException $e) { 
            echo "Erro ao deletar todos pedidos realizados. Detalhes do erro: " . $e->getMessage(); 
            exit;
        }
    }

    /**
     * Obtém todos os pedidos realizados.
     *
     * @return array Retorna um array de objetos representando os pedidos realizados.
     */
    public function pedidoRealizado() : array {
        try{
            $sql = 'SELECT * FROM realizado';
            $stmt = Connect::getInstance()->query($sql);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) { 
            echo "Erro ao retornar pedidos realizados. Detalhes do erro: " . $e->getMessage(); 
            exit;
        }
    }
}
?>
