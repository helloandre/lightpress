<?php
// Routes

$app->get('/{id:[0-9]+}', '\LightPress\Controller:get');
$app->post('/create', '\LightPress\Controller:create');
$app->post('/save', '\LightPress\Controller:save');
$app->post('/delete', '\LightPress\Controller:delete');
$app->get('/', '\LightPress\Controller:index');
