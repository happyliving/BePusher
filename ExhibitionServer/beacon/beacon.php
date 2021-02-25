<!DOCTYPE = html>
<html>
	<head>
		<title>beacon</title>
		<meta http-equiv="Content-Type" content="text/html"; charset="utf-8">
	</head>
	<body>
		<h2>beaconlist</h2>

		<!--add_beacon_form-->
		<p>新增推播</p>
		<form action="add_beacon.php" method="post">
				<table>
					<tr>
						<td> <label for="exhibition_name">展場名字：</label> </td>
						<td> <input id="exhibition_name" type="text" name="exhibition_name"> </td>
					</tr>
					<tr>
						<td> <label for="beacon_name">beacon名字：</label> </td>
						<td> <input id="beacon_name" type="text" name="beacon_name"> </td>
					</tr>
					<tr>
						<td> <label for="uuid">uuid：</label> </td>
						<td> <input id="uuid" type="text" name="uuid"> </td>
					</tr>
					<tr>
						<td> <label for="major">major：</label> </td>
						<td> <input id="major" type="number" name="major"> </td>
					</tr>
					<tr>
						<td> <label for="minor">minor：</label> </td>
						<td> <input id="minor" type="number" name="minor"> </td>
					</tr>
					<tr>
						<td> <label for="posX">posX：</label> </td>
						<td> <input id="posX" type="number" name="posX"> </td>
					</tr>
					<tr>
						<td> <label for="posY">posY：</label> </td>
						<td> <input id="posY" type="number" name="posY"> </td>
					</tr>
					<tr>
						<td> <label for="posZ">posZ：</label> </td>
						<td> <input id="posZ" type="number" name="posZ"> </td>
					</tr>
				</table>
			<input type="submit" name="add" value="add">
		 </form>
		 
		 <!--remove_broadcast_form-->
		 <p>刪除展場</p>
		 <form action="remove_beacon.php" method="post">
				<table>
					<tr>
						<td> <label for="beacon_name">beacon名字：</label> </td>
						<td> <input id="beacon_name" type="text" name="beacon_name"> </td>
					</tr>
				</table>
			<input type="submit" name="remove" value="remove">
		 </form>
		 
	</body>
</html>