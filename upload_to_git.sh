#!/usr/bin/env bash

echo "Adding all files to git"
git add -A
echo "Commiting files"
git commit -m "magic"
echo "pushing to github"
git push -u origin main
echo "files added successfully"