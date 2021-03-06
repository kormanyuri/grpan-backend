###Deployment
1. clone source code from repository
2. install dependencies
```bash
composer install
composer dump-autoload
```
3. connect to mysql server and create database
```bash
mysql -uroot -p
mysql> CREATE DATABASE `greenpanda` /*!40100 DEFAULT CHARACTER SET utf8 */;
mysql> exit
```
4. change database settings in .env

5. run migrations
```bash
php artisan migrate
```
6. run seeders for fill demo data
```bash
php artisan db:seed
```

7. deploy resources
```bash
npm install
npm run production
```
8. add symbol link to storage:
```bash
cd public
ln -s ../storage/app storage
```
###relate with frontend on one domain
You can run backend with frontend on one domain with symbol link, 
for example:   
if you have next structure of directories:  
-greenpanda  
--frontend  
--backend  
then execute next commands:  
```bash
cd greenpanda/frontend
ln -s ../backend/public admin
```
now you can setting up host for you favorite web-server to greenpanda/frontend and admin part and backend 
will be available on this path /admin, for example, if you have domain greenpandagame.com, 
then admin part will be available by this path  http://greenpandagame.com/admin/login, and endpoin for backend requests will be available by this path http://greenpandagame.com/admin  