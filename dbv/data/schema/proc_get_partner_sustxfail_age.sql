DROP PROCEDURE IF EXISTS `proc_get_partner_sustxfail_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_partner_sustxfail_age`
(IN P_id INT(11), IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `ac`.`name`, 
                        SUM(`vca`.`sustxfail`) AS `sustxfail` 
                    FROM `vl_partner_age` `vca` 
                    JOIN `agecategory` `ac` 
                        ON `vca`.`age` = `ac`.`subID`
                WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `vca`.`partner` = '",P_id,"' AND `vca`.`year` = '",filter_year,"' AND `vca`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vca`.`partner` = '",P_id,"' AND `vca`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ac`.`name` ORDER BY `ac`.`ID` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;