DROP PROCEDURE IF EXISTS `proc_get_national_sustxfail_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_national_sustxfail_age`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `ac`.`name`, 
                        SUM(`vna`.`sustxfail`) AS `sustxfail` 
                    FROM `vl_national_age` `vna` 
                    JOIN `agecategory` `ac` 
                        ON `vna`.`age` = `ac`.`subID`
                WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `vna`.`year` = '",filter_year,"' AND `vna`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vna`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ac`.`name` ORDER BY `ac`.`ID` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;