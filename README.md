# Bitpacman

Faucet with pacman game in js where you get shatoshis every time you eat a dot or a ghost.

## Features

- Protection against network bots, banning network segments and full networks given a network ID. It connects to Hurricane Electronic to check all segments of a network.

- Open to another apis which implements micropayments.

## Installation

Rename and modify with correct environment constants the file .env.local to .env
Make the sessions folder in storage/framework/sessions
Update Bower, Node y Composer:

bower install
npm install
composer install

Launch Laravel migrations

php artisan migrate

Util:
ssh-copy-id username@hostname.com
