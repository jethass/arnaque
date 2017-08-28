<?php

require_once 'lib/DatabaseLink.php';
require_once '../repository/ReportingFraude.php';

$dbLink = DatabaseLink::getInstance('w2000')->slave();

$statement = $dbLink->prepare(ReportingFraude::getSqlReportListByIdenticalMailType());
$statement->execute();

$results = array();

while ($row = $statement->fetch(PDO::FETCH_NUM)) {
    $result['reference'] = $row[0];
    $result['immat'] = $row[1];
    $result['phone'] = $row[2];
    $result['mail_count'] = $row[3];
    $result['mail_customers'] = $row[4];
    $result['mail_content'] = utf8_encode($row[5]);

    $results[] = $result;
}

header('Content-Type: application/json');

echo json_encode($results);
