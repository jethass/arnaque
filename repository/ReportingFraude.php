<?php

class ReportingFraude
{
    public static function getSqlReportListByIdenticalMailType()
    {
        $sql = <<<SQL
            select
                distinct w_ve.it_reference, ve_immat, ad_phone1, count(mail_id),
                GROUP_CONCAT(distinct mail_email SEPARATOR '; '), mail_text total
            from w2000.w_mail, w2000.w_ve
            where
                ve_published='1' and CHAR_LENGTH(mail_text) > 15 and ve_b2b = '0'
                and mail_site = 'D' and w_ve.it_reference = w_mail.it_reference
            group by w_mail.MAIL_TEXT HAVING count(distinct mail_id)> 7
            order by count(mail_id) desc
SQL;
        return $sql;
    }

    public static function getSqlReportListByMailWithIdenticalIP()
    {
        $sql = <<<SQL
            select
                distinct GROUP_CONCAT(distinct w_ve.it_reference SEPARATOR ', '),
                GROUP_CONCAT(distinct mail_IP SEPARATOR ', '), count(mail_text),
                GROUP_CONCAT(distinct mail_email SEPARATOR '; ') as 'Personnes a prevenir',
                mail_text
            from w2000.w_mail, w2000.w_ve
            where
                ve_published='1' and w_ve.it_reference not like 'T%' and ve_b2b='0'
                and mail_site='D' and w_ve.it_reference = w_mail.it_reference
                and (
                    mail_text like '%votre cour%ier% %lectronique%'
                    or mail_text like '%votre adre%se de mes%agerie%'
                    or mail_text like '%mail%'
                )
            group by w_mail.mail_IP HAVING COUNT(MAIL_TEXT) > 5
            order by count(mail_IP) desc
SQL;
        return $sql;
    }

    public static function getSqlReportListByInvalidIP()
    {
        $sql = <<<SQL
            select
                distinct GROUP_CONCAT(distinct w_ve.it_reference SEPARATOR ', '),
                w_tin.TR_IP
            from w2000.w_tin, w2000.w_ve
            where
                ve_published = '1'
                and w_ve.it_reference not like 'T%' and ve_b2b = '0'
                and w_ve.cu_id = w_tin.cu_id
                and (TR_IP not like '10.42.%' and TR_IP not like '194.250.98.243' and TR_IP not like '81.255.178.243')
            group by w_tin.TR_IP HAVING COUNT(distinct w_ve.IT_REFERENCE) > 3
            order by count(w_ve.IT_REFERENCE) desc
SQL;
        return $sql;
    }

    public static function getSqlReportListByInvalidContent()
    {
        $sql = <<<SQL
            select
                ve.it_reference,
                mail_ip,
                m.num,
                GROUP_CONCAT(distinct mail_email SEPARATOR '; '),
                m.mail_text
            from
                (
                    select cu_id, it_reference, mail_ip, mail_email, count(mail_text) as num, mail_text
                    from w_mail
                    where mail_site = 'D'
                    and (mail_text like '%votre cour%ier% %lectronique%' or mail_text like '%votre adre%se de mes%agerie%' or mail_text like '%mail%')
                    and it_reference not like 'T%'
                    group by mail_text, cu_id
                    having count(mail_text)> 5
                ) m,
                w_ve ve
            where
                m.cu_id = ve.cu_id
                and ve_published = 1
                and ve_b2b = '0'
                and ve.it_reference not like 'T%'
            group by it_reference
            order by num desc
SQL;
        return $sql;
    }

    public static function checkIfIPInWhiteList($ip)
    {
        $sql ="SELECT count(*) 
               FROM w2000.w_ip_ok 
               WHERE start = '" . $ip . "' OR  end = '" . $ip . "'";

        return $sql;
    }

    public static function addIpInWhiteList($ip){
        $longIp=ip2long($ip);
        $sql ="INSERT INTO w2000.w_ip_ok
               (`start`,`end`,`long_start`,`long_end`)
                VALUES
               ('".$ip."','".$ip."',$longIp,$longIp)";
        return $sql;
    }
}
