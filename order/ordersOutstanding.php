<?php
    require_once("./util/creds.php");
    require_once("./util/sessionStart.php");

    $rs = $pdo->prepare("SELECT * FROM products WHERE prodID = ?;");
    $rs->execute(array($_GET["prodID"]));
    $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
?>
<html>
<body>
   

</body>
</html>