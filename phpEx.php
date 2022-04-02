<?php
//this is just an example of creds usage incase people aren't familiar
//just saves you from needing to constantly repeat user/pass everywhere
    include("creds.php");

    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        //query
        $result = $pdo->query("SELECT * FROM ___;");
        $rows = $result->fetchALL(PDO::FETCH_ASSOC);

        //do something with $rows
    }
    catch(PDOexception $e) {
		echo "Connection failed: " . $e->getMessage();
	}

?>