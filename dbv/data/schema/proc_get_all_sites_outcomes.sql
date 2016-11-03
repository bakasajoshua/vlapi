DROP PROCEDURE IF EXISTS `proc_get_all_sites_outcomes`;
DELIMITER //
CREATE PROCEDURE `proc_get_all_sites_outcomes`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                    `vf`.`name`, 
                    SUM((`vss`.`Undetected`+`vss`.`less1000`)) AS `suppressed`, 
                    SUM(`vss`.`sustxfail`) AS `nonsuppressed` 
                  FROM `vl_site_summary` `vss` 
                  LEFT JOIN `view_facilitys` `vf` 
                    ON `vss`.`facility` = `vf`.`ID`
    WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' AND `month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vss`.`facility` ORDER BY `suppressed` DESC LIMIT 0, 50 ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;