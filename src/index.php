<?php

$questions = [
	"1" => [
		"title" => "Which of the following is a valid execution?",
		"img" => "img/Trial_Andrea_Server_01",
		"answers" => ["A,B,E,C", "B,E,C,", "A,B,E,D"],
		"nextStep" => "NASA-TLX"
	],

	"NASA-TLX" => [
		"title" => "NASA-TLX Questionnaire"
		"nextStep" => "2"
	]

	"2" => [
		"title" => "Mental Demand - How mentally demanding was the task??",
		"answers" => ["0%-25%", "25%-50%","50%-75%","75%-100%"],
		"nextStep" => "3"
	],
	"3" => [
		"title" => "Physical Demand - How physically demanding was the task??",
		"answers" => ["0%-25%", "25%-50%","50%-75%","75%-100%"],
		"nextStep" => "4"
	],
	"4" => [
		"title" => "Temporal Demand - How hurried or rushed was the pace of the task?",
		"answers" => ["0%-25%", "25%-50%","50%-75%","75%-100%"],
		"nextStep" => "5"
	],
	"5" => [
		"title" => "Performance - How successful were you in accomplishing what you were asked to do?",
		"answers" => ["0%-25%", "25%-50%","50%-75%","75%-100%"],
		"nextStep" => "6"
	],
	"6" => [
		"title" => "Effort - How hard did you have to work to accomplish your level of performance?",
		"answers" => ["0%-25%", "25%-50%","50%-75%","75%-100%"],
		"nextStep" => "7"
	],
	"7" => [
		"title" => "Frustration - How insecure, discouraged, irritated, stressed, and annoyed were you?",
		"answers" => ["0%-25%", "25%-50%","50%-75%","75%-100%"],
		"nextStep" => "end"
	],			

	"end" => [
		"title" => "Thanks for participating in the survey!"
	]
];

if (isset($_GET["answer"])) {
	$code = htmlspecialchars($_POST["code"]);
	$step = htmlspecialchars($_POST["step"]);
	$answer = htmlspecialchars($_POST["answer"]);
	$startTime = htmlspecialchars($_POST["startTime"]);

	$conn = mysqli_connect("localhost", "survey", "", "survey");
	mysqli_query($conn, "insert into answers(code, step, answer, startTime, endTime) values ('$code', '$step', '$answer', '$startTime', now())");
	mysqli_close($conn);

	header("location: ?code=". htmlspecialchars($code) ."&step=" . $questions[$step]["nextStep"]);
}

if (isset($_GET["code"]) && ! isset($_GET["step"])) {
	header("location: ?code=". htmlspecialchars($_GET["code"]) ."&step=1");
}

if (!isset($_GET["code"]) || ! isset($_GET["step"])) {
	die("Hi.");
}

$code = htmlspecialchars($_GET["code"]);
$step = $_GET["step"];

$conn = mysqli_connect("localhost", "survey", "", "survey");
$result = mysqli_query($conn, "select * from answers where code = '$code' and step = '$step'");
$answers_for_this_code = mysqli_num_rows($result);
mysqli_close($conn);
if ($answers_for_this_code > 0) {
	die("Answers already provided.");
}

if ($step == "end"):
?>
<html>
<head>
	<style type="text/css">
		body {
			font-family: sans-serif;
			text-align: center;
		}
	</style>
</head>
<body>
	<h1 style="margin-top: 5em"><?= $questions[$step]["title"] ?></h1>
	<p>It is now possible to close this window.</p>
</body>
</html>

<?php

else:

$step = $step;
?>
<html>
<head>
	<style type="text/css">
		body {
			font-family: sans-serif;
			text-align: center;
		}
		input {
			-ms-transform: scale(1.5); /* IE 9 */
			-webkit-transform: scale(1.5); /* Chrome, Safari, Opera */
			transform: scale(1.5);
		}
		label {
			font-size: 1.5em;
		}
	</style>

	<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("input:radio").change(function () {
				$("#submitButton").prop("disabled", false);
			});
		});
	</script>
</head>
<body>
	<h1><?= $questions[$step]["title"] ?></h1>
	<img src="<?= $questions[$step]["img"] ?>" />
	<form method="POST" action="?answer">
		<input type="hidden" name="code" value="<?= $code ?>" />
		<input type="hidden" name="step" value="<?= $step ?>" />
		<input type="hidden" name="startTime" value="<?= date("Y-m-d H:i:s") ?>" />
		<div style="text-align: left; width: 50%; margin: 2em auto;">
		<?php foreach ($questions[$step]["answers"] as $a): ?>
			<label><input type="radio" name="answer" value="<?= $a ?>"> <?= $a ?></label><br>
		<?php endforeach; ?>
		</div>
		<input type="submit" id="submitButton" disabled="disabled" />
	</form>
</body>
</html>
<?php endif; ?>