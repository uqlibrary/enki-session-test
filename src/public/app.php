<?php
require_once '../vendor/autoload.php';

require_once '../includes/SessionHandler.php';

require_once '../includes/config.php';
require_once '../includes/common1.php';

echo "SESSION:";
dump($_SESSION);

echo "COOKIE:";
dump($_COOKIE);

?>
