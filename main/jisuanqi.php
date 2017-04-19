<html>

	<?php
	$result = '';
//	print_r($_SERVER["REQUEST_METHOD"]);
	if(!empty($_GET)) {
		$first = $_GET["first"];
		$second = $_GET["second"];
		$result = $_GET["result"];
		$compution = $_GET["compution"];
//print_r($_GET);
		switch ($compution) {
			case 'add':
				$result = $first + $second;
				break;
			case 'subtract':
				$result = $first - $second;
				break;
			case 'multiply':
				$result = $first * $second;
				break;
			case 'divide':
				$result = $first % $second;
				break;
		}
	}
	?>


	<form method="GET" action="#"> 
		<input name="first">
		</input>
		<select name="compution">
			<option value="1">+</option>
			<option value="2">-</option>
			<option value="3">*</option>
			<option value="divide">%</option>
		</select>
		<input name="second">
		</input>
		<button>计算
		</button>
		<input name="result" value="<?php echo $result; ?>">
		</input>
	</form>


</body>

</html>