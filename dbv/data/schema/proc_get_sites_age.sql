DROP PROCEDURE IF EXISTS `proc_get_sites_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_sites_age`
(IN S_id INT(11), IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT  
                      SUM(`less2`) AS `less2`, 
                      SUM(`less9`) AS `less9`, 
                      SUM(`less14`) AS `less14`, 
                      SUM(`less19`) AS `less19`, 
                      SUM(`less24`) AS `less24`, 
                      SUM(`over25`) AS `over25` 
                FROM `vl_site_summary` `vss`
                WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `vss`.`facility` = '",S_id,"' AND `vss`.`year` = '",filter_year,"' AND `vss`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vss`.`facility` = '",S_id,"' AND `vss`.`year` = '",filter_year,"' ");
    END IF;

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;