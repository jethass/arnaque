<?php

/*
 * check si l'ip est dans le blacklist
 */
function isIpInBlackList($dbLink, $ip)
{
    $sth = $dbLink->prepare(ReportingFraude::checkIfIPInBlackList(trim($ip)));
    $sth->execute();
    $res = $sth->fetchAll();
    return $res[0][0] > 0;
}
