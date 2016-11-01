DROP PROCEDURE IF EXISTS `proc_get_partner_justification_breakdown`;
DELIMITER //
CREATE PROCEDURE `proc_get_partner_justification_breakdown`
(IN justification INT(11), IN P_id INT(11), IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        SUM(`Undetected`) AS `Undetected`,
                        SUM(`less1000`) AS `less1000`, 
                        SUM(`less5000`) AS `less5000`,
                        SUM(`above5000`) AS `above5000`
                    FROM `vl_partner_justification` 
                    WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `year` = '",filter_year,"' AND `month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `partner` = '",P_id,"' AND `year` = '",filter_year,"' ");
    END IF;
    
    SET @QUERY = CONCAT(@QUERY, " AND `justification` = '",justification,"' ");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;