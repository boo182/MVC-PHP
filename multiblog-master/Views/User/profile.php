<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<ul>
<?php


foreach ($display[0] as $key => $value) {

	echo "<li>".$key.": ".$value."</li>";
}

?>
</ul>
</body>
</html>