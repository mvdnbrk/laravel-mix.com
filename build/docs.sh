#!/bin/bash
base=/home/forge/laravel-mix.com
docs=${base}/storage/docs

cd ${docs}/1.7 && git pull origin 1.7
cd ${docs}/2.0 && git pull origin 2.0
cd ${docs}/2.1 && git pull origin 2.1
cd ${docs}/3.0 && git pull origin 3.0
cd ${docs}/4.0 && git pull origin 4.0
cd ${docs}/4.1 && git pull origin 4.1
cd ${docs}/master && git pull origin master

cd ${base}/current && php artisan page-cache:clear
