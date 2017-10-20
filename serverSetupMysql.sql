#create comment user for us to use
CREATE USER 'userManager'@'%' IDENTIFIED WITH mysql_native_password BY 'Mm96YWwcs6Wfek25';
#create a database for player information if it doesnt already exist
CREATE DATABASE IF NOT EXISTS `playerInformation`;
#give the userManager all privs on the playerInformation database
GRANT ALL PRIVILEGES ON `playerInformation`.* TO 'userManager'@'%';
#create player table with the necessary fields (note salt could be generated here)
CREATE TABLE `playerInformation`.`players` (
   `Player ID` INT NOT NULL AUTO_INCREMENT ,
   `Name` TEXT NOT NULL ,  `Credits` INT NOT NULL ,
   `Lifetime Spins` INT NOT NULL ,
   `Lifetime Return` INT NOT NULL,
   `Lifetime Average Return` DOUBLE AS (`Lifetime Return`/`Lifetime Spins`) STORED ,
   `Salt Value` TEXT NOT NULL ,    PRIMARY KEY  (`Player ID`)) ENGINE = InnoDB;
#insert a few players into the table
INSERT INTO `playerInformation`.`players` (`Player ID`, `Name`, `Credits`, `Lifetime Spins`, `Lifetime Return`, `Salt Value`) VALUES
 (NULL, 'Jan	Holland', '100', '100', '0', 'P%zafdaf='),
 (NULL, 'Darryl	Lawson', '200', '100', '100', 'zz%dDA=AX'),
 (NULL, 'Jody	Stephens', '400', '100', '300', 'AdSa%#@ZK');