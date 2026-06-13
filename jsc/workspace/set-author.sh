#!/bin/bash
# Reassign all posts + pages to Alex Scanlan (user 12). Idempotent.
source /c/Users/keith/Desktop/jsc-kadence-mockup/wp-env.sh

ids=$(wp post list --post_type=post --post_status=any --format=ids 2>/dev/null | tr -cs '0-9' ' ')
echo "POST IDS: $ids"
wp post update $ids --post_author=12 2>/dev/null | grep -c Success

pids=$(wp post list --post_type=page --post_status=any --format=ids 2>/dev/null | tr -cs '0-9' ' ')
echo "PAGE COUNT: $(echo $pids | wc -w)"
wp post update $pids --post_author=12 2>/dev/null | grep -c Success

echo "--- verify ---"
wp post list --post_type=post --post_status=any --fields=ID,post_author --format=csv 2>/dev/null | grep -E '^[0-9]'
wp post list --post_type=page --post_status=any --fields=post_author --format=csv 2>/dev/null | grep -E '^[0-9]' | sort | uniq -c
