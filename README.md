# basicEndPointExample

## Server setup
##### Install LAMP stack
`sudo apt-get install lamp-server^ phpmyadmin`
-remember the mysql password
-select apache before continuing when phpmyadmin asks
##### Mysql Setup
`mysql -u root -p < serverSetupMysql.sql`
(enter mysql password when prompted)
##### Copy php file in a callable location
Example on ubuntu
`cp basicEndPointExample.php /var/www/html/.`

## Workflow of the endpoint
1. Setup database connection
2. verify inputs are in the correct format
  -- return calculated here
3. Get salt and coins from database
4. Confirm user had enough coins
5. Confirm hash matches hash calculated by server
  -- hashes are sha512 in the form `$playerSaltValue . $playerId . $playerSaltValue . $coinsBet . $playerSaltValue . $coinsWon . $playerSaltValue`
6. Update values in database
7. Get values from the database to return as JSON
8. Clean up

## Call the endpoint
The endpoint looks for four parameters `playerId` `coinsBet` `coinsWon` `hash`

Calculate hash using above formula using something like [this](https://hash.online-convert.com/sha512-generator)

Example:
`http://<ADDRESS>/basicEndPointExample.php?playerId=1&coinsBet=3&coinsWon=20&hash=78d497529d7034e5a750966ae275b89b8239d8d5fc3da5d493badd5e86bc48375a3cf95226e6c6ba86e1de75a4d57bc96becf44eb00abb7b1f9b86ebdabe4d19`

| PlayerID | coinsBet | coinsWon | hash |
|----------|----------|----------|------|
| 1 | 3  | 20 | 78d497529d7034e5a750966ae275b89b8239d8d5fc3da5d493badd5e86bc48375a3cf95226e6c6ba86e1de75a4d57bc96becf44eb00abb7b1f9b86ebdabe4d19 |
| 1 | 10 | 30 | 397637172e38ba052f9d3d38f73a11c5563cbcf19d7d8434d0910f1231777c38611f3cf49a4a69d11a3f90cc55b0039aa2e1d63a950d36ef2dbf63e9607e0f6b|
| 1 | 80 | 0 | d0c82d8a2c6984b6803fae1427bb742994e48c7a8089ddceb1f76f3926e5d2b6376f5771e2e0667c78e857c897d2004670671ed6eff1cb4213723ebca92d7930 |
| 2 | 1  | 2 | 5a4b4bc92b35c62e56ac064f184177fe70d8c882c0155c713ea075a558f39ca35efc77d295d4545de27e0c2c9e96b9ad876a5f19e3f72ef568f50b2219c489a2 |
| 2 | 1  | 0 | 9e3ff354a4fb464f5be9476ab13571c77763e5ed8e26533aa40fa9f902685b15c88ccf39ec683119e1e38c1c5a672b7ef3f23ebd776b852d9a61a96e98dffc20 |
| 3 | 1  | 4 | e3e6894c6dcb33140dd2fce5aeea7705afc95187012f764eaec40fe6c1bf49584ff1c9a3ac219e0416ac6e624790d7e4412863ab46555c95bfdc1861745a2ab5 |
| 3 | 23 | 0 | 9a105e1425f5aae1b8f6e1884a2bd5d59fb44f1168546fdc865cc2dee1417398fb811d238d70ced2089f8f99de44bf435bda78c77c7bf63777cb27b17aacda4f |
