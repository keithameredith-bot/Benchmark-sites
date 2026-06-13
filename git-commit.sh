#!/bin/bash
# helper: sync is done by sync-to-repo.ps1; this stages/commits/pushes with a message arg
cd /c/Users/keith/benchmark-sites || exit 1
git add -A
git commit -q -m "${1:-sync: workspace updates}"
echo "commit: $?"
git push -q origin main
echo "push: $?"
git log --oneline -1
