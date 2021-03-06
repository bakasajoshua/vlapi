DROP PROCEDURE IF EXISTS `proc_get_partner_justification`;
DELIMITER //
CREATE PROCEDURE `proc_get_partner_justification`
(IN P_id INT(11), IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `vj`.`name`,
                    SUM((`vnj`.`tests`)) AS `justifications`
                FROM `vl_partner_justification` `vnj`
                JOIN `viraljustifications` `vj` 
                    ON `vnj`.`justification` = `vj`.`ID`
                WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `vnj`.`partner` = '",P_id,"' AND `vnj`.`year` = '",filter_year,"' AND `vnj`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vnj`.`partner` = '",P_id,"' AND `vnj`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vj`.`name` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;