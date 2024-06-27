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
        <title>Make your burguer</title>
    </head>
    <body>
        <?php 
            // Inicializa variáveis de mensagem de sessão.
            $info_success = $_SESSION['info_success'] ?? false;
            $info_error = $_SESSION['info_error'] ?? false;
            unset($_SESSION['info_success']);
            unset($_SESSION['info_error']);
        ?>
        <?php require_once INCLUDES_PATH . 'navbar.php' ?>
        <div class="row">
            <div class="col s12 m9 push-m1">
                <br>
                <form action="#" method="POST">
                    <div class="input-field col1 s12">
                        <i class="tiny material-icons prefix">email</i>
                        <input id="icon_prefix" name="email" type="text" class="validate" required>
                        <label for="icon_prefix">Insere o seu email</label>
                    </div>
                    <div>
                        <label>Escolha o seu pão</label>
                        <select class="browser-default" name="tipo_pao">
                            <option value="" disabled selected>Que tipo de pão?</option>
                            <option value="Italiano Branco">Italiano Branco</option>
                            <option value="3 Queijos">3 Queijos</option>
                            <option value="Parmessão e Orégano">Parmessão e Orégano</option>
                            <option value="Integral">Integral</option>
                        </select>
                    </div>
                    <br>
                    <div>
                        <label>Escolha a carne do seu Burguer: </label>
                        <select class="browser-default" name="tipo_carne">
                            <option value="" disabled selected>Que tipo de carne?</option>
                            <option value="Maminha">Maminha</option>
                            <option value="Alcatra">Alcatra</option>
                            <option value="Picanha">Picanha</option>
                            <option value="Veggie Burguer">Veggie Burguer</option>
                        </select>
                    </div>
                    <br>
                    <div>
                        <label for="group">Selecione a tua perferência: </label>
                        <p>      
                            <label>
                                <input type="checkbox" name="preferencia[]" value="Bacon" class="filled-in" checked="checked" />
                                <span>Bacon</span>
                            </label>
                        </p>
                        <p>      
                            <label>
                                <input type="checkbox" name="preferencia[]"  value="Salame" class="filled-in" checked="checked" />
                                <span>Salame</span>
                            </label>
                        </p>
                        <p>      
                            <label>
                                <input type="checkbox" name="preferencia[]" value="Cebola Roxa" class="filled-in" checked="checked" />
                                <span>Cebola Roxa</span>
                            </label>
                        </p>
                        <p>      
                            <label>
                                <input type="checkbox" name="preferencia[]" value="Cheddar" class="filled-in" checked="checked" />
                                <span>Cheddar</span>
                            </label>
                        </p>
                        <p>      
                            <label>
                                <input type="checkbox" name="preferencia[]" value="Tomate" class="filled-in" checked="checked" />
                                <span>Tomate</span>
                            </label>
                        </p>
                        <p>      
                            <label>
                                <input type="checkbox" name="preferencia[]" value="Pepino" class="filled-in" checked="checked" />
                                <span>Pepino</span>
                            </label>
                        </p>
                    </div>
                    <button type="submit" name="btn_make_now" value="btn_make_now" class="btn waves-effect waves-light #e65100 orange darken-4">Make your burguer now</button>
                </form>
            </div>
        </div> 
          
                    
    <!-- Modal de sucesso -->
    <div id="modal1" class="modal">
    <div class="modal-content">
        <h4>Sucesso!</h4>
        <p>Por favor aguarde enquanto o seu pedido está sendo realizado.</p>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Ok</a>
    </div>
    </div>
    <!-- Modal de erro -->
    <div id="modal2" class="modal">
    <div class="modal-content">
        <h4>Ups!</h4>
        <p>O seu pedido não pode ser realizado.</p>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Tentar novamente</a>
    </div>
    </div>

</body>
<!-- Materialize framework JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

<script>
    // Inicialização dos modais
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.modal');
        var instances = M.Modal.init(elems);
        
        // Exibe o modal de sucesso, se houver mensagem de sucesso na sessão
        <?php if ($info_success){ ?>
        var modalSuccess = document.getElementById('modal1');
        var instanceSuccess = M.Modal.getInstance(modalSuccess);
        instanceSuccess.open();
        
        // Exibe o modal de erro, se houver mensagem de erro na sessão
        <?php } else if ($info_error){ ?>
        var modalError = document.getElementById('modal2');
        var instanceError = M.Modal.getInstance(modalError);
        instanceError.open();
        <?php } ?>
    });
    
    // Inicialização do sidenav (menu lateral)
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.sidenav');
        var instances = M.Sidenav.init(elems);
    });
</script>

</html>