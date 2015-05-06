<?php

use Symfony\Component\HttpFoundation\Response;

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
			function() use ($App, $Aconv) {
				return new Response(
					json_encode(['success'=>1, 'result'=>$Aconv->convert('asd')])
				);
			}
		);

		$App->get(
			'/README',
			function() use ($App, $Aconv) {
				// this gives a bad error
				return '<pre>' . file_get_contents('../readme.md');
			}
		);

		$App->run();

	}
	catch (\Exception $e) {
		// why I don't end up here??
		die ('oops: ' . $e->getMessage());
	}
