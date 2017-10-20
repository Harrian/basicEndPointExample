# basicEndPointExample

## Server setup
##### Install LAMP stack
`sudo apt-get install lamp-server^`
(remember the mysql password)
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
| 1 | 3 | 20 | 78d497529d7034e5a750966ae275b89b8239d8d5fc3da5d493badd5e86bc48375a3cf95226e6c6ba86e1de75a4d57bc96becf44eb00abb7b1f9b86ebdabe4d19 |