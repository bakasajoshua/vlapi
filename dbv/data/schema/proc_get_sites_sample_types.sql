DROP PROCEDURE IF EXISTS `proc_get_sites_sample_types`;
DELIMITER //
CREATE PROCEDURE `proc_get_sites_sample_types`
(IN S_id INT(11), IN filter_year INT(11))
BEGIN
  SET @QUERY =    "SELECT
					`month`,
					`year`,
					SUM(`edta`) AS `edta`,
 					SUM(`dbs`) AS `dbs`,
 					SUM(`plasma`) AS `plasma`
				FROM `vl_site_summary`
                WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `facility` = '",S_id,"' AND `year` = '",filter_year,"' GROUP BY `year`, `month` ORDER BY `year` ASC, `month` ");
    
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;