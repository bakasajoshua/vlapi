DROP PROCEDURE IF EXISTS `proc_get_sites_trends`;
DELIMITER //
CREATE PROCEDURE `proc_get_sites_trends`
(IN S_id INT(11), IN filter_year INT(11))
BEGIN
  SET @QUERY =    "SELECT
        `month`, 
        `year`, 
        SUM(`confirmtx`) AS `confirmtx`,
        SUM(`confirm2vl`) AS `confirm2vl`,
        SUM(`Undetected`) AS `undetected`,
        SUM(`less1000`) AS `less1000`,
        SUM(`less5000`) AS `less5000`,
        SUM(`above5000`) AS `above5000`,
        SUM(`alltests`) AS `alltests`,
        SUM(`sustxfail`) AS `sustxfail`,
        SUM(`rejected`) AS `rejected`,
        AVG(`sitessending`) AS `sitessending`
    FROM `vl_site_summary`
    WHERE 1";

    SET @QUERY = CONCAT(@QUERY, " AND `facility` = '",S_id,"' AND `year` = '",filter_year,"' GROUP BY `month`");

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;