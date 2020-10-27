<?php
class ProjectShowPrice {	
	public function ProjectSumTotal() {

		include('mysql_connect.php');
		
		$project_id = (int)$_GET["proj_id"];
		$owner = $_SESSION['SESS_MEMBER_ID'];
		
		$GetPersonal = mysqli_Query($con, "SELECT currency FROM members WHERE member_id = ".$owner."");
		$personal = mysqli_fetch_assoc($GetPersonal);
		
		$GetDataPrice = "SELECT SUM(total) FROM (SELECT projects_data_quantity * price AS total FROM projects_data JOIN `data` WHERE data.id = projects_data_component_id AND projects_data_project_id = ".$project_id.") AS project_total";
		$sql_exec_price = mysqli_Query($con, $GetDataPrice) or die(mysqli_error($con));
		
		while($showPrice = mysqli_fetch_array($sql_exec_price)) {
			if ($showPrice['SUM(total)'] == 0){
				echo "0 ";
				echo ' ';
				echo $personal['currency'];
			}
			else{
				echo $showPrice['SUM(total)']; 
				echo ' ';
				echo $personal['currency'];
			}
		}
	}
}
?>