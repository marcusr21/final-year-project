<?
session_start();
require_once('connect.php');

if(isset($_POST["type"]) && $_POST["type"] == "add"){
  $barcode=$_POST["barcode"];
  $return_url=$_POST["url"];

  $query = "SELECT make, model FROM assets where barcode = '$barcode' LIMIT 1";
  if($result=mysqli_query($conn, $query)) {
    while($row=mysqli_fetch_array($result))
    {
      $new_item=array(array('barcode'=>$barcode, 'make'=>$row[0], 'model'=>$row[1]));
    }

    if(isset($_SESSION['products'])){
      $found=false;

      foreach($_SESSION['products'] as $bask_item){
        if($bask_item["barcode"]==$barcode){
          $item[]=array('barcode'=>$bask_item['barcode'], 'make'=>$bask_item['make'], 'model'=>$bask_item['model'], 'message'=>'you have already added this item!');
          $found=true;
        }
        else {
          $item[]=array('barcode'=>$bask_item['barcode'], 'make'=>$bask_item['make'], 'model'=>$bask_item['model']);
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
    }
  }
  header('Location: '.$return_url);
}

?>
