<?php

require_once 'lib/DatabaseLink.php';
require_once '../repository/ReportingFraude.php';

$dbLink = DatabaseLink::getInstance('w2000')->slave();

$dbLink->exec('SET SESSION group_concat_max_len = 1000000;');

$statement = $dbLink->prepare(ReportingFraude::getSqlReportListByInvalidContent());
$statement->execute();

$results = array();

while ($row = $statement->fetch(PDO::FETCH_NUM)) {
    $result['references'] = $row[0];
    $result['ips'] = $row[1];
    $result['mail_count'] = $row[2];
    $result['mail_customers'] = $row[3];
    $result['mail_content'] = str_replace('{newline}', '<br /><br />', htmlentities($row[4]));

    $results[] = $result;
}

header('Content-Type: application/json');

echo json_encode($results);
