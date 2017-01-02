<?php
	include_once('includes/connect_database.php');
?>

<div id="content" class="container col-md-12">
	<?php

		if(isset($_POST['btnDelete'])){
			if(isset($_GET['id'])){
				$ID = $_GET['id'];
			}else{
				$ID = "";
			}

			// get image file from menu table
			$sql_query = "SELECT Menu_image
					FROM tbl_menu
					WHERE Menu_ID = ?";

			$stmt = $connect->stmt_init();
			if($stmt->prepare($sql_query)) {
				// Bind your variables to replace the ?s
				$stmt->bind_param('s', $ID);
				// Execute query
				$stmt->execute();
				// store result
				$stmt->store_result();
				$stmt->bind_result($menu_image);
				$stmt->fetch();
				$stmt->close();
			}

			// delete image file from directory
			$delete = unlink("$menu_image");

			// delete data from menu table
			$sql_query = "DELETE FROM tbl_menu
					WHERE Menu_ID = ?";

			$stmt = $connect->stmt_init();
			if($stmt->prepare($sql_query)) {
				// Bind your variables to replace the ?s
				$stmt->bind_param('s', $ID);
				// Execute query
				$stmt->execute();
				// store result
				$delete_result = $stmt->store_result();
				$stmt->close();
			}

			// if delete data success back to reservation page
			if($delete_result){
				header("location: menu.php");
			}
		}

		if(isset($_POST['btnNo'])){
			header("location: menu.php");
		}

	?>
	<h1>메뉴 삭제</h1>
	<hr />
	<form method="post">
		<p>한번 삭제한 메뉴는 다시 복구할 수 없습니다. 메뉴를 삭제하시겠습니까?</p>
		<input type="submit" class="btn btn-primary" value="삭제" name="btnDelete"/>
		<input type="submit" class="btn btn-danger" value="취소" name="btnNo"/>
	</form>
	<div class="separator"> </div>
</div>

<?php include_once('includes/close_database.php'); ?>
