PATH_PWD=$(pwd)

/usr/local/bin/php $PATH_PWD/saveEnv.php
/etc/init.d/supervisor start

echo "ok";

exit;