DROP PROCEDURE IF EXISTS `proc_get_national_gender`;
DELIMITER //
CREATE PROCEDURE `proc_get_national_gender`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `g`.`name`,
                    SUM(`vng`.`undetected`+`vng`.`less1000`) AS `suppressed`,
                    SUM(`vng`.`less5000`+`vng`.`above5000`) AS `nonsuppressed`
                FROM `vl_national_gender` `vng`
                JOIN `gender` `g`
                    ON `vng`.`gender` = `g`.`ID`
                WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `vng`.`year` = '",filter_year,"' AND `vng`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vng`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `g`.`name` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;