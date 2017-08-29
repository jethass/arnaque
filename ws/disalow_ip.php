<?php

require_once 'lib/DatabaseLink.php';
require_once '../repository/ReportingFraude.php';

$dbLink = DatabaseLink::getInstance('w2000')->slave();
$outputResult = array('success' => true, 'error' => '');

$statementCheckIP = $dbLink->prepare(ReportingFraude::checkIfIPInBlackList($_POST['disallowedIp']));
$statementCheckIP->execute();
$queryResult = $statementCheckIP->fetch();

if ($queryResult[0] == 0) {

    $statementDeleteFromWhiteList = $dbLink->prepare(ReportingFraude::deleteIpFromWhiteList($_POST['disallowedIp']));
    $statementDeleteFromWhiteList->execute();
    
    $statementBlackListIP = $dbLink->prepare(ReportingFraude::addIpInBlackList($_POST['disallowedIp']));
    $requestSuccess = $statementBlackListIP->execute();
    if (!$requestSuccess){
        $outputResult['error'] = 'Database error: Insertion failed';
        $outputResult['success'] = false;
    }
}

header('Content-Type: application/json');
echo json_encode($outputResult);

