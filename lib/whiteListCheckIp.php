<?php

/*
 * check si l'ip est dans le whitelist
 */
function isIpInWhiteList($dbLink, $ip)
{
    $sth = $dbLink->prepare(ReportingFraude::checkIfIPInWhiteList(trim($ip)));
    $sth->execute();
    $res = $sth->fetchAll();
    return $res[0][0] > 0;
}
