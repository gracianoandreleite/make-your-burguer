<?php

use App\Model\Pedido;
use App\Model\Cliente;
use App\Model\Burguer;
use App\Service; 

/**
 * Controller para gerenciar operações de pedidos de hamburguer.
 */

// Verifica se o botão "btn_make_now" foi clicado
if ($_POST['btn_make_now'] ?? false) {
    // Sanitiza e obtém os dados do formulário
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $tipo_pao = filter_input(INPUT_POST, "tipo_pao", FILTER_SANITIZE_SPECIAL_CHARS);
    $tipo_carne = filter_input(INPUT_POST, "tipo_carne", FILTER_SANITIZE_SPECIAL_CHARS);
    $preferencia = $_POST['preferencia'] ?? ['---']; 
    $condition = ($email ?? false) ? (($tipo_pao ?? false) ? (($tipo_carne ?? false) ? true : false ) : false) : false;

    // Verifica se todos os campos necessários foram preenchidos
    if (!$condition) {
        $_SESSION['info_error'] = true;
    } else {
        // Cria novos objetos de Pedido, Cliente e Burguer
        $pedido = new Pedido();
        $cliente = new Cliente();
        $burguer = new Burguer();
        $pedido->cliente = $cliente;
        $pedido->burguer = $burguer;

        // Define os valores dos objetos com base nos dados do formulário
        $pedido->cliente->setEmail($email);
        $pedido->burguer->setTipoPao($tipo_pao);
        $pedido->burguer->setTipoCarne($tipo_carne);
        $pedido->burguer->setPreferencia($preferencia);

        // Cria um novo objeto de Service e insere o pedido se o email for válido
        $service = new Service();
        if ($service->validarEmail($email)) {
            $service->inserirPedido($pedido);        
            $_SESSION['info_success'] = true; 
        } else {
            $_SESSION['info_error'] = true; 
        }
    }
}
// Verifica se o botão "Deletar" foi clicado
else if ($_POST['btn_deletar'] ?? false) {
    $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
    $pedido = new Pedido();
    $service = new Service();
    $pedido->setId($id);
    $service->deletarPedido($pedido);    
}
// Verifica se o botão "Atualizar" foi clicado
else if ($_POST['btn_atualizar'] ?? false) {
    $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
    $status = filter_input(INPUT_POST, "status", FILTER_SANITIZE_SPECIAL_CHARS);
    $pedido = new Pedido();
    $service = new Service();
    $pedido->setId($id);
    $pedido->setStatus($status);
    $service->atualizarPedido($pedido);    
}
// Verifica se o botão "Deletar Realizado" foi clicado
else if($_POST['btn_deletar_realizado'] ?? false){
    $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
    $pedido = new Pedido();
    $service = new Service();
    $pedido->setId($id);
    $service->deletarRealizado($pedido);    
} 
// Verifica se o botão "Deletar All Realizado" foi clicado
else if($_POST['btn_deletar_realizado_tudo'] ?? false){
    $service = new Service();
    $service->deletarTudoRealizado();    
}
?>
