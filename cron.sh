#!/bin/bash

cd /home/an839/public_html/DCSP/link2_DCSP/DCSP_Project/

git reset --hard HEAD
LOCAL=git rev-parse HEAD
REMOTE=git ls-remote https://github.com/Ajinkya-Nawarkar/DCSP_Project.git HEAD

if ["$LOCAL" != "$REMOTE"]
then
    git checkout index_front
    git checkout .
    git pull origin index_front
fi

chmod -R 777 .
permit
