<!DOCTYPE = html>
<html>
	<head>
		<title>broadcast</title>
		<meta http-equiv="Content-Type" content="text/html"; charset="utf-8">
	</head>
	<body>
		<h2>broadcastlist</h2>

		<!--add_broadcast_form-->
		<p>新增推播</p>
		<form action="update_broadcast.php" method="post"  enctype="multipart/form-data">
				<table>
					<tr>
						<td> <label for="exhibition_name">推播名字：</label> </td>
						<td> <input id="exhibition_name" type="text" name="exhibition_name"> </td>
					</tr>
					<tr>
						<td> <label for="vendorID">ID：</label> </td>
						<td> <input id="vendorID" type="text" name="vendorID"> </td>
					</tr>
					<tr>
						<td> <label for="broadcastImage1">圖片1：</label> </td>
						<td> <input id="broadcastImage1" type="file" name="broadcastImage1"> </td>
					</tr>
					<tr>
						<td> <label for="broadcastImage2">圖片2：</label> </td>
						<td> <input id="broadcastImage2" type="file" name="broadcastImage2"> </td>
					</tr>
					<tr>
						<td> <label for="broadcastImage3">圖片3：</label> </td>
						<td> <input id="broadcastImage3" type="file" name="broadcastImage3"> </td>
					</tr>
					<tr>
						<td> <label for="title">標題：</label> </td>
						<td> <input id="title" type="text" name="title"> </td>
					</tr>
					<tr>
						<td> <label for="info">訊息：</label> </td>
						<td> <input id="info" type="text" name="info"> </td>
					</tr>
					<tr>
						<td> <label for="url">url：</label> </td>
						<td> <input id="url" type="text" name="url"> </td>
					</tr>
					<tr>
						<td> <label for="fb_url">fb_url：</label> </td>
						<td> <input id="fb_url" type="text" name="fb_url"> </td>
					</tr>
					<tr>
						<td> <label for="twitter_url">標題：</label> </td>
						<td> <input id="twitter_url" type="text" name="twitter_url"> </td>
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
		 <form action="remove_broadcast.php" method="post">
				<table>
					<tr>
						<td> <label for="broadcast_name">推播名字：</label> </td>
						<td> <input id="broadcast_name" type="text" name="broadcast_name"> </td>
					</tr>
				</table>
			<input type="submit" name="remove" value="remove">
		 </form>
		 
		 
	</body>
</html>