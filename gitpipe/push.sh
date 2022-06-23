#!/bin/bash

echo "Enter commit message: "
read message
echo "Which branch? "
read branch

git add .
git commit -m "$message"
sleep 2
git push origin $branch