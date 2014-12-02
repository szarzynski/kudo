<?php

$app->hook('slim.before', function () use ($app) {

	$appLang = array(

		'lang' => array(

			'login' => array(

				'header' => 'Logowanie',
				'username' => 'Nazwa użytkownika',
				'password' => 'Hasło',
				'submit' => 'Zaloguj'

			)

		)

	);

	$app->view->appendData($appLang);

});