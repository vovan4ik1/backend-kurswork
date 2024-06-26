<?php

require_once('connectData\libcon.php');

class ShoppingСontrolers {

  public static function writeShoppingCart() {
  	if (isset($_SESSION['cart']))
    	{
    	   $cart = $_SESSION['cart'];
    	}

  	if (!isset($cart) || $cart=='') {
  		return '<h4>У вашому кошику немає товарів.<a href="index.php?content_page=bags"> Здійснити покупку зараз</a></h4>';
  	}
    else {
  		
  		$items = explode(',',$cart);
  		$s = (count($items) > 1) ? 's':'';
  		return '<h4>Ви маєте <a href="index.php?content_page=cart&action=display">'.count($items).' item'.$s.' у вашому кошику</a></h4>';
  	}
  }


  public static function showCart() {
  	global $db;
  	$cart = $_SESSION['cart'];
  	if ($cart) {
  		$items = explode(',',$cart);
  		$contents = array();
  		$total = 0;
  		foreach ($items as $item) {
  			$contents[$item] = (isset($contents[$item])) ? $contents[$item] + 1 : 1;
  		}
  		$output[] = '<form action="index.php?content_page=cart&action=update" method="post" id="cart">';
  		$output[] = '<table class="table">';
  		foreach ($contents as $id=>$qty) {
  			$sql = 'SELECT * FROM bags WHERE bag_id = '.$id;
  			$result = $db->query($sql);
  			$row = $result->fetch();
  			extract($row);
  			$output[] = '<tr>';
        $output[] = '<td><img class="img-responsive" src='.$bag_image_link.' width="60" height="auto"></td>';
        $output[] = '<td>'.$bag_name.'</td>';
        $output[] = '<td>'.$bag_description.'</td>';
  			$output[] = '<td>₴: '.$bag_price.'</td>';
        $output[] = '<td><input type="number" name="qty'.$id.'" value="'.$qty.'" size="3" maxlength="3" style="border:gray; border-radius:15px; width:100px; height:25px"/></td>';
  			$output[] = '<td>₴: '.($bag_price * $qty).'</td>';
  			$output[] = '<td><a style="color:red" href="index.php?content_page=cart&action=delete&id='.$id.'" class="r">Видалити</a></td>';

  			$total += $bag_price * $qty;
        $gst = ($total/100) * 15;
        $total = number_format($total, 2);
        $gst = number_format($gst, 2);

  			$output[] = '</tr>';
  		}
  		$output[] = '</table>';
  		$output[] = '<h4>Загальна сума: <strong>₴: '.$total.'</strong></h4>';
      $output[] = '<div class="row">';
  		$output[] = '<div class="col-sm-4"><button type="submit" class="btn btn-primary">Оновити кошик</button></div>';
      $output[] = '<div class="col-sm-4"></div>';
      $output[] = '<div class="col-sm-4"><a href="index.php?content_page=cart&action=clearall" class="btn btn-warning"><span class="glyphicon glyphicon-remove"></span> Очистити кошик</a></div>';
      $output[] = '</div>';
  		$output[] = '</form></br></br>';
      $output[] = '<h4><a runat="server" href="index.php?content_page=purchased" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-triangle-right"></span> Зробити замовлення</a></h4>';
  	}
    else {
  		$output[] = '<h4>Ваш кошик порожній.</h4>';
  	}
  	return join('',$output);
  }


  public static function processActions() {
  	if (isset($_SESSION['cart']))
  	{
      $cart = $_SESSION['cart'];
  	}

  	if (isset($_GET['action']))
  	{
  		$action = $_GET['action'];
  	}

      switch ($action) {
      	case 'add':
          		if (isset($cart) && $cart!='') {
          			$cart .= ','.$_GET['id'];
          		} else {
          			$cart = $_GET['id'];
          		}
      		break;
        case 'clearall':
              if (!empty($cart)) {
                $cart = NULL;
                $_SESSION['cart'] = NULL;
              }
        	break;
      	case 'delete':
          		if ($cart) {
          			$items = explode(',',$cart);
          			$newcart = '';
          			foreach ($items as $item) {
          				if ($_GET['id'] != $item) {
          					if ($newcart != '') {
          						$newcart .= ','.$item;
          					} else {
          						$newcart = $item;
          					}
          				}
          			}
          			$cart = $newcart;
          		}
      		break;
      	case 'update':
          	if ($cart) {
          		$newcart = '';
          		foreach ($_POST as $key=>$value) {
          			if (stristr($key,'qty')) {
          				$id = str_replace('qty','',$key);
          				$items = ($newcart != '') ? explode(',',$newcart) : explode(',',$cart);
          				$newcart = '';
          				foreach ($items as $item) {
          					if ($id != $item) {
          						if ($newcart != '') {
          							$newcart .= ','.$item;
          						} else {
          							$newcart = $item;
          						}
          					}
          				}
          				for ($i=1;$i<=$value;$i++) {
          					if ($newcart != '') {
          						$newcart .= ','.$id;
          					}
                    else {
          						$newcart = $id;
          					}
          				}
          			}
          		}
        	  }
            $cart = $newcart;
    	  break;
    }
    $_SESSION['cart'] = $cart;
  }

}
?>
