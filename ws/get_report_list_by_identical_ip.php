<?php

require_once 'lib/DatabaseLink.php';
require_once '../repository/ReportingFraude.php';
require_once '../lib/WhiteListCheckIp.php';
require_once '../lib/BlackListCheckIp.php';

$dbLink = DatabaseLink::getInstance('w2000')->slave();

$statement = $dbLink->prepare(ReportingFraude::getSqlReportListByMailWithIdenticalIP());
$statement->execute();

$results = array();

while ($row = $statement->fetch(PDO::FETCH_NUM)) {
    $result['references'] = $row[0];
    $result['ip'] = $row[1];
    $result['mail_text_count'] = $row[2];
    $result['mail_customers'] = $row[3];
    $result['mail_content'] = utf8_encode($row[4]);
    $result['display_allow_ip_button'] = !isIpInWhiteList($dbLink, $row[1]);
    $result['display_disallow_ip_button'] = !isIpInBlackList($dbLink, $row[1]);
    $results[] = $result;
}
header('Content-Type: application/json');
echo json_encode($results);
