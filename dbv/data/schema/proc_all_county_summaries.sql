DROP PROCEDURE IF EXISTS `proc_get_county_suppression`;
DELIMITER //
CREATE PROCEDURE `proc_get_county_suppression`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `vnj`.`county` AS `id`, 
                    SUM((`vnj`.`tests`)) AS `tests`, 
                    SUM((`vnj`.`undetected`)+(`vnj`.`less1000`)) AS `suppressed`
                FROM `vl_county_justification` `vnj`
                WHERE 1 ";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `vnj`.`year` = '",filter_year,"' AND `vnj`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vnj`.`year` = '",filter_year,"' ");
    END IF;
  
  SET @QUERY = CONCAT(@QUERY, " GROUP BY `vnj`.`county` ");
  
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_county_non_suppression`;
DELIMITER //
CREATE PROCEDURE `proc_get_county_non_suppression`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `vnj`.`county` AS `id`, 
                    SUM((`vnj`.`tests`)) AS `tests`, 
                    SUM((`vnj`.`above5000`)+(`vnj`.`less5000`)) AS `non_suppressed`
                FROM `vl_county_justification` `vnj`
                WHERE 1 ";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `vnj`.`year` = '",filter_year,"' AND `vnj`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vnj`.`year` = '",filter_year,"' ");
    END IF;
  
  SET @QUERY = CONCAT(@QUERY, " GROUP BY `vnj`.`county` ");
  
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_county_rejected`;
DELIMITER //
CREATE PROCEDURE `proc_get_county_rejected`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `vnj`.`county` AS `id`, 
                    SUM((`vnj`.`tests`)) AS `tests`, 
                    SUM(`vnj`.`rejected`) AS `rejected`
                FROM `vl_county_justification` `vnj`
                WHERE 1 ";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `vnj`.`year` = '",filter_year,"' AND `vnj`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vnj`.`year` = '",filter_year,"' ");
    END IF;
  
  SET @QUERY = CONCAT(@QUERY, " GROUP BY `vnj`.`county` ");
  
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ; 

DROP PROCEDURE IF EXISTS `proc_get_county_pregnant_women`;
DELIMITER //
CREATE PROCEDURE `proc_get_county_pregnant_women`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `vnj`.`county` AS `id`, 
                    SUM(`vnj`.`tests`) AS `tests`
                FROM `vl_county_justification` `vnj`
                WHERE 1 AND `vnj`.`justification` = 6 ";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `vnj`.`year` = '",filter_year,"' AND `vnj`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vnj`.`year` = '",filter_year,"' ");
    END IF;
  
  SET @QUERY = CONCAT(@QUERY, " GROUP BY `vnj`.`county` ");
  
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ; 

DROP PROCEDURE IF EXISTS `proc_get_county_lactating_women`;
DELIMITER //
CREATE PROCEDURE `proc_get_county_lactating_women`
(IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `vnj`.`county` AS `id`, 
                    SUM(`vnj`.`tests`) AS `tests`
                FROM `vl_county_justification` `vnj`
                WHERE 1 AND `vnj`.`justification` = 9 ";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `vnj`.`year` = '",filter_year,"' AND `vnj`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vnj`.`year` = '",filter_year,"' ");
    END IF;
  
  SET @QUERY = CONCAT(@QUERY, " GROUP BY `vnj`.`county` ");
  
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ; 

DROP PROCEDURE IF EXISTS `proc_get_county_partner_details`;
DELIMITER //
CREATE PROCEDURE `proc_get_county_partner_details`
(IN county INT(11), IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT `p`.`name` AS `partner`, `vf`.`name` AS `facility`, SUM(`vss`.`alltests`) AS `tests`, 
                  SUM(`vss`.`less1000` + `vss`.`undetected`) AS `suppressed`, 
                  SUM(`vss`.`less5000` + `vss`.`above5000`) AS `non_suppressed`,
                  SUM(`vss`.`rejected`) AS `rejected`, SUM(`vss`.`adults`) AS `adults`, SUM(`vss`.`paeds`) AS `children`
                FROM `vl_site_summary` `vss`
                JOIN (`view_facilitys` `vf` CROSS JOIN `partners` `p`)
                ON (`vss`.`facility`=`vf`.`ID` AND `p`.`ID`=`vf`.`partner`)
                WHERE 1 ";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `vf`.`county` = '",county,"' AND `vss`.`year` = '",filter_year,"' AND `vss`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vf`.`county` = '",county,"' AND `vss`.`year` = '",filter_year,"' ");
    END IF;

    SET @QUERY = CONCAT(@QUERY, " GROUP BY `vf`.`ID` ");

    SET @QUERY = CONCAT(@QUERY, " ORDER BY `p`.`ID` ");

    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_get_county_summary`;
DELIMITER //
CREATE PROCEDURE `proc_get_county_summary`
(IN county INT(11), IN filter_year INT(11), IN filter_month INT(11))
BEGIN
  SET @QUERY =    "SELECT
                    `vnj`.`county` AS `id`, 
                    SUM(`vnj`.`tests`) AS `tests`,
                    SUM(`vnj`.`less1000` + `vnj`.`undetected`) AS `suppressed`, 
                    SUM(`vnj`.`less5000` + `vnj`.`above5000`) AS `non_suppressed`,
                    SUM(`vnj`.`rejected`) AS `rejected`
                FROM `vl_county_justification` `vnj`
                WHERE 1  ";

    IF (filter_month != 0 && filter_month != '') THEN
       SET @QUERY = CONCAT(@QUERY, " AND `vnj`.`county` = '",county,"' AND `vnj`.`year` = '",filter_year,"' AND `vnj`.`month`='",filter_month,"' ");
    ELSE
        SET @QUERY = CONCAT(@QUERY, " AND `vnj`.`county` = '",county,"' AND `vnj`.`year` = '",filter_year,"' ");
    END IF;
  
  SET @QUERY = CONCAT(@QUERY, " GROUP BY `vnj`.`county` ");
  
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
END //
DELIMITER ; 