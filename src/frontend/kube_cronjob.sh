PATH_PWD=$(pwd)

sleep 3;

/usr/local/bin/php $PATH_PWD/saveEnv.php
/usr/local/bin/php $PATH_PWD/spark crontab:run && while pgrep php > /dev/null; do sleep 1; done

echo "ok";

exit;