<?php

require_once 'lib/DatabaseLink.php';
require_once '../repository/ReportingFraude.php';

$dbLink = DatabaseLink::getInstance('w2000')->slave();
$outputResult = array('success' => true, 'error' => '');

$statementCheckIP = $dbLink->prepare(ReportingFraude::checkIfIPInWhiteList($_POST['allowedIp']));
$statementCheckIP->execute();
$queryResult = $statementCheckIP->fetch();

if ($queryResult[0] == 0) {
    $statementWhiteListIP = $dbLink->prepare(ReportingFraude::addIpInWhiteList($_POST['allowedIp']));
    $requestSuccess = $statementWhiteListIP->execute();
    if (!$requestSuccess){
        $outputResult['error'] = 'Database error: Insertion failed';
        $outputResult['success'] = false;
    }
}

header('Content-Type: application/json');
echo json_encode($outputResult);

