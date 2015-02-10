<?
session_start();
require_once('connect.php');


if(isset($_GET['remove']) && $_GET['remove']=='all'){
  $return_url=$_GET['returnurl'];
  unset($_SESSION['products']);
  header('Location: '.$return_url);
}

if(isset($_POST["type"]) && $_POST["type"] == "add"){
  $barcode=$_POST["barcode"];
  $return_url=$_POST["url"];
  $start=$_POST['start'];
  $end=$_POST['end'];

  $query = "SELECT make, model FROM assets where barcode = '$barcode' LIMIT 1";
  if($result=mysqli_query($conn, $query)) {
    while($row=mysqli_fetch_array($result))
    {
      $new_item=array(array('barcode'=>$barcode, 'make'=>$row[0], 'model'=>$row[1], 'start'=>$start, 'end'=>$end));
      //New array containing any information that is required
    }

    if(isset($_SESSION['products'])){
      $found=false;

      foreach($_SESSION['products'] as $bask_item){
        if($bask_item["barcode"]==$barcode){
          $item[]=array('barcode'=>$bask_item['barcode'], 'make'=>$bask_item['make'], 'model'=>$bask_item['model'], 'start'=>$bask_item['start'], 'end'=>$bask_item['end'], 'message'=>'you have already added this item!');
          $found=true;
          //If the item we are attempting to add exists, display error message to user
        }
        else { //Prepare the array for merging into the session
          $item[]=array('barcode'=>$bask_item['barcode'], 'make'=>$bask_item['make'], 'model'=>$bask_item['model'], 'start'=>$bask_item['start'], 'end'=>$bask_item['end']);
        }
      }
      if($found==false){
        foreach($item as $elementKey=> $element){
          foreach($element as $key => $value){
            if($key == 'message'){
              unset($array[$elementKey]);
              //removes the message when a new item is added
            }
          }
        }
        $_SESSION["products"]=array_merge($item,$new_item);
      }
      else{
        $_SESSION["products"] = $item;
      }
    }
    else{
      $_SESSION["products"]=$new_item;
      //If this is a new session or no items in basket, create the session
    }
  }
  header('Location: '.$return_url);
}

if(isset($_GET['remove']) && isset($_GET['returnurl']) && isset($_SESSION['products'])){
  $barcode=$_GET['remove'];
  $return_url=$_GET['returnurl'];

  foreach($_SESSION['products'] as $bask_item){
    if($bask_item['barcode']!=$barcode){
      $item[]=array('barcode'=>$bask_item['barcode'], 'make'=>$bask_item['make'], 'model'=>$bask_item['model']);
    }

    $_SESSION['products']=$item;
  }
  header('Location: '.$return_url);
}

?>
