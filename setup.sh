#! /bin/bash

# js
npm install

# php
composer install

# assets
gulp build

# static site
php bootstrap.php
