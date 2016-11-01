DROP PROCEDURE IF EXISTS `proc_get_national_sustxfail_sampletypes`;
DELIMITER //
CREATE PROCEDURE `proc_get_national_sustxfail_sampletypes`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `vsd`.`name`, 
                        SUM(`vns`.`sustxfail`) AS `sustxfail` 
                    FROM `vl_national_sampletype` `vns` 
                    JOIN `viralsampletypedetails` `vsd` 
                        ON `vns`.`sampletype` = `vsd`.`ID`
                WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `vns`.`year` = '",filter_year,"' AND `vns`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vns`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vsd`.`name` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;