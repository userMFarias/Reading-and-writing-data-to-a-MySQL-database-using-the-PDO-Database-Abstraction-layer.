<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Web Programming using PHP - Coursework 2 - Task 2</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="css/styles.css?">
</head>
<body>
<header>   
    <h1>Web Programming using PHP - Coursework 2 - Task 2</h1>
    <h2>Reading and writing data to a MySQL database, using the PDO Database Abstraction layer</h2>
</header>
<main>
<?php
$host = 'mysqlsrv.dcs.bbk.ac.uk';
$db   = 'mplana01db';
$user = 'mplana01';
$pass = 'bbkmysql';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Create table
$sql = "CREATE TABLE IF NOT EXISTS Juices (
    juice_id INT NOT NULL AUTO_INCREMENT,
    juice_name VARCHAR(30) NOT NULL UNIQUE,
    juice_type ENUM('Fruit','Veg'),
    juice_price DECIMAL(4,2),
    juice_description TEXT,
    PRIMARY KEY (juice_id)
)";
$pdo->exec($sql);


$csvFile = 'data/juiceData.csv';
if (($handle = fopen($csvFile, 'r')) !== false) {
    while (($data = fgetcsv($handle)) !== false) {
        if (count($data) >= 4) {
            $name = trim($data[0]);
            $type = trim($data[1]);
            $price = floatval(trim($data[2]));
            // Join all remaining parts into the description (handles commas inside)
            $descParts = array_slice($data, 3);
            $desc = trim(implode(", ", $descParts));

			$stmt = $pdo->prepare("INSERT IGNORE INTO Juices (juice_name, juice_type, juice_price, juice_description) 
                       VALUES (?, ?, ?, ?)");
			$stmt->execute([$name, $type, $price, $desc]);
        }
    }
    fclose($handle);
}


function renderJuiceTable($pdo, $type) {
    $stmt = $pdo->prepare("SELECT juice_name, juice_price, juice_description 
                           FROM Juices 
                           WHERE juice_type = ? 
                           ORDER BY juice_price DESC, juice_name ASC");
    $stmt->execute([$type]);
    $juices = $stmt->fetchAll();

    $total = 0;
    $count = count($juices);

    echo "<table>";
    echo "<tr><th colspan='3'>" . ($type === 'Fruit' ? "Fruit Juices" : "Vegetable Juices") . "</th></tr>";
    echo "<tr><th>Name</th><th>Price</th><th>Description</th></tr>";

    foreach ($juices as $juice) {
        $price = number_format($juice['juice_price'], 2);
        echo "<tr>
                <td>" . htmlspecialchars($juice['juice_name']) . "</td>
                <td>£" . $price . "</td>
                <td>" . htmlspecialchars($juice['juice_description']) . "</td>
            </tr>";
        $total += $juice['juice_price'];
    }

    $avg = $count > 0 ? $total / $count : 0;

    // Proper 3-column row for TOTAL and AVERAGE
    echo "<tr><td>TOTAL juices</td><td>£" . number_format($total, 2) . "</td><td></td></tr>";
    echo "<tr><td>AVERAGE juice cost</td><td>£" . number_format($avg, 2) . "</td><td></td></tr>";
    echo "</table><br>";
}

renderJuiceTable($pdo, 'Fruit');
renderJuiceTable($pdo, 'Veg');
?>
</main> 
</body>
</html>
