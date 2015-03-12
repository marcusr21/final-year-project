<?php
session_start();
date_default_timezone_set('UTC');
include('connect.php');

$formName=isset($_REQUEST['name']) ? $_REQUEST['name'] : null;
$q=isset($_REQUEST['q']) ? $_REQUEST['q'] : null;
$tags=isset($_REQUEST['tags']) ? $_REQUEST['tags'] : null;
$cat=isset($_REQUEST['cat']) ? $_REQUEST['cat'] : null;
$start=isset($_POST['startDate']) ? $_POST['startDate'] : null;
$end=isset($_POST['endDate']) ? $_POST['endDate'] : null;
$returnUrl = $_POST['url'];

$startDate=date('Y-m-d', strtotime($start));
$endDate=date('Y-m-d', strtotime($end));

if($formName='advanced'){
      $searchResults[]=array();

      $w = array();

      var_dump($tags);
      var_dump($cat);

      foreach($tags as $tag){
        $w[] = "tags.tag='$tag'";
      }
      foreach($cat as $cats){
        $w[]="category.category='$cats'";
      }
      if($w){
        $where=implode(' OR ', $w);
      }

      $selectStart="SELECT * FROM loan INNER JOIN loantoasset
      ON loan.loanNumber=loantoasset.loanNumber
      WHERE (plannedStart BETWEEN '$startDate' AND '$endDate')
      OR (plannedEnd BETWEEN '$startDate' AND '$endDate')";
      if($startResult=mysqli_query($conn,$selectStart)){
        while($startRow=mysqli_fetch_array($startResult)){
          $unavailableStart[]=$startRow['barcode'];
        }
      }
      else {
        echo "Error: ".$conn->error;
      }
      $selectAsset = "SELECT assets.id
      FROM assets INNER JOIN category
      ON assets.category=category.id
      INNER JOIN assettotag ON assets.id=assettotag.assetid
      INNER JOIN tags ON assettotag.tagid=tags.tagid
      WHERE MATCH (make, model, description, tags) AGAINST ('*$q*' IN BOOLEAN MODE)
      AND $where";
      $i=0;
      if($selectResult=mysqli_query($conn, $selectAsset)){
        while($selectRow=mysqli_fetch_array($selectResult)){
          $barcode[]=$selectRow[0];
        }
        $result = array_unique($barcode);
        foreach($result as $newBarcode){
          if(count($unavailableStart) > 0){
            foreach($unavailableStart as $unavailable){
              $flag=false;
              if($unavailable==$newBarcode){
                $flag=true;
              }
              else{
                $foundBarcode[$i]=$newBarcode;
              }
              $i++;
            }
          }
          else{
            $foundBarcode[]=$newBarcode;
            var_dump($foundBarcode);
          }
        }
      }
      else {
        echo "Error: ".$conn->error;
      }
      foreach($foundBarcode as $key){
        $sql="SELECT assets.id, make, model, description
        FROM assets
        WHERE assets.id='$key'";
        $result=mysqli_query($conn, $sql);
        while($row=mysqli_fetch_array($result)){
          $searchResult[]=array('id'=>$row['id'], 'make'=>$row['make'], 'model'=>$row['model'], 'desc'=>$row['description']);
        }
      }
      $_SESSION['search'] = $searchResult;
      header('Location: '.$returnUrl);

}
?>
