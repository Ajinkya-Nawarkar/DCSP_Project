#!/bin/bash

cd /home/an839/public_html/DCSP/link3_DCSP/DCSP_Project/

git reset --hard HEAD
LOCAL=git rev-parse HEAD
REMOTE=git ls-remote https://github.com/Ajinkya-Nawarkar/DCSP_Project.git HEAD

if ["$LOCAL" != "$REMOTE"]
then
    git checkout fixing_master
    git checkout .
    git pull origin fixing_master
fi

chmod -R 777 .
permit
