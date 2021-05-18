<?php

Route::post(config('laradeploy.routes.github'), 'LaraDeployController@githubDeploy');
