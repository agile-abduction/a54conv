<?php

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Validator\Validator;

require('../vendor/autoload.php');

try {

	$Aconv = new \A54conv();

	$App = new Silex\Application();

	$App->register(new Silex\Provider\TwigServiceProvider(), array(
		'twig.path' => __DIR__.'/../views',
	));

	$App->get(
		'/convert',
		function() use ($App) {
			return $App['twig']->render('convert.twig');
		}
	);

	$App->post(
		'/convert',
		function(Request $Request) use ($App, $Aconv) {

			$secret = $Request->get('secret');
			$input = $Request->get('input');

			// change this structure to get a meaningful, aggregating error structure
			// (eg. it can display both errors if secret and input are both empty)

			if (!Validator::validate('string', $secret)) {
				throw new ValidatorException('not a string!');
			}
			elseif (empty($secret)) {
				throw new Exception('must supply a secret key');
			}
			elseif (!Validator::validate('string', $input)) {
				throw new ValidatorException('not a string!');
			}
			elseif (!validate('required', $input)) {
				return new Response('input cannot be empty');
			}

			$result = $Aconv->convert('asd');
			// this error response is duplicated for sure. which shall remain?
			if (is_null($result)) {
				return new Response('input cannot be empty');
			}

			return new Response(
				json_encode(['success'=>1, 'result'=>$result])
			);
		});

	// there's a simple error here!
	$App->get(
		'/README',
		function() use ($App, $Aconv) {
			// this gives a bad error (or blank page), find the problem by error handling
			// (easy to find by code analysis but not the point now)
			// it would be nice to integrate the error handling with the other routes!!!
			return '<pre>' . file_get_contents('../readme.md');
		}
	);

	$App->run();

}
catch (\Exception $e) {
	// why I don't end up here??
	die ('oops: ' . $e->getMessage());
}
