<!--Coded by Ryan Sands - z1918476-->
<?php
    //executes given $sql statement with $varArray, returns true for success
    function execute($pdo, $sql, $varArray)
    {
        try 
        {
            $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare($sql);
            $stmt->execute($varArray);
            return $stmt;
        }
        catch(PDOexception $e) {
            echo "Connection failed: " . $e->getMessage();
            return false;
        }
    }

    //executes given $sql statement with $varArray, returns the result row
    function fetch($pdo, $sql, $varArray)
    {
        try
        {
            $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

            $sql = $pdo->prepare($sql);
            $sql->execute($varArray);
            $result = $sql->fetch(PDO::FETCH_ASSOC);
            return $result;
        }
        catch(PDOexception $e) {
            echo "Connection failed: " . $e->getMessage();
            return;
        }
    }

    //executes given $sql statement with $varArray, returns all matching rows
    function fetchAll($pdo, $sql, $varArray)
    {
        try
        {
            $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

            $sql = $pdo->prepare($sql);
            $sql->execute($varArray);
            $rows = $sql->fetchAll();
            return $rows;
        }
        catch(PDOexception $e) {
            echo "Connection failed: " . $e->getMessage();
            return;
        }
    }

?>