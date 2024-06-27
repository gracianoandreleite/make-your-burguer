<?php
    $service = new App\Service();
?>
<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Materialize framework CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <!-- Material Icons CSS de Google Fonts -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <title>Gerenciar pedidos</title>
    </head>
    <body>
        <?php require_once INCLUDES_PATH . 'navbar.php' ?>
        <div class="row">
            <div class="col s12 m10 push-m1">
            <h3 class="light"> Gerenciar pedidos: </h3>
            <?php 
                // Exibe mensagem caso não haja pedidos registrados
                if(empty($service->pedidosRegistrados())){
                    echo "<br><div'><p class='center-align flow-text #bdbdbd grey-text'> Nenhum pedido registrado! </p></div>";
                }else{
            ?>

            <table class="striped centered responsive-table">
                <thead>
                    <tr>
                        <th>#:</th>
                        <th>Cliente:</th>
                        <th>Pão:</th>
                        <th>Carne:</th>
                        <th>Opcionais:</th>
                        <th>Tempo enviado</th>
                        <th>Acções:</th>
                    </tr>
                </thead>
                <br>
                <tbody>
                    <?php 
                        // Contador para número do pedido registrado
                        $num = 1;
                        /**
                         * Exibe as preferências de um pedido
                         *
                         * @param string $v Contem as preferências separadas por vírgula
                         * @return void
                         */
                        function getPreferencia($v) : void {
                            $preferencia = explode(",", $v);
                            foreach($preferencia as $value) {
                                echo $value.'<br>';
                            }
                        }
                    ?>
                    <?php 
                        // Loop pelos pedidos registrados
                        foreach ($service->pedidosRegistrados() as $pedido) { ?>
                    <tr>
                        <td><?= $num++ ?></td>
                        <td><?= $pedido->email ?></td>
                        <td><?= $pedido->tipo_pao ?></td>
                        <td><?= $pedido->tipo_carne ?></td>
                        <td><?php getPreferencia($pedido->preferencia) ?></td>
                        <td><?= $pedido->data ?></td>
                        <td>
                            <!-- Formulário para atualização do status do pedido -->
                            <form action="#" method="post">
                                    <select class="browser-default" name="status">
                                        <?php if($pedido->status == false){ ?>
                                        <option value="0">Em Produção</option>
                                        <option value="1">Realizado</option>
                                        <?php }else{ ?>
                                        <option value="1">Realizado</option>
                                        <option value="0">Em Produção</option>
                                        <?php } ?>    
                                    </select>
                                <input type="hidden" name="id" value="<?= $pedido->id_pedido ?>">
                                <button type="submit" name="btn_atualizar" value="btn_cancelar" class="btn-floating orange" onclick="M.toast({html: 'Estado do pedido atualizado!'})"><i class="material-icons">update</i></button>
                            </form>
                        </td>
                        <td> 
                            <?php if($pedido->status == false){ ?>
                                <a href="#!" data-target="modal1" class="btn-floating orange modal-trigger"><i class="material-icons">delete</i></a>
                            <?php }else{ ?>
                            <form action="#" method="post">
                                <input type="hidden" name="id" value="<?= $pedido->id_pedido ?>">
                                <button type="submit" name="btn_deletar" value="btn_deletar" onclick="M.toast({html: 'Pedido removido com sucesso!'})" class="btn-floating orange modal-trigger"><i class="material-icons">delete</i></button>
                            </form>
                            <?php } ?>

                            <!-- Modal para confirmação de exclusão do pedido -->
                            <div id="modal1" class="modal">
                                <div class="modal-content">
                                    <h4 class="left-align">Ups!</h4>
                                    <p class="left-align">Este pedido ainda não foi realizado, tens a certeza que desejas remover?</p>
                                </div>
                                <div class="modal-footer">
                                    <form action="#" method="post">
                                        <input type="hidden" name="id" value="<?= $pedido->id_pedido ?>">
                                        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
                                        <button type="submit" name="btn_deletar" value="btn_cancelar" data-target="modal1" class="btn modal-close  #e65100 orange ">Sim, desejo remover</button>
                                    </form>
                                </div>
                            </div>

                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php } ?>
        </div>

	</body>
    <!-- Scripts do Materialize -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        // Inicialização dos modais
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.modal');
            var instances = M.Modal.init(elems);
        });

        // Inicialização do sidenav (menu lateral)
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.sidenav');
            var instances = M.Sidenav.init(elems);
        });
    </script>
</html>