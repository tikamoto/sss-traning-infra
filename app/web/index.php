<?php
class Status {
    public function __construct(
        public readonly string $name,
        public readonly string $value,
        public readonly Closure $assertFunc
    ){}
    public function assert(): bool {
        return call_user_func($this->assertFunc, $this->value);
    }
}
$statuses = [
    new Status(
        "Host",
        $_SERVER["HTTP_HOST"],
        fn($value) => !empty($value) ? true : false
    ),
    new Status(
        "PHP ver",
        phpversion(),
        fn($value) => preg_match("/^8\.1\./", $value) ? true : false
    ),
    new Status(
        "MySQL ver",
        (function(){
            try {
                $dbh = new PDO(
                    "mysql:dbname=" . getenv("DB_NAME") . ";host=" . getenv("DB_HOST"),
                    getenv("DB_USER"), 
                    getenv("DB_PASSWORD")
                );
                return $dbh->getAttribute(PDO::ATTR_SERVER_VERSION);
            } catch (PDOException $e) {
                return $e->getMessage();
        }})(),
        fn($value) => preg_match("/^8\.0\./", $value) ? true : false
    ),
    new Status(
        "Environments",
        (function(){
            $envs = array_keys(getenv());
            asort($envs);
            return implode(", ", $envs);
        })(),
        fn($value) => preg_match("/DB_HOST(.*)DB_NAME(.*)DB_PASSWORD(.*)DB_USER/", $value) ? true : false
    ),
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white">
<section class="flex justify-center p-10">
    <div>
        <h1 class="text-4xl font-bold mb-5 text-center text-black">Status</h1>
        <table style="width: 800px;">
        <?php foreach($statuses as $status):?>
            <tr>
                <th class="border border-black px-5 py-2 bg-gray-200"><?php echo $status->name ?></th>
                <td class="border border-black px-5 py-2 bg-white"><?php echo $status->value ?></td>
                <td class="border border-black px-5 py-2 <?php echo $status->assert() ? "bg-green-100": "bg-red-100" ?>"><?php echo $status->assert() ? 'OK' : 'NG';?></td>
            </tr>
        <?php endforeach;?>
        </table>
    </div>
</section>
</body>
</html>