<?php
	include_once('includes/connect_database.php');
?>

<div id="content" class="container col-md-12">
	<?php
		if(isset($_GET['id'])){
			$ID = $_GET['id'];
		}else{
			$ID = "";
		}

		// create array variable to store data from database
		$data = array();

		// get currency symbol from setting table
		$sql_query = "SELECT Value
				FROM tbl_setting
				WHERE Variable = 'Currency'";

		$stmt = $connect->stmt_init();
		if($stmt->prepare($sql_query)) {
			// Execute query
			$stmt->execute();
			// store result
			$stmt->store_result();
			$stmt->bind_result($currency);
			$stmt->fetch();
			$stmt->close();
		}

		// get all data from menu table and category table
		$sql_query = "SELECT Menu_ID, Menu_name, Serve_for, Price, Category_name, Menu_image, Description
				FROM tbl_menu m, tbl_category c
				WHERE m.Menu_ID = ? AND m.Category_ID = c.Category_ID";

		$stmt = $connect->stmt_init();
		if($stmt->prepare($sql_query)) {
			// Bind your variables to replace the ?s
			$stmt->bind_param('s', $ID);
			// Execute query
			$stmt->execute();
			// store result
			$stmt->store_result();
			$stmt->bind_result($data['Menu_ID'],
					$data['Menu_name'],
					$data['Serve_for'],
					$data['Price'],
					$data['Category_name'],
					$data['Menu_image'],
					$data['Description']
					);
			$stmt->fetch();
			$stmt->close();
		}

	?>

<div class="col-md-9 col-md-offset-2">
	<h1>메뉴 상세보기</h1>
	<form method="post">
		<table table class='table table-bordered table-condensed'>
			<tr class="row">
				<th class="detail" style="width:100px;">메뉴ID</th>
				<td class="detail"><?php echo $data['Menu_ID']; ?></td>
			</tr>
			<tr class="row">
				<th class="detail">메뉴명</th>
				<td class="detail"><?php echo $data['Menu_name']; ?></td>
			</tr>
				<tr class="row">
				<th class="detail">상태</th>
				<td class="detail"><?php echo $data['Serve_for']; ?></td>
			</tr>
			<tr class="row">
				<th class="detail">가격</th>
				<td class="detail"><?php echo $data['Price']." ".$currency; ?></td>
			</tr>
			<tr class="row">
				<th class="detail">카테고리</th>
				<td class="detail"><?php echo $data['Category_name']; ?></td>
			</tr>
			<tr class="row">
				<th class="detail">대표이미지</th>
				<td class="detail"><img src="<?php echo $data['Menu_image']; ?>" width="200" height="150"/></td>
			</tr>
			<tr class="row">
				<th class="detail">메뉴설명</th>
				<td class="detail"><?php echo $data['Description']; ?></td>
			</tr>
		</table>

	</form>
	<div id="option_menu">
			<a href="edit-menu.php?id=<?php echo $ID; ?>"><button class="btn btn-primary">편집</button></a>
			<a href="delete-menu.php?id=<?php echo $ID; ?>"><button class="btn btn-danger">삭제</button></a>
	</div>

	</div>

	<div class="separator"> </div>
</div>

<?php include_once('includes/close_database.php'); ?>
