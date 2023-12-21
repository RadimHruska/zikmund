<nav>  
<ul>
<li>
<a href="adminMenu.php" <?php if ($thisPage=="Home") 
echo " id=\"currentpage\""; ?>>Domů</a>

<a href="reset-password.php" <?php if ($thisPage=="Resset") 
echo " id=\"currentpage\""; ?>>Změna hesla</a>
<a href="logout.php" <?php if ($thisPage=="Logout") 
echo " id=\"currentpage\""; ?>>Odhlásit</a></li>

</nav>