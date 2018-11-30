#!/bin/bash

<<<<<<< HEAD
cd /home/an839/public_html/DCSP/link1_DCSP/DCSP_Project/
=======
cd /home/an839/public_html/DCSP/link3_DCSP/DCSP_Project/
>>>>>>> master
git reset --hard HEAD
LOCAL=git rev-parse HEAD
REMOTE=git ls-remote https://github.com/Ajinkya-Nawarkar/DCSP_Project.git HEAD

if ["$LOCAL" != "$REMOTE"]
then
    git checkout signup_front
    git checkout .
    git pull origin signup_front
fi

chmod -R 777 .
permit
