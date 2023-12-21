<?php     
require_once("Db.php");
Db::connect("localhost","luksa","root","root");?>
<!DOCTYPE html>
<html lang="cs-cz">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" type="text/css" />
    <meta name="viewport" content="width=device-width, viewport-fit=cover">
    <title>Úvod</title>
</head>
<body>
<?php include("nav.php"); ?>
    <div id="container">
        
<div id="obsah"> 
      
<?php  
$cout = 0;
$posts=Db::queryAll("SELECT * FROM posts;");

 foreach($posts as $post)
 {
  echo  "<article class='aktualita'>";
  echo  "<section>";
  echo  "<h2>".$post['header']."</h2>";
  echo  "<h2>".$post['postText']."</h2>";
  echo  "</section>";
  echo  "</article>";
  $count +=1;
}
if($count == 0)
{
    echo  "<article class='aktualita'>";
    echo  "<section>";
    echo  " <h2>Žádné aktuality.</h2>";
    echo  "</section>";
    echo  "</article>";
}
   ?> 


</div>

    </div>
    <?php include("footer.php"); ?>
</body>
</html>