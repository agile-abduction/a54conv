<?php
	require('../vendor/autoload.php');
	$Aconv = new \A54conv();

	$inputs =
	[
		[
			'a' => null,
			'b' => 0,
			'c' => -1,
			'd' => [1,2,3,4],
		],
		array(
			'success' => true,'result' => null,
		),
		[
			'success' => false,
			'errors' => [
				'field' => ['error-1','error-2',],
			],
		],
	];
//var_export($inputs); die;
?><!doctype html>
<html>
<head>
	<style>
		textarea { width: 90%; height: 300px; }
	</style>
</head>
<body>
<ul>
	<?php foreach($inputs as $eachInput): ?>
	<li>
		<pre><?= $Aconv->convert(var_export($eachInput, 1)) ?></pre>
	</li>
	<?php endforeach; ?>
</ul>
</body>
</html>

