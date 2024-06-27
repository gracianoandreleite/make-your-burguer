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
        <title>Pedidos realizados</title>
    </head>
    <body>
        <?php require_once INCLUDES_PATH . 'navbar.php' ?>
        <div class="row">
            <div class="col s12 m10 push-m1">
            <h3 class="light"> Pedidos realizados: </h3>
            <?php 
                // Verifica se não há pedidos realizados
                if(empty($service->pedidoRealizado())){
                    echo "<br><div'><p class='center-align flow-text #bdbdbd grey-text'> Nenhum pedido realizado! </p></div>";
                }else{
            ?>

            <table class="centered responsive-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Email:</th>
                        <th>Pão:</th>
                        <th>Carne:</th>
                        <th>Opcionais:</th>
                        <th>Tempo Enviado</th>
                        <th>Tempo Respondido</th>
                        <th>Acção:</th>
                    </tr>
                </thead>
			    <br>
                <tbody>
                    <?php
                        // Contador para número do pedido realizado
                        $num = 1;
                    ?>
                    <?php 
                        // Loop para exibir cada pedido realizado
                        foreach ($service->pedidoRealizado() as $pedido) { ?>
                    <tr>
                        <td><?= $num++ ?></td>
                        <td><?= $pedido->email ?></td>
                        <td><?= $pedido->tipo_pao ?></td>
                        <td><?= $pedido->tipo_carne ?></td>
                        <td><?= $pedido->preferencia ?></td>
                        <td><?= $pedido->data_feito ?></td>
                        <td><?= $pedido->data_resp ?></td>
                        <td>
                            <form action="#" method="post">
                                <input type="hidden" name="id" value="<?= $pedido->id_realizado ?>">
                                <button type="submit" name="btn_deletar_realizado" value="Deletar" class="btn-floating orange" onclick="M.toast({html: 'Pedido removido com sucesso!'})"><i class="material-icons">delete</i></button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
		    </table>
            <br>
            <form action="#" method="post">
            <a href="#!" data-target="modal1" class="btn-floating #e65100 orange darken-4 modal-trigger"><i class="material-icons">delete</i></a>        
            <i> Apagar Tudo </i>
            <!-- Formulário para apagar todos os pedidos realizados -->
            <div id="modal1" class="modal">
                <div class="modal-content">
                    <h4>Ups!</h4>
                    <p>Tens a certeza que desejas apagar tudo?</p>
                </div>
                <div class="modal-footer">
                    <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>                    
                    <button type="submit" name="btn_deletar_realizado_tudo" value="Deletar Tudo" class="btn modal-close  #e65100 orange">Sim, desejo apagar tudo</button>
                </div>
            </div>
            </form>
            
            <?php } ?>
        </div>
	</body>

    <!-- Materialize framework JavaScript -->
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