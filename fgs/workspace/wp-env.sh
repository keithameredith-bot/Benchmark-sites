# source this in git-bash to get WP-CLI working against the local FGS site (LocalWP id tSVL6lQah)
# usage:  source ~/Desktop/fgs-workspace/wp-env.sh   (then `wp ...` from anywhere)
# NOTE: site was imported into LocalWP as "FSG" (letters transposed) — folder/domain are fsg, the client is FGS.
export MYSQL_HOME="/c/Users/keith/AppData/Roaming/Local/run/tSVL6lQah/conf/mysql"
export PHPRC="/c/Users/keith/AppData/Roaming/Local/run/tSVL6lQah/conf/php"
export WP_CLI_CONFIG_PATH="/c/Program Files (x86)/Local/resources/extraResources/bin/wp-cli/config.yaml"
export WP_CLI_DISABLE_AUTO_CHECK_UPDATE=1
export PATH="/c/Users/keith/AppData/Roaming/Local/lightning-services/mysql-8.4.0/bin/win64/bin:/c/Users/keith/AppData/Roaming/Local/lightning-services/php-8.2.29+0/bin/win64:/c/Program Files (x86)/Local/resources/extraResources/bin/wp-cli/win32:$PATH"
cd "/c/Users/keith/Local Sites/fsg/app/public"
# note: FGS/FSG site must be RUNNING in LocalWP (mysql on port 10023)
# note: wp db query is broken on Windows — use `wp eval-file` for SQL
