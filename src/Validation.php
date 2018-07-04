<?php
/**
 * Validation.php
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

$db_ip = '67.205.183.11';

// TODO write code that validates the above data variables

if (filter_var($db_ip, FILTER_VALIDATE_IP) === false) {
    throw new \RuntimeException("ERROR: FILTER_VALIDATE_IP failed");
}

// $_GET is a PHP super-global read more about super-globals here:
// https://secure.php.net/manual/en/language.variables.superglobals.php
if (filter_var($_GET['col_number'], FILTER_VALIDATE_INT) === false) {
    throw new \RuntimeException("ERROR: FILTER_VALIDATE_INT failed");
}

if (!is_string($_GET['col_string'])) {
    throw new \RuntimeException("ERROR: col_string NOT a string");
}

$conn = mysqli_connect($db_ip, 'student', 'letmein', 'student');
$query = "SELECT col_password FROM test WHERE col_string = '{$_GET['col_string']}' AND col_number = '{$_GET['col_number']}'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
var_dump($row);
mysqli_free_result($result);
mysqli_close($conn);

