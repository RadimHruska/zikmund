<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: admin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" type="text/css" />
    <title>Lukša admin</title>
</head>
<style>
    body{height: 100vh;}
    </style>

<body>
    <?php include("navAdmin.php"); ?>
<div id="obalovaci">


    <h1>Vložení aktuality:</h1>
    <h7>pro enter vložte na konec řádku &lt;br&gt;</h7> <br>
    <form method="POST" action="adminMenu.php">
        <h3>Nadpis</h3>
        <input type="text" name="headerInsert" style="width: 900px"><br>
        <h3>Text</h3> 
        <textarea name="textInsert" style="width: 900px; height: 300px; "></textarea><br>

        <input type="submit" value="Ulož data" style="margin-top: 20px; margin-bottom: 30px;">
    </form>
    <?php
    require_once("Db.php");
    Db::connect("uvdb33.active24.cz","interdialu","interdialu","septimaA79");

    if(isset($_POST['headerInsert']))
    {
        $vlozeni=Db::query("INSERT INTO posts (id, header, postText) 
                            VALUES (NULL, ?, ?);",
                            $_POST['headerInsert'],
                            $_POST['textInsert']);
        if($vlozeni>0)
            echo "<p>Záznam vložen</p>";
        else
            echo "<p>Vložení se nezdařilo</p>";
    }

    if(isset($_GET['idSmaz']))
    {
        $id=$_GET['idSmaz'];
        echo "Opravdu chcete smazat záznam $id?";
        echo "<form method='POST' action='adminMenu.php'>";
        echo "<input type='submit' value='ano'>";
        echo "<a href='adminMenu.php'><input type='button' value='ne'></a>";
        echo "<input type='hidden' name='idSmaz' value='$id'>";
        echo "</form>";
    }

    if(isset($_POST['idSmaz']))
    {
        $mazani=Db::query("DELETE FROM posts WHERE id=?",$_POST['idSmaz']);
        if($mazani==1)
            echo "<p>Smazali jste záznam ".$_POST['idSmaz']."</p>";
        else
            echo "<p>Smazáno nebylo nic!!!</p>";
    }

    if(isset($_POST['idEdit']))
    {
        $editace=Db::query("UPDATE posts 
                SET header = ?, postText = ?
                WHERE id = ?;",
                $_POST['headerEdit'],
                $_POST['postTextEdit'],

                $_POST['idEdit']);
        if($editace==1)
            echo "<p>Změnili jste záznam ".$_POST['idEdit']."</p>";
        else
            echo "<p>Editováno nebylo nic!!!</p>";
    }

    $posts=Db::queryAll("SELECT * FROM posts;");
    ?>
    <h1>Aktuality:</h1>
<table width="900">
    <tr>
        <th>Číslo aktuality</th>
        <th>Nadpis aktuality</th>
        <th>Text aktuality</th>
        <th>Mazání</th>
        <th>Editace</th>
    </tr>
    <?php
    foreach($posts as $post)
    {
        $id=$post['id'];
        echo "<tr>";
        echo "<td>$id</td>";
        echo "<td>".$post['header']."</td>";
        echo "<td>".$post['postText']."</td>";
        echo "<td><a href='adminMenu.php?idSmaz=$id'>Smazat aktualitu</a></td>";
        echo "<td><a href='adminMenu.php?idEdit=$id'>Editovat aktualitu</a></td>";
        echo "</tr>";
    }
    ?>
</table>
    <?php
    if(isset($_GET['idEdit']))
    {
        $id=$_GET['idEdit'];
        $editace=Db::queryOne("SELECT * FROM posts WHERE id=?",$id);
        if(isset($editace['id']))
        {
    ?>
        <h3>Editace</h3>
        <form method="POST" action="adminMenu.php">
            <input type="hidden" name="idEdit" value="<?=$editace['id']?>">
            nadpis<br>
            <input type="text" name="headerEdit" value="<?=$editace['header']?>"><br>
            text<br>
            <textarea style="width: 900px; height: 300px; " type="text" name="postTextEdit"><?=$editace['postText']?></textarea><br>
            <input type="submit" value="Edituj data">
        </form>
    <?php
        }
        else
        {
            echo "<p>Záznam $id neexistuje!!!</p>";
        }
    }
    ?> 
    </div>  
</body>
</html>