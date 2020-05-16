<?php
if (!isset($_GET["code"])) {
	die("Hi.");
}

$code = htmlspecialchars($_GET["code"]);
$conn = mysqli_connect("localhost", "survey", "", "survey");
?>

<html>
<head>
	<style type="text/css">
		body {
			font-family: sans-serif;
		}
	</style>
</head>
<body>
	<h1>Answers for code "<?= $code ?>"</h1>
	<table border="1">
		<tr>
			<th>Step number</th>
			<th>Answer</th>
			<th>Start time</th>
			<th>End time</th>
		</tr>
		<?php
		$result = mysqli_query($conn, "select * from answers where code = '$code' order by startTime");
		while($row = mysqli_fetch_assoc($result)): ?>
			<tr>
				<td><?= $row['step'] ?></td>
				<td><?= $row['answer'] ?></td>
				<td><?= $row['startTime'] ?></td>
				<td><?= $row['endTime'] ?></td>
			</tr>
		<?php
		endwhile;

		?>
	</table>
</body>
</html>


<?php mysqli_close($conn); ?>