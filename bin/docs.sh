#!/bin/bash
base=/home/ploi/laravel-mix.com-deploy
docs=${base}/storage/docs

doc_versions=(
  main
  6.0
  5.0
  4.1
  4.0
  3.0
  2.1
  2.0
  1.7
)

for v in "${doc_versions[@]}"; do
    if [ -d "$docs/$v" ]; then
        echo "Pulling latest documentation updates for $v..."
        (cd $docs/$v && git pull)
    else
        echo "Cloning $v..."
        git clone --single-branch --branch "$v" git@github.com:mvdnbrk/laravel-mix-docs.git "$docs/$v"
    fi;
done
