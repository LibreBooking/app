<?php
define('ROOT_DIR', '../../');
require_once(ROOT_DIR . 'Domain/Access/namespace.php' );

$r = new UserRepository();
$r->GetList(1, 100);

echo json_encode($r->GetList(1, 100)->Results());
?>
