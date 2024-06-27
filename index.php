<?php

require_once __DIR__ . '/vendor/autoload.php';

// Define o caminho para os arquivos de inclusão
define('INCLUDES_PATH', __DIR__ . '/public/includes/');

include "app/controller.php";

// Define a página a ser carregada com base no parâmetro 'page' da URL
$page = $_GET['page'] ?? 'fazer_pedido';
$pagePath = "public/{$page}.php";

// Verifica se o arquivo da página existe e inclui, caso contrário, redireciona para a página 404
match (true) {
    file_exists($pagePath) => require_once $pagePath,
    default => header("Location: public/404.php") && exit(),
}; 