<?php

	require('../vendor/autoload.php');

	try {
		$Aconv = new \A54conv();
		$input = isset($_REQUEST['input']) && is_string($_REQUEST['input']) ? $_REQUEST['input'] : null;
		$output = $Aconv->convert($input);
	}
	catch (\Exception $e) {
		// why I don't end up here??
		die ('oops: ' . $e->getMessage());
	}

?><!doctype html>
<html>
<head>
	<style>
		textarea { width: 90%; height: 300px; }
	</style>
	<script type="text/javascript">
var testStr = "\narray (\n		0 =>\n		array (\n			'a' => NULL,\n			'b' => 0,\n			'c' => -1,\n			'd' =>\n		array (\n\
			0 => 1,\n			1 => 2,\n			2 => 3,\n			3 => 4,\n		),\n		),\n		1 =>\n		array (\n			'success' => true,\n\
			'result' => NULL,\n		),\n		2 =>\n		array (\n			'success' => false,\n			'errors' =>\n		array (\n			'field' =>\n\
			array (\n				0 => 'error-1',\n			1 => 'error-2',\n		),\n		),\n	),\n)\n\
";

	</script>
</head>
<body>
	<form method="POST">
		<input type="button" onclick="document.getElementById('textarea-in').value=testStr" value="set test input">
		<pre>input:</pre>
		<textarea name="input" id="textarea-in"><?= $input ?></textarea>&nbsp;<input type="submit"><br/><br/>
		<pre>output:</pre>
		<textarea><?= $output ?></textarea><br/>
	</form>
</body>
</html>
