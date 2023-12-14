<?php
    session_start();

    $conn = new PDO("mysql:host=127.0.0.1;dbname=teforum;charset=UTF8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $kategori=1;
    if(isset($_GET["kategori"]) && $_GET["kategori"] != "")
    $kategori= $_GET["kategori"];
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mat</title>
    <link rel="stylesheet" href="main.css">
<?php
    switch ($kategori){
        case 2:
            echo "\t <link rel=\"stylesheet\" href=\"it.css\"> \n ";
            break;
        case 3:
    
            echo "\t <link rel=\"stylesheet\" href=\"prod.css\"> \n ";
            break;
        case 4:
            echo "\t <link rel=\"stylesheet\" href=\"samhäll.css\"> \n ";
            break;
    }

?>
</head>
<body>
    <p>fjhbgnjuiyhgbn</p>
    <header>
         <h1>TE forum</h1>
        <div class="logg">
<?php
            if(isset($_SESSION["användarnamn"]))
            {
                
?>
            <a class="loggin"  href="dologout.php">Logga ut</a>
            <span><?php echo $_SESSION["användarnamn"]; ?> </span>
          
<?php
            }
            else{
?>
             <a class="loggin"  href="loggin.php">Logga in</a>
            <a class="loggin"  href="register.php">Bli medlem</a>
<?php
            }

?>
        

        </div>
    </header>
    <nav>
        <?php
        $sql = "select id, namn from kategorier order by id";

        $stmt=$conn->prepare($sql);
        $stmt->execute();

        $row = $stmt->fetch();
        while($row != null)
        {
            $id = $row["id"];
            $namn = $row["namn"];

            echo "<a href=\"index.php?kategori=$id\">$namn</a>\n";
            $row = $stmt->fetch();

        }


        ?>
       
    </nav>
    <main>
     <?php
     $sql = "select * from inlägg where kategori_id = :kategori_id order by datum desc";

     $params = array('kategori_id'=> $kategori);
     $stmt=$conn->prepare($sql);
     $stmt->execute($params);

     $row = $stmt->fetch();
     while($row != null)
     {
         $id = $row["id"];
         $titel = $row["titel"];
         $innehåll = $row["innehåll"];
         $datum = $row["datum"];
         $användarnamn = $row["användarnamn"];
        
         echo "<div class=\"inlägg\">\n";
         echo "<h2>$titel</h2>\n";
         echo "<p>".nl2br($innehåll)."</p>\n";
         echo "<p class=\"signatur\">$datum $användarnamn </p>\n";

        if(isset($_SESSION["användarnamn"]) && $användarnamn==$_SESSION["användarnamn"])
        {
            echo "<p class=\"tabort\"><a href=\"dodelete.php?id=$id&kategori=$kategori\"> Ta bort</a></p>\n";
        }

         echo "</div>\n";
         $row = $stmt->fetch();

     }

     ?>
    </main>
    
</body>
</html>
