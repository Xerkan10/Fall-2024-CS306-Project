CREATE TABLE TRANSFER_LIST (
    transfer_id INT AUTO_INCREMENT PRIMARY KEY,  -- Unique identifier for each transfer
    team_name VARCHAR(100) NOT NULL,            -- Name of the team making the offer
    player_name VARCHAR(100) NOT NULL,          -- Name of the player being transferred
    transfer_amount DECIMAL(15, 2) NOT NULL,    -- Transfer amount in dollars
    agent_name VARCHAR(100) NOT NULL,           -- Name of the agent handling the player
    offer_date DATETIME DEFAULT CURRENT_TIMESTAMP -- Timestamp of the transfer offer
);

DELIMITER //

CREATE PROCEDURE AddTransferOffer (
    IN p_team_name VARCHAR(100),
    IN p_player_name VARCHAR(100),
    IN p_transfer_amount DECIMAL(15, 2),
    IN p_agent_name VARCHAR(100)
)
BEGIN
    -- Insert the transfer offer into the TRANSFER_LIST table
    INSERT INTO TRANSFER_LIST (team_name, player_name, transfer_amount, agent_name)
    VALUES (p_team_name, p_player_name, p_transfer_amount, p_agent_name);
END //

DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_team_count`(action_type ENUM('INSERT', 'UPDATE', 'DELETE'),
                                   old_team_name VARCHAR(100),
                                   new_team_name VARCHAR(100))
BEGIN
    CASE action_type
        WHEN 'INSERT' THEN
            UPDATE TEAM
            SET team_player_count = team_player_count + 1
            WHERE team_name = new_team_name;

        WHEN 'DELETE' THEN
            UPDATE TEAM
            SET team_player_count = team_player_count - 1
            WHERE team_name = old_team_name;

        WHEN 'UPDATE' THEN
            IF old_team_name != new_team_name THEN
                UPDATE TEAM
                SET team_player_count = team_player_count - 1
                WHERE team_name = old_team_name;

                UPDATE TEAM
                SET team_player_count = team_player_count + 1
                WHERE team_name = new_team_name;
            END IF;
    END CASE;
END$$
DELIMITER ;

CREATE TRIGGER `update_team_player_count` AFTER UPDATE ON `PLAYER`
 FOR EACH ROW BEGIN
    CALL update_team_count('UPDATE', OLD.team_name, NEW.team_name);
END

CREATE TRIGGER `update_team_player_count_after_insert` AFTER INSERT ON `PLAYER`
 FOR EACH ROW BEGIN
    CALL update_team_count('INSERT', NULL, NEW.team_name);
END

CREATE TRIGGER `player_after_delete` AFTER DELETE ON `PLAYER`
 FOR EACH ROW BEGIN
    CALL update_team_count('DELETE', OLD.team_name, NULL);
END


DELIMITER //

CREATE PROCEDURE GetPlayersBySalary(IN min_salary INT, IN max_salary INT)
BEGIN
    SELECT 
        player_id, 
        player_name, 
        player_salary, 
        player_age, 
        min_transfer_cost, 
        prefered_foot, 
        player_position, 
        team_name
    FROM 
        PLAYER
    WHERE 
        player_salary BETWEEN min_salary AND max_salary;
END //

DELIMITER ;



DELIMITER $$

CREATE TRIGGER update_transfer_cost_on_transfer
AFTER INSERT ON DEALS_DONE
FOR EACH ROW
BEGIN
    -- Update the min_transfer_cost in the PLAYER table
    UPDATE PLAYER
    SET transfer_cost = NEW.transfer_amount
    WHERE player_name = NEW.player_name;
END$$

DELIMITER ;

DELIMITER $$

CREATE TRIGGER update_player_salary_on_transfer
AFTER INSERT ON DEALS_DONE
FOR EACH ROW
BEGIN
    -- Update the min_transfer_cost in the PLAYER table
    UPDATE PLAYER
    SET player_salary = NEW.salary_amount
    WHERE player_name = NEW.player_name;
END$$

DELIMITER ;

DELIMITER $$

CREATE TRIGGER update_team_name_on_transfer
AFTER INSERT ON DEALS_DONE
FOR EACH ROW
BEGIN
    -- Update the min_transfer_cost in the PLAYER table
    UPDATE PLAYER
    SET team_name = NEW.new_team
    WHERE player_name = NEW.player_name;
END$$

DELIMITER $$

CREATE TRIGGER update_team_number_on_team_adding
AFTER INSERT ON TEAM
FOR EACH ROW
BEGIN
    UPDATE LEAGUE
    SET team_number = team_number + 1
    WHERE league_name = NEW.league_name;
END$$

DELIMITER ;
