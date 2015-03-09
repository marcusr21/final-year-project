<?php
require_once('connect.php');
$formName=$_POST['name'];
$q=isset($_POST['query']) ? $_POST['query'] : null;
$tags=isset($_POST['tags']) ? $_POST['tags'] : null;
$cat=isset($_POST['category']) ? $_POST['category'] : null;

if($formName='advanced'){
  advancedSearch($q, $tags, $cat);
}
else{
    $array=array();
    $key=$_POST['keywords'];
    $sql="SELECT *, MATCH (make, model, description, tags) AGAINST ('*$key*' IN BOOLEAN MODE) as relevant LIMIT 5
    FROM assets
    WHERE MATCH (make, model, description, tags) AGAINST ('*$key*' IN BOOLEAN MODE)
    ORDER BY relevant DESC";
    $query=mysqli_query($conn, $sql);
      while($row=mysqli_fetch_array($query))
      {
        $array[] = array('id'=>$row['id'], 'make'=>$row['make'], 'model'=>$row['model']);
      }

    echo json_encode($array);
}

function advancedSearch($query, $tagParam, $category){
      $searchResults[]=array();
      $w = array();

      foreach($tagParam as $tag){
        $w[] = "tags.tag='$tag'";
      }
      $w[]="category='$category'";

      
      return $searchResults;
    }
?>
