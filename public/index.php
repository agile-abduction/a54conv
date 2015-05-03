<?php
	require('../vendor/autoload.php');
	$Aconv = new \A54conv();
	$input = isset($_REQUEST['input']) && is_string($_REQUEST['input']) ? $_REQUEST['input'] : null;
	$output = $Aconv->convert($input);
?><!doctype html>
<html>
<head>
	<style>
		textarea { width: 90%; height: 300px; }
	</style>
</head>
<body>
	<form method="POST">
		<pre>input:</pre>
		<textarea name="input"><?= $input ?></textarea>&nbsp;<input type="submit"><br/><br/>
		<pre>output:</pre>
		<textarea><?= $output ?></textarea><br/>
	</form>
</body>
</html>
