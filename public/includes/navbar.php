<nav>
    <div class="nav-wrapper #f57f17 #ff8f00 amber darken-3">
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul class="hide-on-med-and-down">
            <li class="s12 m4 l4"><a href="fazer_pedido">Fazer pedido</a></li>
            <li class="s12 m4 l4"><a href="gerenciar_pedidos">Gerenciar pedidos <span class="new badge #e65100 orange darken-4"><?= $service->pedidoTotalPendente() ?></span></a></li>
            <li class="s12 m4 l4"><a href="pedidos_realizados">Pedidos realizados</a></li>
        </ul>
    </div>
</nav>

<!-- Menu lateral para dispositivos móveis -->
<ul class="sidenav" id="mobile-demo">
    <li class="s12 m4 l4"><a href="fazer_pedido">Fazer pedido</a></li>
    <li class="s12 m4 l4"><a href="gerenciar_pedidos">Gerenciar pedidos <span class="new badge #e65100 orange darken-4"><?= $service->pedidoTotalPendente() ?></span></a></li>
    <li class="s12 m4 l4"><a href="pedidos_realizados">Pedidos realizados</a></li>
</ul>

