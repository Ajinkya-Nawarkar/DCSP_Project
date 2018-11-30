#!/bin/bash


cd /home/an839/public_html/DCSP/link3_DCSP/DCSP_Project/

git reset --hard HEAD
LOCAL=git rev-parse HEAD
REMOTE=git ls-remote https://github.com/Ajinkya-Nawarkar/DCSP_Project.git HEAD

if ["$LOCAL" != "$REMOTE"]
then
    git checkout db_login_signup
    git checkout .
    git pull origin db_login_signup
fi

chmod -R 777 .
permit
