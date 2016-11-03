DROP PROCEDURE IF EXISTS `proc_get_partner_sites_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_partner_sites_outcomes`
(IN P_id INT(11), IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `view_facilitys`.`name`, 
                    SUM(`vl_site_summary`.`undetected`+`vl_site_summary`.`less1000`) AS `suppressed`,
                    SUM((`vl_site_summary`.`less5000`)+(`vl_site_summary`.`above5000`) AS `nonsuppressed` LEFT JOIN `view_facilitys` ON `vl_site_summary`.`facility` = `view_facilitys`.`ID` WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `view_facilitys`.`partner` = '",P_id,"' AND `year` = '",filter_year,"' AND `month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `view_facilitys`.`partner` = '",P_id,"' AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `view_facilitys`.`ID` ORDER BY `tests` DESC LIMIT 0, 50 ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;