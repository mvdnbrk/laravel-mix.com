#!/bin/bash
base=/home/forge/laravel-mix.com
docs=${base}/storage/docs

cd ${docs}/1.7 && git pull origin 1.7
cd ${docs}/2.0 && git pull origin 2.0
cd ${docs}/2.1 && git pull origin 2.1
cd ${docs}/master && git pull origin master

cd $base && php artisan page-cache:clear
