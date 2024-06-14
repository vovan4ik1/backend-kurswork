<?php


require_once('Controllers\Shopping.php');


ShoppingСontrolers::processActions();
?>

<div id="shoppingcart">
  <div class="panel panel-success">
      <div class="panel-heading"><span class="glyphicon glyphicon-shopping-cart"></span> Ваш кошик для покупок</div>
      <div class="panel-body">
        <?php
          echo ShoppingСontrolers::showCart();
        ?></br>
        <h4><a runat="server" href="index.php?content_page=Bags"><span class="glyphicon glyphicon-triangle-left"></span> Назад до покупок</a></h4>
      </div>
  </div>
</div>
