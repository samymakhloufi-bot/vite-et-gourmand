<?php 
$consent = $_GET['consent'] === 'true' ? 'true' : 'false';
setcookie('maps-consent', $consent, time() + (365 * 24 * 60 * 60), '/');