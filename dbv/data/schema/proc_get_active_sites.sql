DROP PROCEDURE IF EXISTS `proc_get_active_sites`;
DELIMITER //
CREATE PROCEDURE `proc_get_active_sites`
()
BEGIN
  SET @QUERY =    "SELECT 
                    `vf`.`ID`,
                    `vf`.`name` 
                  FROM `vl_site_summary` `vss` 
                  JOIN `view_facilitys` `vf` 
                    ON `vss`.`facility` = `vf`.`ID`";

     PREPARE stmt FROM @QUERY;
     EXECUTE stmt;
END //
DELIMITER ;