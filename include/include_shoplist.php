<?php
class Shoplist {
	public function ShoplistList() {
	
		require_once('login/auth.php');
		include('mysql_connect.php');
		
		$owner = $_SESSION['SESS_MEMBER_ID'];
		
		if(isset($_GET['by'])) {
		
			$by = $_GET["by"];
			$order = $_GET["order"];
			
			$bysql = mysqli_real_escape_string($con, $by);
			$ordersql = mysqli_real_escape_string($con, $order);
			
			if($by == 'price' or $by == 'pins' or $by == 'quantity') {
			
				$GetDataComponentsAll = "SELECT * FROM data WHERE owner = ".$owner." AND order_quantity > 0 ORDER by ".$bysql." +0 ".$ordersql."";
			}
			else {
			
				$GetDataComponentsAll = "SELECT * FROM data WHERE owner = ".$owner." AND order_quantity > 0 ORDER by ".$bysql." ".$ordersql."";
			}
		}
		else {
			$GetDataComponentsAll = "SELECT * FROM data WHERE owner = ".$owner." AND order_quantity > 0 ORDER by name ASC";
		}
		
		
		$sql_exec = mysqli_Query($con, $GetDataComponentsAll);

		while($showDetails = mysqli_fetch_array($sql_exec)) {
			echo "<tr>";

			echo '<td class="edit"><a href="edit_component.php?edit=';
			echo $showDetails['id'];
			echo '"><span class="icon medium pencil"></span></a></td>';

			echo '<td><a href="component.php?view=';
			echo $showDetails['id'];
			echo '">';

			echo $showDetails['name'];
			echo "</a></td>";

			echo "<td>";
			$manufacturer = $showDetails['manufacturer'];
				if ($manufacturer == ""){
					echo "-";
				}
				else{
					echo $manufacturer;
				}
			echo "</td>";

			echo "<td>";
			$casnumber = $showDetails['cas_number'];
				if ($casnumber == ""){
					echo "-";
				}
				else{
					echo $casnumber;
				}
			echo "</td>";


			echo "<td>";
			$amount = $showDetails['amount'];
				if ($amount == ""){
					echo "-";
				}
				else{
					echo $amount;
				}
			echo "</td>";

			echo "<td>";
                        $volume = $showDetails['volume'];
                                if ($volume == ""){
                                        echo "-";
                                }
                                else{
                                        echo $volume;
                                }
                        echo "</td>";


			echo "<td>";
			$quantity = $showDetails['quantity'];
				if ($quantity == ""){
					echo "-";
				}
				else{
					echo $quantity;
				}
			echo "</td>";
			
			echo "<td>";
			$order_quantity = $showDetails['order_quantity'];
				if ($order_quantity == ""){
					echo "-";
				}
				else{
					echo $order_quantity;
				}
			echo "</td>";

			$comment = $showDetails['comment'];
			if ($comment==""){
				echo '<td class="comment"><div>';
				echo "-";
				echo '</span></div></td>';
			}
			else{
				echo '<td class="comment"><div><span class="icon medium spechBubbleSq"></span><span class="comment">';
				echo $showDetails['comment'];
				echo '</span></div></td>';
			}
			echo "</tr>";
		}
	}
}
?>
