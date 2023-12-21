
<body>
    <h3>Aktuality</h3>
    <form method="POST" action="adminMenu.php">
        Nadpis<br>
        <input type="text" name="headerInsert" ><br>
        Text<br>
        <input type="text" name="textInsert"><br>

        <input type="submit" value="Ulož data">
    </form>
    <?php
    require_once("Db.php");
    Db::connect("localhost","luksa","root","root");

    if(isset($_POST['header']))
    {
        $vlozeni=Db::query("INSERT INTO znamky (id, header, postText) 
                            VALUES (NULL, ?, ?, ?);",
                            $_POST['header'],
                            $_POST['postText']);
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
<table width="900">
    <tr>
        <th>Id</th>
        <th>nadpis aktuality</th>
        <th>text aktuality</th>
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
        echo "<td><a href='adminMenu.php?idSmaz=$id'>Smaž $id</a></td>";
        echo "<td><a href='adminMenu.php?idEdit=$id'>Edituj $id</a></td>";
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
            <input type="text" name="jmenoEdit" value="<?=$editace['header']?>"><br>
            text<br>
            <input type="text" name="mEdit" value="<?=$editace['postText']?>"><br>
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
</body>
</html>
