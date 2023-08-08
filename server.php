<?php

class Vendegkonyv
{
    protected $db;
    public function __construct()
    {
        $this->db = new PDO("sqlite:vendegkonyv.db");
    }

    public function display($limit = 10, $offset = 0)
    {
        $stmt = $this->db->query("SELECT count(*)  from UZENETEK ");
        $count = $stmt->fetchAll();
        $stmt = $this->db->query(
            "SELECT * from UZENETEK LIMIT {$limit} OFFSET {$offset}"
        );
        $lista = ["counter" => $count[0][0], "page" => ceil($count[0][0] / 10)];
        while ($elem = $stmt->fetchObject()) {
            $lista[] = $elem;
        }

        return $lista;
    }

    public function insertData($name, $email, $message)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO UZENETEK(ID,name,email,message) VALUES(NULL,:name,:email,:message)"
        );
        $stmt->bindValue(":name", $name);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":message", $message);
        $stmt->execute();
        print json_encode(["id" => $this->db->lastInsertId()]);
    }
}

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
$vendegkonyv = new Vendegkonyv();

if (isset($_GET["display"])) {
    @$limit = $_GET["limit"] ?: 10;
    @$offset = $_GET["offset"] ?: 0;
    header("Content-Type: application/json; charset=utf-8");
    print json_encode($vendegkonyv->display($limit, $offset));
}

if (isset($_POST["insert_data"])) {
    $message = trim($_POST["message"]);
    $name = trim($_POST["name"]);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $vendegkonyv->insertData($name, $email, $message);
}

?>
