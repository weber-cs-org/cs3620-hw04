<?php
/**
 * SQLInjection.php
 *
 * PHP Version 7
 *
 * @category Source
 * @package  App
 * @author   Don Stringham <donstringham@weber.edu>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://weber.edu
 */
declare(strict_types=1);
namespace App;

$ip = '67.205.183.11';

if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
    throw new \RuntimeException("ERROR: FILTER_VALIDATE_IP failed");
}

// URL with SQL injection: http://localhost:8000/SQLInjection.php?col_string=%27Two%27+OR+1=1--&col_number=2
// TODO change this below code to prevent SQL Injection
$conn = mysqli_connect($ip, 'student', 'letmein', 'student');
$query = "SELECT * FROM test WHERE col_string = {$_GET['col_string']} AND col_number = {$_GET['col_number']}";

$result = mysqli_query($conn, $query);
if (is_bool($result)) {
    throw new \RuntimeException('ERROR: result is a boolean and NOT a result set');
}
$num_row = mysqli_num_rows($result);

print('Retrieved '.$num_row.' row(s)</br></br>');

while ($row = mysqli_fetch_row($result)) {
    printf('<li>%s, %s, %s, %s, %s</li></br>', $row[0],$row[1],$row[2],$row[3],$row[4]);
}

mysqli_free_result($result);
mysqli_close($conn);

/*
// Prepared Statements to Stop Injection Attacks
$dsn = 'mysql:dbname=student;host='.$ip;
$username = 'student';
$password = 'letmein';

// Set up PDO
$pdo = new \PDO($dsn, $username, $password);


$query = "SELECT * FROM test WHERE col_string = ? AND col_number = ?";
$parameters = [$_GET['col_string'], $_GET['col_number']];
$statement = $pdo->prepare($query);
try {
    $statement->execute($parameters);
} catch (\PDOException $e) {
    print_r($e->getCode(). ': '.$e->getMessage());
}

$rows = $statement->fetchAll(\PDO::FETCH_ASSOC);

print('Retrieved '.$statement->rowCount().' row(s)</br></br>');

foreach ($rows as $row) {
    printf('<li>%s, %s, %s, %s</li></br>', $row['ID'],$row['col_number'],$row['col_string'],$row['col_dttm']);
}
*/
