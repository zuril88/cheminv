<?php
require_once "../mysql_connect.php";
$q = strtolower($_GET["q"]);
if (!$q) return;

$sql = "select DISTINCT name as name from data where name LIKE '%$q%' ORDER by name ASC";
$rsd = mysqli_Query($con, $sql);
while($rs = mysqli_fetch_array($rsd)) {
	$cname = $rs['name'];
	echo "$cname\n";
}
?>