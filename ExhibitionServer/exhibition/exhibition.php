<!DOCTYPE = html>
<html>
	<?php
	include("../db_pdo_conn.php");
	$sql2 = "SELECT mapImage FROM exhibition";
	$obj = $db -> query($sql2);
	for($i=0;$i<3;$i++){
		$result[$i] = $obj->fetch();
	}
	?>
	<head>
		<title>exhibition</title>
		<meta http-equiv="Content-Type" content="text/html"; charset="utf-8">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script>
			$("document").ready(function(){

				$("#mapImage").change(function() {
					alert('changed!');
				});
			});
		</script>
	</head>
	<body>
		<h2>exhibitionlist</h2>

		<!--add_exhibition_form-->
		<p>新增展場</p>
		<form action="http://10.0.1.113:80/exhibition_server/exhibition/add_exhibition.php" method="post" enctype="multipart/form-data">
				<table>
					<tr>
						<td> <label for="exhibition_name">展場名字：</label> </td>
						<td> <input id="exhibition_name" type="text" name="exhibition_name"> </td>
					</tr>
					<tr>
						<td> <label for="length">長：</label> </td>
						<td> <input id="length" type="number" name="length"> </td>
					</tr>
					<tr>
						<td> <label for="width">寬：</label> </td>
						<td> <input id="width" type="number" name="width"> </td>
					</tr>
					<tr>
						<td> <label for="mapImage">mapImage：</label> </td>
						<td> <input id="mapImage" type="file" name="mapImage"> </td>
					</tr>
					<tr>
						<td> <label for="iconImage">iconImage：</label> </td>
						<td> <input id="iconImage" type="file" name="iconImage"> </td>
					</tr>
				</table>
			<input type="submit" name="add" value="add">
		 </form>
		 
		 <!--remove_exhibition_form-->
		 <p>刪除展場</p>
		 <form action="search_exhibition.php" method="post">
				<table>
					<tr>
						<td> <label for="exhibition_name">展場名字：</label> </td>
						<td> <input id="exhibition_name" type="text" name="exhibition_name"> </td>
					</tr>
				</table>
			<input type="submit" name="remove" value="remove">
		 </form>
		
		 
			<img src = "data:image/png;base64,<?php echo $result[1][0]?>"></img>
		
	</body>
</html>