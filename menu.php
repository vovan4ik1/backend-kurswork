<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style/menu.css">
  <title>Document</title>
</head>
<body>
  <p>
   <?php
    if(isset($_SESSION['username'])){
      echo '<div class="greeting" style="padding: 10px; background-color: white;">';
      echo '<h5>Вітаю, </h5>';
      echo '<h4>'.$_SESSION['username'].'</h4></div>';
    }
   ?>
    <div class="menu">
    <a runat="server" class="list-group-item" href="index.php?content_page=Bags">Магазин Сумок</a><br/>
    <a runat="server" class="list-group-item" href="index.php?content_page=categories">Категорії</a><br/>
    <a runat="server" class="list-group-item" href="index.php?content_page=Suppliers">Кошик</a><br/>
    <a runat="server" class="list-group-item" href="index.php?content_page=About">Про нас</a><br/>
    </div>
  </p>
</body>
</html>

