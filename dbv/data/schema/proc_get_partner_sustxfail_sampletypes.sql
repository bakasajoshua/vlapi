DROP PROCEDURE IF EXISTS `proc_get_partner_sustxfail_sampletypes`;
DELIMITER //
CREATE PROCEDURE `proc_get_partner_sustxfail_sampletypes`
(IN P_id INT(11), IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT 
                        `vsd`.`name`, 
                        SUM(`vcs`.`sustxfail`) AS `sustxfail` 
                    FROM `vl_partner_sampletype` `vcs` 
                    JOIN `viralsampletypedetails` `vsd` 
                        ON `vcs`.`sampletype` = `vsd`.`ID`
                WHERE 1";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `vcs`.`partner` = '",P_id,"' AND `vcs`.`year` = '",filter_year,"' AND `vcs`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vcs`.`partner` = '",P_id,"' AND `vcs`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vsd`.`name` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    
END //
DELIMITER ;