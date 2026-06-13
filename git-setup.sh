#!/bin/bash
cd /c/Users/keith/benchmark-sites || exit 1
git config user.name "Keith Meredith"
git config user.email "keithameredith@gmail.com"
git add -A
git commit -q -m "initial import: JSC, Tire Express, FGS, Black Rock workspaces + child theme + mu-plugins"
echo "commit exit: $?"
git log --oneline -1
echo "files tracked: $(git ls-files | wc -l)"
