DROP PROCEDURE IF EXISTS `proc_get_regional_age`;
DELIMITER //
CREATE PROCEDURE `proc_get_regional_age`
(IN C_id INT(11), IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `ac`.`name`, 
                    SUM(`vca`.`tests`) AS `agegroups`, 
                    SUM(`vca`.`undetected`+`vca`.`less1000`) AS `suppressed`,
                    SUM(`vca`.`less5000`+`vca`.`above5000`) AS `nonsuppressed`
                FROM `vl_county_age` `vca`
                JOIN `agecategory` `ac`
                    ON `vca`.`age` = `ac`.`ID`
                WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `vca`.`county` = '",C_id,"' AND `vca`.`year` = '",filter_year,"' AND `vca`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vca`.`county` = '",C_id,"' AND `vca`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `ac`.`ID` ORDER BY `ac`.`ID` ASC ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;