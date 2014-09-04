<?php
define('CB_API_KEY','YOUR API KEY HERE');

require_once 'clientobox.php';

try {
    $clientoBox = new Clientobox(CB_API_KEY);

    //Get list of organizations
    $orgList = $clientoBox->exec('org', 'list', array('limit'=>100));
    echo "List of organizations:<br><pre>".print_r($orgList,true)."</pre>";

} catch (Exception $e) {
    echo 'ERROR: '.$e->getMessage();
}