<?php

$db = new SQLite3('vendegkonyv.db');

$sql = "INSERT INTO UZENETEK(ID,name,email,message) VALUES(NULL,:name,:email,:message)";

        $stmt = $db->prepare($sql);
        for($i=0;$i<300;$i++){

        	$stmt->bindValue(':name', "teszt elek-{$i}");
        	$stmt->bindValue(':email', "nospam@nospam.com-{$i}");
        	$stmt->bindValue(':message', "bejegyzés a vend2égkönyvben-{$i}");
        	$stmt->execute();

        }
        

?>