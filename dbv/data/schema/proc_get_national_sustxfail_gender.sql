DROP PROCEDURE IF EXISTS `proc_get_national_sustxfail_gender`;
DELIMITER //
CREATE PROCEDURE `proc_get_national_sustxfail_gender`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `gn`.`name`, 
                        SUM(`vng`.`sustxfail`) AS `sustxfail` 
                    FROM `vl_national_gender` `vng` 
                    JOIN `gender` `gn` 
                        ON `vng`.`gender` = `gn`.`ID`
                WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `vng`.`year` = '",filter_year,"' AND `vng`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vng`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `gn`.`name` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;