# source this in git-bash to get WP-CLI working against the local Tire Express site (LocalWP id 1FkoTj42H)
# usage:  source ~/Desktop/tire-express-workspace/wp-env.sh   (then `wp ...` from anywhere)
export MYSQL_HOME="/c/Users/keith/AppData/Roaming/Local/run/1FkoTj42H/conf/mysql"
export PHPRC="/c/Users/keith/AppData/Roaming/Local/run/1FkoTj42H/conf/php"
export WP_CLI_CONFIG_PATH="/c/Program Files (x86)/Local/resources/extraResources/bin/wp-cli/config.yaml"
export WP_CLI_DISABLE_AUTO_CHECK_UPDATE=1
export PATH="/c/Users/keith/AppData/Roaming/Local/lightning-services/mysql-8.4.0/bin/win64/bin:/c/Users/keith/AppData/Roaming/Local/lightning-services/php-8.2.29+0/bin/win64:/c/Program Files (x86)/Local/resources/extraResources/bin/wp-cli/win32:$PATH"
cd "/c/Users/keith/Local Sites/tire-express/app/public"
# note: Tire Express site must be running in LocalWP (mysql on port 10005)
# note: wp db query is broken on Windows — use `wp eval-file` for SQL (same as JSC)
