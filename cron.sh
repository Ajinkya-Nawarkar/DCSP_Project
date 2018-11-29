#!/bin/bash

cd /home/an839/public_html/DCSP/DCSP_Project/
git checkout index_front
git reset --hard HEAD
LOCAL=git rev-parse HEAD
REMOTE=git ls-remote https://github.com/Ajinkya-Nawarkar/DCSP_Project/tree/index_front HEAD

if ["$LOCAL" != "$REMOTE"]
then
    git pull origin index_front
fi

chmod -R 777 .
permit
