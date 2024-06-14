<?php
  require_once('Controllers\userControllers.php');
?>

  <div class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
  
  <div class="navbar-header">
       <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
           <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" runat="server" href="index.php?content_page=Home"><img class="img-responsive" src="images/apple-touch-icon — копия.png" width="80"></a>
  </div>
  
  <div class="navbar-collapse collapse">
  <ul class="nav navbar-nav">
  <li><a runat="server" href="index.php?content_page=Home">Головна сторінка</a></li>
  <li><a runat="server" href="index.php?content_page=Bags">Сумки</a></li>
  <li><a runat="server" href="index.php?content_page=Categories">Категорії</a></li>
  <li><a runat="server" href="index.php?content_page=Suppliers">Кошик</a></li>
  <li><a runat="server" href="index.php?content_page=About">Про Нас</a></li>
  </ul>
  <ul class="nav navbar-nav navbar-right">
    <?php
      if(!isset($_SESSION['username'])){
        echo '<li style="cursor:pointer"><a runat="server" data-toggle="modal" data-target="#loginModal" ><span class="glyphicon glyphicon-log-in"></span> Увійти</a></li>';
        echo '<li style="cursor:pointer"><a runat="server" data-toggle="modal" data-target="#registerModal" ><span class="glyphicon glyphicon-user"></span> Зареєструватися</a></li>';
      }
      else {
        echo '<li style="cursor:pointer"><a runat="server" href="index.php?content_page=logout"><span class="glyphicon glyphicon-log-out"></span> Вийти</a></li>';
      }
    ?>
  </ul>
  </div>
  </div>
  </div>

<div id="header">
<div id="logo" onClick="location.href='index.php?content_page=Introduction'">
</div>
</div>

<div id="left" class="col-md-2"><?php include('Menu.php');?></div>
<div id="right" class="col-md-10">
    <?php
    if (isset($page_content) && file_exists($page_content)) {
        include($page_content);
    } else {
        echo "Помилка: файл не знайдено або змінна не визначена.";
    }
    ?>
</div>
  
<?php
  require_once('Controllers\Shopping.php');
?>
  <div id="shoppingcart">
  <?php
    if (isset($_SESSION['username'])){
      if($_SESSION['username'] != 'Admin'){
        echo '<div class="panel panel-success">';
        echo '<div class="panel-heading"><span class="glyphicon glyphicon-shopping-cart"></span> Кошик</div>';
            echo '<div class="panel-body">';
                echo ShoppingСontrolers::writeShoppingCart();
            echo '</div></div>';
          }
      }
      else {
        echo '<div class="panel panel-success">';
        echo '<div class="panel-heading"><span class="glyphicon glyphicon-shopping-cart"></span> Кошик</div>';
            echo '<div class="panel-body">';
                echo ShoppingСontrolers::writeShoppingCart();
            echo '</div></div>';
      }
  ?>
  </div>

</div>


 <div style="position: fixed; bottom: 0px; left:0px;">
     
 <script type="text/javascript">
     current_time();
 </script>
 </div>
 <div style="position: fixed; bottom: 0px; right:0px;">
 &copy;2024 Volodar Bags Ltd.
 </div>


  <div class="modal fade" id="loginModal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" align="center">Увійти</h4>
        </div>
        <div class="modal-body">
          <div class="container">
            <?php
            echo UsersControllers::displayLoginForm();
            ?>
        </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Увійти</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Відхилити</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <
   <div class="modal fade" id="registerModal" role="dialog">
     <div class="modal-dialog modal-md">
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal">&times;</button>
           <h4 class="modal-title" text-align="center">Зареєструватися</h4>
         </div>
         <div class="modal-body">
           <div class="container">
             <?php
             echo UsersControllers::displayRegisterForm();
             ?>
         </div>
         </div>
         <div class="modal-footer">
           <button type="submit" class="btn btn-success">Зареєструватися</button>
           <button type="button" class="btn btn-danger" data-dismiss="modal">Відхилити</button>
           </form>
         </div>
       </div>
     </div>
   </div>
