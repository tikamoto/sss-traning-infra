<?
try {
    $dbh = new PDO(
        "mysql:dbname=" . getenv("DB_NAME") . ";host=" . getenv("DB_HOST"),
        getenv("DB_USER"), 
        getenv("DB_PASSWORD")
    );
    echo "DB接続OK";
} catch (PDOException $e) {
    echo "DB接続NG: " . $e->getMessage();
}
