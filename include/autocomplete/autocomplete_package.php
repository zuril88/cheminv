<?php
require_once "../mysql_connect.php";
$q = strtolower($_GET["q"]);
if (!$q) return;

$sql = "select DISTINCT package as package from data where package LIKE '%$q%' ORDER by name ASC";
$rsd = mysqli_Query($con, $sql);
while($rs = mysqli_fetch_array($rsd)) {
	$cname = $rs['package'];
	echo "$cname\n";
}
?>