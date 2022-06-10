PATH_PWD=$(pwd)

sleep 5;

/usr/local/bin/php $PATH_PWD/saveEnv.php
/usr/local/bin/php $PATH_PWD/spark migrate


echo "ok";

exit;