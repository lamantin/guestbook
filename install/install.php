<?php
@unlink('vendegkonyv.db');
$db = new SQLite3('vendegkonyv.db');

if(!$db){
    echo $db->lastErrorMsg();
}
else{
    echo "Adatbázis létrehozva!\n";
    $sql =<<<EOF
            CREATE TABLE UZENETEK
            (ID INTEGER PRIMARY KEY   AUTOINCREMENT,
            name        CHAR(200),
            email        CHAR(200),
            message           TEXT)
            EOF;
    $ret = $db->exec($sql);
    if(!$ret){
        echo $db->lastErrorMsg();
    } else {
        echo "Tábla sikeresen létrehozva\n";
    }
    $db->close();
}

?>