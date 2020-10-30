<?php
class ShowComponents {
	public function Index() {

		require_once('login/auth.php');
		include('mysql_connect.php');

		$owner = $_SESSION['SESS_MEMBER_ID'];

		if(isset($_GET['by'])) {

			$by			=	strip_tags(mysqli_real_escape_string($con, $_GET["by"]));
			$order_q	=	strip_tags(mysqli_real_escape_string($con, $_GET["order"]));

			if($order_q == 'desc' or $order_q == 'asc'){
				$order = $order_q;
			}
			else{
				$order = 'asc';
			}

			if($by == 'price' or $by == 'amount' or $by == 'quantity' or $by == 'cas_number') {
				$GetDataComponentsAll = "SELECT id, name, category, cas_number, amount, volume, quantity, datasheet, comment FROM data WHERE owner = ".$owner." AND archived = '0' ORDER by ".$by." +0 ".$order."";
			}
			elseif($by == 'name' or $by == 'category' ) {
				$GetDataComponentsAll = "SELECT id, name, category, cas_number, amount, volume, quantity, datasheet, comment FROM data WHERE owner = ".$owner." AND archived = '0' ORDER by ".$by." ".$order."";
			}
			else {
				$GetDataComponentsAll = "SELECT id, name, category, cas_number, amount, volume, quantity, datasheet, comment FROM data WHERE owner = ".$owner." AND archived = '0' ORDER by name ASC";
			}
		}
		else {
			$GetDataComponentsAll = "SELECT id, name, category, cas_number, amount, volume, quantity, datasheet, comment FROM data WHERE owner = ".$owner." AND archived = '0' ORDER by name ASC";
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

				if ($showDetails['category'] < 999) {
					$head_cat_id = substr($showDetails['category'], -3, 1);
				}
				else {
					$head_cat_id = substr($showDetails['category'], -4, 2);
				}
				$subcatid = $showDetails['category'];

				$CategoryName = "SELECT * FROM category_head WHERE id = ".$head_cat_id."";
				$sql_exec_catname = mysqli_Query($con, $CategoryName);

				while($showDetailsCat = mysqli_fetch_array($sql_exec_catname)) {
					$catname = $showDetailsCat['name'];
				}

			echo "<a href='category.php?cat=$head_cat_id'>$catname</a>";
			echo "</td>";

			echo "<td>";
			$cas_number = $showDetails['cas_number'];
				if ($cas_number == ""){
					echo "-";
				}
				else{
					echo $cas_number;
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

			echo '<td>';
			$volume = $showDetails['volume'];
			if ($volume==""){
				echo "-";
			}

			else{
				echo $volume;
			}

			echo '<td>';
                        $quantity = $showDetails['quantity'];
                        if ($quantity==""){
                                echo "-";
                        }

                        else{
                                echo $quantity;
                        }


			echo '<td>';
			$datasheet = $showDetails['datasheet'];
			if ($datasheet==""){
				echo "-";
			}

			else{
				echo '<a href="';
				echo $datasheet;
				echo '"  target="_blank"><span class="icon medium document"></span></a></td>';
			}

			$comment = $showDetails['comment'];
			if ($comment==""){
				echo '<td class="comment"><div>';
				echo "-";
				echo '</span></div></td>';
			}
			else{
				echo '<td class="comment"><div><span class="icon medium spechBubbleSq"></span><span class="comment">';
				echo nl2br($showDetails['comment']);
				echo '</span></div></td>';
			}
			echo "</tr>";
		}
	}
	public function Category() {

		require_once('include/login/auth.php');
		include('include/mysql_connect.php');

		$owner = $_SESSION['SESS_MEMBER_ID'];

		if(isset($_GET['cat'])) {

			$cat = (int)$_GET['cat'];
			$subcatfrom = $cat*100;
			$subcatto = $subcatfrom+99;


			$CategoryName = "SELECT * FROM category_sub WHERE id = ".$cat."";
			$sql_exec_catname = mysqli_Query($con, $CategoryName);

			if(isset($_GET['by'])) {

				$by			=	strip_tags(mysqli_real_escape_string($con, $_GET["by"]));
				$order_q	=	strip_tags(mysqli_real_escape_string($con, $_GET["order"]));

				if($order_q == 'desc' or $order_q == 'asc') {
					$order = $order_q;
				}
				else {
					$order = 'asc';
				}

				if($by == 'price' or $by == 'amount' or $by == 'quantity' or $by == 'cas_number' or $by = volume) {
					$ComponentsCategory = "SELECT id, name, category, cas_number, amount, volume, quantity, datasheet, comment FROM data WHERE category BETWEEN ".$subcatfrom." AND ".$subcatto." AND owner = ".$owner." AND archived = '0' ORDER by ".$by." +0 ".$order."";
				}
				elseif($by == 'name' or $by == 'category'  ) {
					$ComponentsCategory = "SELECT id, name, category, cas_number, amount, volume, quantity, datasheet, comment FROM data WHERE category BETWEEN ".$subcatfrom." AND ".$subcatto." AND owner = ".$owner." AND archived = '0' ORDER by ".$by." ".$order."";
				}
				else {
					$ComponentsCategory = "SELECT id, name, category, cas_number, amount, volume, quantity, datasheet, comment FROM data WHERE category BETWEEN ".$subcatfrom." AND ".$subcatto." AND owner = ".$owner." AND archived = '0' ORDER by name ASC";
				}
			}
			else {
				$ComponentsCategory = "SELECT id, name, category, cas_number, amount, volume, quantity, datasheet, comment FROM data WHERE category BETWEEN ".$subcatfrom." AND ".$subcatto." AND owner = ".$owner." AND archived = '0' ORDER by name ASC";
			}

			$sql_exec_component = mysqli_Query($con, $ComponentsCategory);

			while ($showDetails = mysqli_fetch_array($sql_exec_component)) {
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
				$subcatid = $showDetails['category'];

				$CategoryName = "SELECT * FROM category_sub WHERE id = ".$subcatid."";
				$sql_exec_catname = mysqli_Query($con, $CategoryName);

				while($showDetailsCat = mysqli_fetch_array($sql_exec_catname)) {
					$catname = $showDetailsCat['name'];
				}

				echo "<a href='category.php?subcat=$subcatid'>$catname</a>";
				echo "</td>";

				echo "<td>";
				$cas_number = $showDetails['cas_number'];
					if ($cas_number == ""){
						echo "-";
					}
					else{
						echo $cas_number;
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

				echo '<td>';
				$datasheet = $showDetails['datasheet'];
				if ($datasheet==""){
					echo "-";
				}
				else{
					echo '<a href="';
					echo $datasheet;
					echo '" target="_blank"><span class="icon medium document"></span></a></td>';
				}
				echo "</td>";

				$comment = $showDetails['comment'];
				if ($comment == ""){
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


		if(isset($_GET['subcat'])) {

			$subcat = (int)$_GET['subcat'];

			$CategoryName = "SELECT * FROM category_sub WHERE id = ".$subcat."";
			$sql_exec_catname = mysqli_Query($con, $CategoryName);

			if(isset($_GET['by'])) {

				$by			=	strip_tags(mysqli_real_escape_string($con, $_GET["by"]));
				$order_q	=	strip_tags(mysqli_real_escape_string($con, $_GET["order"]));

				if($order_q == 'desc' or $order_q == 'asc') {
					$order = $order_q;
				}
				else {
					$order = 'asc';
				}

				if($by == 'price' or $by == 'amount' or $by == 'quantity' or $by == 'cas_number' or $by == 'volume') {
					$ComponentsCategory = "SELECT id, name, category, cas_number, amount, volume, quantity, datasheet, comment FROM data WHERE category = ".$subcat." AND owner = ".$owner." AND archived = '0' ORDER by ".$by." +0 ".$order."";
				}
				elseif($by == 'name' or $by == 'category') {
					$ComponentsCategory = "SELECT id, name, category, cas_number, amount, volume, quantity, datasheet, comment FROM data WHERE category = ".$subcat." AND owner = ".$owner." AND archived = '0' ORDER by ".$by." ".$order."";
				}
				else {
					$ComponentsCategory = "SELECT id, name, category, cas_number, amount, volume, quantity, datasheet, comment FROM data WHERE category = ".$subcat." AND owner = ".$owner." AND archived = '0' ORDER by name ASC";
				}
			}
			else{
				$ComponentsCategory = "SELECT id, name, category, cas_number, amount, volume, quantity, datasheet, comment FROM data WHERE category = ".$subcat." AND owner = ".$owner." AND archived = '0' ORDER by name ASC";
			}

			$sql_exec_component = mysqli_Query($con, $ComponentsCategory);

			while ($showDetails = mysqli_fetch_array($sql_exec_component)) {
				echo "<tr>";

				echo '<td class="edit"><a href="edit_component.php?edit=';
				echo $showDetails['id'];
				echo '"><img src="img/pencil.png" alt="Edit"/></a></td>';

				echo '<td><a href="component.php?view=';
				echo $showDetails['id'];
				echo '">';
				echo $showDetails['name'];
				echo "</a></td>";

				echo "<td>";
					while($showDetailsCat = mysqli_fetch_array($sql_exec_catname)) {
						$catname = $showDetailsCat['name'];
					}
					echo $catname;
				echo "</td>";

				echo "<td>";
				$cas_number = $showDetails['cas_number'];
					if ($cas_number == ""){
						echo "-";
					}
					else{
						echo $cas_number;
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

				echo '<td>';
				$datasheet = $showDetails['datasheet'];
				if ($datasheet==""){
					echo "-";
				}
				else{
					echo '<a href="';
					echo $datasheet;
					echo '" target="_blank"><img src="img/document.png" alt="Download PDF"/></a></td>';
				}


				$comment = $showDetails['comment'];
				if ($comment == ""){
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
	public function History() {

       				require_once('include/login/auth.php');
                		include('include/mysql_connect.php');

               			$owner = $_SESSION['SESS_MEMBER_ID'];

              			if (isset($_GET['by'])){
                                        $by                     =       strip_tags(mysqli_real_escape_string($con, $_GET["by"]));
                                        $order_q        =       strip_tags(mysqli_real_escape_string($con, $_GET["order"]));

                                        if($order_q == 'desc' or $order_q == 'asc'){
                                                $order = $order_q;
                                        }
                                        else{
                                                $order = 'asc';
                                        }
					if($by == 'price' or $by == 'amount' or $by == 'quantity' or $by == 'volume' or $by == 'cas_number') {
                                                $SearchQuery = "SELECT * FROM data WHERE (archived LIKE'1' ) AND owner = $owner ORDER by $by +0 $order";
                                        }
                                        elseif($by == 'name' or $by == 'category' or $by =='package' or $by =='smd' or $by =='manufacturer') {
                                                $SearchQuery = "SELECT * FROM data WHERE ( archived LIKE'1') AND owner = $owner ORDER by $by $order";
                                        }
                                        else {
                                                $SearchQuery = "SELECT * FROM data WHERE (archived LIKE'1' ) AND owner = $owner ORDER by name ASC";
                                        }
                                }
                                else{
                                        $SearchQuery = "SELECT * FROM data WHERE (archived LIKE'1' ) AND owner = $owner ORDER by name ASC";
                                }

                                $sql_exec = mysqli_Query($con, $SearchQuery);
                                $anymatches = mysqli_num_rows($sql_exec);
                                if ($anymatches == 0) {
                                        echo '<div class="message red">';
                                                echo "No items have been archived.";
                                        echo '</div>';
                                }
				while($showDetails = mysqli_fetch_array($sql_exec)) {
                                        echo "<tr>";

                                        echo '<td class="edit"><a href="edit_component.php?edit=';
                                        echo $showDetails['id'];
                                        echo '"><img src="img/pencil.png" alt="Edit"/></a></td>';

                                        echo '<td><a href="component.php?view=';
                                        echo $showDetails['id'];
                                        echo '">';

                                        echo $showDetails['name'];
                                        echo "</a></td>";

                                        echo "<td>";
                                                if ($showDetails['category'] < 999) {
                                                        $head_cat_id = substr($showDetails['category'], -3, 1);
                                                }
                                                else {
                                                        $head_cat_id = substr($showDetails['category'], -4, 2);
                                                }
                                                $subcatid = $showDetails['category'];

                                                $CategoryName = "SELECT * FROM category_head WHERE id = ".$head_cat_id."";
                                                $sql_exec_catname = mysqli_Query($con, $CategoryName);

                                                while($showDetailsCat = mysqli_fetch_array($sql_exec_catname)) {
                                                        $catname = $showDetailsCat['name'];
                                                }

                                        echo $catname;
                                        echo "</td>";

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
                                        $cas_number = $showDetails['cas_number'];
                                                if ($cas_number == ""){
                                                        echo "-";
                                                }
                                                else{
                                                        echo $cas_number;
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
                                        $datearchived = $showDetails['datearchived'];
                                                if ($datearchived == ""){
                                                        echo "-";
                                                }
                                                else{
                                                        echo $datearchived;
                                                }
                                        echo "</td>";
					echo '<td>';
                                        $datasheet = $showDetails['datasheet'];
                                        if ($datasheet==""){
                                                echo "-";
                                        }
                                        else{
                                                echo '<a href="';
                                                echo $datasheet;
                                                echo ' target="_blank""><span class="icon medium document"></span></a></td>';
                                        }


                                        $comment = $showDetails['comment'];
                                        if ($comment == ""){
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
		
	public function Search() {

		if(isset($_GET['q'])) {

			require_once('include/login/auth.php');
			include('include/mysql_connect.php');

			$owner = $_SESSION['SESS_MEMBER_ID'];

			$query = mysqli_real_escape_string($con, $_GET['q']);

			$query1 = strtoupper($query);
			$query2 = strip_tags($query1);
			$find = trim($query2);


			if ($find == "") {
				echo '<div class="message red">';
					echo "You forgot to enter a search term.";
				echo '</div>';
			}
			else {


				if (isset($_GET['by'])){
					$by			=	strip_tags(mysqli_real_escape_string($con, $_GET["by"]));
					$order_q	=	strip_tags(mysqli_real_escape_string($con, $_GET["order"]));

					if($order_q == 'desc' or $order_q == 'asc'){
						$order = $order_q;
					}
					else{
						$order = 'asc';
					}

					if($by == 'price' or $by == 'amount' or $by == 'quantity' or $by == 'volume' or $by == 'cas_number') {
						// $SearchQuery = "SELECT * FROM data WHERE MATCH (name,cas_number,manufacturer,amount,item_number,comment,barcode2,barcode,barcode3,barcode4,barcode5,barcode6,barcode7) AGAINST ('*$find*' IN BOOLEAN MODE) AND owner = $owner ORDER by $by +0 $order";
						$SearchQuery = "SELECT * FROM data WHERE (name LIKE '%$find%' OR cas_number LIKE '$find%' ) AND owner = $owner ORDER by $by +0 $order";
					}
					elseif($by == 'name' or $by == 'category' or $by =='package' or $by =='smd' or $by =='manufacturer') {
						// $SearchQuery = "SELECT * FROM data WHERE MATCH (name,cas_number,manufacturer,amount,item_number,comment,barcode2,barcode,barcode3,barcode4,barcode5,barcode6,barcode7) AGAINST ('*$find*' IN BOOLEAN MODE) AND owner = $owner ORDER by $by $order";
						$SearchQuery = "SELECT * FROM data WHERE (name LIKE '%$find%' OR cas_number LIKE '$find%' ) AND owner = $owner ORDER by $by $order";
					}
					else {
						// $SearchQuery = "SELECT * FROM data WHERE MATCH (name,cas_number,manufacturer,amount,item_number,comment,barcode2,barcode,barcode3,barcode4,barcode5,barcode6,barcode7) AGAINST ('*$find*' IN BOOLEAN MODE) AND owner = $owner ORDER by name ASC";
						$SearchQuery = "SELECT * FROM data WHERE (name LIKE '%$find%' OR cas_number LIKE '$find%' ) AND owner = $owner ORDER by name ASC";
					}
				}
				else{
					// $SearchQuery = "SELECT * FROM data WHERE MATCH (name,cas_number,manufacturer,amount,item_number,comment,barcode2,barcode,barcode3,barcode4,barcode5,barcode6,barcode7) AGAINST ('*$find*' IN BOOLEAN MODE) AND owner = $owner ORDER by name ASC";
					$SearchQuery = "SELECT * FROM data WHERE (name LIKE '%$find%' OR cas_number LIKE '$find%' ) AND owner = $owner ORDER by name ASC";
				}

				$sql_exec = mysqli_Query($con, $SearchQuery);
				$anymatches = mysqli_num_rows($sql_exec);
				if ($anymatches == 0) {
					echo '<div class="message red">';
						echo "Sorry, but we can not find an entry to match your query.";
					echo '</div>';
				}

				while($showDetails = mysqli_fetch_array($sql_exec)) {
					echo "<tr>";

					echo '<td class="edit"><a href="edit_component.php?edit=';
					echo $showDetails['id'];
					echo '"><img src="img/pencil.png" alt="Edit"/></a></td>';
					
					if ($showDetails['quantity'] == 0) {

					echo '<td><a href="component.php?view=';
					echo $showDetails['id'];
					echo '" style="color: rgb(255,0,0)">';
					}

					else {
					echo '<td><a href="component.php?view=';
                                        echo $showDetails['id'];
                                        echo '">';
					}

					echo $showDetails['name'];
					echo "</a></td>";

					echo "<td>";
						if ($showDetails['category'] < 999) {
							$head_cat_id = substr($showDetails['category'], -3, 1);
						}
						else {
							$head_cat_id = substr($showDetails['category'], -4, 2);
						}
						$subcatid = $showDetails['category'];

						$CategoryName = "SELECT * FROM category_head WHERE id = ".$head_cat_id."";
						$sql_exec_catname = mysqli_Query($con, $CategoryName);

						while($showDetailsCat = mysqli_fetch_array($sql_exec_catname)) {
							$catname = $showDetailsCat['name'];
						}

					echo $catname;
					echo "</td>";

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
					$cas_number = $showDetails['cas_number'];
						if ($cas_number == ""){
							echo "-";
						}
						else{
							echo $cas_number;
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


					echo '<td>';
					$datasheet = $showDetails['datasheet'];
					if ($datasheet==""){
						echo "-";
					}
					else{
						echo '<a href="';
						echo $datasheet;
						echo ' target="_blank""><span class="icon medium document"></span></a></td>';
					}


					$comment = $showDetails['comment'];
					if ($comment == ""){
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
	}

	public function Add() {

		require_once('include/login/auth.php');
		include('include/mysql_connect.php');

		if(isset($_POST['submit']) or isset($_POST['update'])) {
			$owner				=	$_SESSION['SESS_MEMBER_ID'];

			if (empty($_GET['edit'])) {
				$id				=	'';
			}
			else{
				$id				= 	(int)$_GET['edit'];
			}

			if (empty($_POST['name'])) {
				$name = '';
			}
			else{
				$name			=	strip_tags(mysqli_real_escape_string($con, $_POST['name']));
			}

			if (empty($_POST['quantity'])) {
				$quantity = 0;
			}
			else{
				$quantity			=	str_replace(',', '.', strip_tags(mysqli_real_escape_string($con, $_POST['quantity'])));
			}

			if (empty($_POST['category'])) {
				$category = '';
			}
			else{
				$category		=	strip_tags(mysqli_real_escape_string($con, $_POST['category']));
			}

			if (empty($_POST['project'])) {
				$project = '';
			}
			else{
				$project		=	strip_tags(mysqli_real_escape_string($con, $_POST['project']));
			}

			$comment			=	strip_tags(mysqli_real_escape_string($con, $_POST['comment']));
			$order_quantity		=	str_replace(',', '.', strip_tags(mysqli_real_escape_string($con, $_POST['order_quantity'])));
			$project_quantity	=	str_replace(',', '.', strip_tags(mysqli_real_escape_string($con, $_POST['projquant'])));
			$price				=	str_replace(',', '.', strip_tags(mysqli_real_escape_string($con, $_POST['price'])));
			$item_number			=	strip_tags(mysqli_real_escape_string($con, $_POST['item_number']));
			$manufacturer		=	strip_tags(mysqli_real_escape_string($con, $_POST['manufacturer']));
			$cas_number			=	strip_tags(mysqli_real_escape_string($con, $_POST['cas_number']));
			$amount				=	str_replace(',', '.', strip_tags(mysqli_real_escape_string($con, $_POST['amount'])));
			$scrap				=	strip_tags(mysqli_real_escape_string($con, $_POST['scrap']));
			$public				=	strip_tags(mysqli_real_escape_string($con, $_POST['public']));
			$width				=	str_replace(',', '.', strip_tags(mysqli_real_escape_string($con, $_POST['width'])));
			$height				=	str_replace(',', '.', strip_tags(mysqli_real_escape_string($con, $_POST['height'])));
			$depth				=	str_replace(',', '.', strip_tags(mysqli_real_escape_string($con, $_POST['depth'])));
			$weight				=	str_replace(',', '.', strip_tags(mysqli_real_escape_string($con, $_POST['weight'])));
			$datasheet			=	strip_tags(mysqli_real_escape_string($con, $_POST['datasheet']));
			$barcode2				=	strip_tags(mysqli_real_escape_string($con, $_POST['barcode2']));
			$barcode3				=	strip_tags(mysqli_real_escape_string($con, $_POST['barcode3']));
			$barcode4			=	strip_tags(mysqli_real_escape_string($con, $_POST['barcode4']));
			$barcode5			=	strip_tags(mysqli_real_escape_string($con, $_POST['barcode5']));
			$barcode6                       =       strip_tags(mysqli_real_escape_string($con, $_POST['barcode6']));
                        $barcode7                       =       strip_tags(mysqli_real_escape_string($con, $_POST['barcode7']));
			$volume                         =       strip_tags(mysqli_real_escape_string($con, $_POST['volume']));
			$barcode                        =       strip_tags(mysqli_real_escape_string($con, $_POST['barcode']));
			$datea                           =       strip_tags(mysqli_real_escape_string($con, $_POST['datea']));
			$dateo                           =       strip_tags(mysqli_real_escape_string($con, $_POST['dateo']));
			$datex                           =       strip_tags(mysqli_real_escape_string($con, $_POST['datex']));
			$mw                           	=       strip_tags(mysqli_real_escape_string($con, $_POST['mw']));
			$onorder         		=       str_replace(',', '.', strip_tags(mysqli_real_escape_string($con, $_POST['onorder'])));


			if ($name == '') {
				echo '<div class="message red">';
				echo 'You have to specify a name!';
				echo '</div>';
			}
			elseif ($category == '') {
				echo '<div class="message red">';
				echo 'You have to choose a location!';
				echo '</div>';
			}
			elseif (!empty($project_quantity) && empty($project)) {
				echo '<div class="message red">';
				echo 'You have to choose a project!';
				echo '</div>';
			}
			elseif (!empty($project) && empty($project_quantity)) {
				echo '<div class="message red">';
				echo 'You have to specify a quantity for this component to add to the project!';
				echo '</div>';
			}
			elseif (strlen($comment) >= 2500) {
				echo '<div class="message red">';
				echo 'Max 2500 characters in the comment!';
				echo '</div>';
			}
			elseif (!empty($_POST['quantity']) && !is_numeric($quantity)) {
				echo '<div class="message red">';
				echo 'The quantity must only be a number!';
				echo '</div>';
			}
			elseif (!empty($_POST['amount']) && !is_numeric($amount)) {
				echo '<div class="message red">';
				echo 'The amount must only be a number!';
				echo '</div>';
			}
			elseif (!empty($_POST['volume']) && !is_numeric($volume)) {
                                echo '<div class="message red">';
                                echo 'The volume must only be a number!';
                                echo '</div>';
                        }
			elseif (!empty($_POST['price']) && !is_numeric($price)) {
				echo '<div class="message red">';
				echo 'The price must only be a number!';
				echo '</div>';
			}
			elseif (!empty($_POST['orderquant']) && !is_numeric($order_quantity)) {
				echo '<div class="message red">';
				echo 'The order quantity must only be a number!';
				echo '</div>';
			}
			elseif (!empty($_POST['weight']) && !is_numeric($weight)) {
				echo '<div class="message red">';
				echo 'The weight must only be a number!';
				echo '</div>';
			}
			elseif (!empty($_POST['width']) && !is_numeric($width)) {
				echo '<div class="message red">';
				echo 'The width must only be a number!';
				echo '</div>';
			}
			elseif (!empty($_POST['depth']) && !is_numeric($depth)) {
				echo '<div class="message red">';
				echo 'The depth must only be a number!';
				echo '</div>';
			}
			elseif (!empty($_POST['height']) && !is_numeric($height)) {
				echo '<div class="message red">';
				echo 'The height must only be a number!';
				echo '</div>';
			}
			else {
				if(isset($_POST['submit'])) {
					$sql="INSERT into data (owner, name, manufacturer, cas_number, amount, quantity, item_number, scrap, width, height, depth, weight, datasheet, comment, category, barcode2, barcode3, barcode4, barcode5, price, public, order_quantity, volume, barcode, datea, dateo, datex, onorder, mw, barcode6, barcode7)
					VALUES
					('$owner', '$name', '$manufacturer', '$cas_number', '$amount', '$quantity', '$item_number', '$scrap', '$width', '$height', '$depth', '$weight', '$datasheet', '$comment', '$category', '$barcode2', '$barcode3', '$barcode4', '$barcode5', '$price', '$public', '$order_quantity','$volume','$barcode','$datea','$dateo','$datex','$onorder','$mw','$barcode6','$barcode7')";

					$sql_exec = mysqli_Query($con, $sql) or die(mysqli_error($con));
					$component_id = mysqli_insert_id($con);

					if (!empty($project) && !empty($project_quantity)) {
						$proj_add="INSERT into projects_data (projects_data_owner_id, projects_data_project_id, projects_data_component_id, projects_data_quantity)
							VALUES
							('$owner', '$project', '$component_id', '$project_quantity')";

						$sql_exec = mysqli_Query($con, $proj_add);
					}

					/*------------------------------------------------------------------------------------------
					$proj =	$_POST['project'];

					foreach ($proj as $quantity){
						$project = array_search($quantity, $proj);
						//echo $quantity;	// Quantity
						//echo ' - ';
						//echo $project;	// Project ID.
						//echo ' <br />';
						if ($quantity == 0){
							echo 'None';
						}
						else{
							$proj_add="INSERT into projects_data (owner_id, project_id, component_id, quantity)
							VALUES
							('$owner', '$project', '$component_id', '$quantity')";

							$sql_exec = mysqli_Query($con, $proj_add);

							echo 'Inserted';
						}
					}
					------------------------------------------------------------------------------------------*/

					echo '<div class="message green center">';
					echo 'Component added! - <a href="component.php?view=';
					echo $component_id;
					echo '">View component (';
						$result = mysqli_Query($con, "SELECT name FROM data WHERE id = '$component_id'");
						$name = mysqli_fetch_array($result);
						echo $name['name'];
					echo ')</a>';
					echo '</div>';
				}

				if(isset($_POST['update'])) {
					$sql = "UPDATE data SET
					name = '$name', manufacturer = '$manufacturer', volume = '$volume', barcode = '$barcode', datea = '$datea', dateo = '$dateo', datex = '$datex', onorder = '$onorder', cas_number = '$cas_number', amount = '$amount', quantity = '$quantity', item_number = '$item_number', scrap = '$scrap', width = '$width', height = '$height', depth = '$depth', weight = '$weight', datasheet = '$datasheet', comment = '$comment', category = '$category', barcode2 = '$barcode2', barcode3 = '$barcode3',  barcode4 = '$barcode4', barcode5 = '$barcode5', price = '$price', public = '$public', mw = '$mw', barcode6 = '$barcode6', barcode7 = '$barcode7', order_quantity = '$order_quantity'	WHERE id = '$id'";

					$sql_exec = mysqli_Query($con, $sql);

					if (!empty($project) && !empty($project_quantity)) {
						$proj_add="INSERT into projects_data (projects_data_owner_id, projects_data_project_id, projects_data_component_id, projects_data_quantity)
							VALUES
							('$owner', '$project', '$id', '$project_quantity')";

						$sql_exec = mysqli_Query($con, $proj_add) or die(mysqli_error($con));
						echo $project;
						echo ' Owner ';
						echo $owner;
						echo ' id ';
						echo $id;
						echo ' projquant ';
						echo $project_quantity;
					}

					if (isset($_POST['projquantedit'])) {
						$proj =	$_POST['projquantedit'];

						foreach ($proj as $quantity_proj_add){
							$projects = array_search($quantity_proj_add, $proj);
							$sqlDeleteProject = "DELETE FROM projects_data WHERE projects_data_component_id = '$id' AND projects_data_project_id = '$projects'";
							$sql_exec_project_delete = mysqli_Query($con, $sqlDeleteProject);

							if ($quantity_proj_add == 0){
								echo 'None';
							}
							else{
								$proj_edit="INSERT into projects_data (projects_data_owner_id, projects_data_project_id, projects_data_component_id, projects_data_quantity)
								VALUES
								('$owner', '$projects', '$id', '$quantity_proj_add')";

								$sql_exec = mysqli_Query($con, $proj_edit);

								/*
								echo 'Projid: ';
								echo $project;
								echo ' Quantity: ';
								echo $quantity;
								echo ' Id: ';
								echo $id;
								echo '<br>';
								*/
							}
						}
					}
					header("location: " . $_SERVER['REQUEST_URI']);
				}
			}
		}
	}
}
?>
