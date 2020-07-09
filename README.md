
# POS

## Table of contents
* [General info](#general-info)
* [Technologies](#technologies)
* [Setup](#setup)

## General info
Point of Sale System.

## Branches
* master -> With the feature to connect to the inventory and accounting system
* prod -> stand-alone POS System
	
## Technologies
Project is created with:
* Laravel 7
* Vue.js
	
## Setup
To run this project, follow the steps below:

```
$ cd portfolio
$ cp .env.example .env
$ composer install 
$ php artisan storage:link
$ php artisan passport:keys
$ php artisan key:generate
$ php artisan passport:install --force
$ npm install *
$ npm run watch
```
