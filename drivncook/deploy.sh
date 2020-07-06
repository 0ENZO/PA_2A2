#!/bin/sh

rsync -av -e 'ssh -p 37802' ./ rpierucci@drivncook.space:/var/www/www.drivncook.space --include=public/build --exclude-from=.gitignore --exclude=".*"