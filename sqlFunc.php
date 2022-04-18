<?php
    //executes $sql with $varArray, returns true for success
    function insert($pdo, $sql, $varArray)
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

    //executes $sql with $varArray, returns the result row
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

    //executes $sql with $varArray, returns all matching rows
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