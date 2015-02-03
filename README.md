Quick Start
===========

1. Download the sources files from here(or through git):
https://github.com/Cayce/Boomboom/zipball/master

2. Download the database structure and data from here:
https://github.com/downloads/Cayce/Boomboom/databases.zip

3. Сreate 2 databases, in one import the boomboom database file, in second log database file

4. Go to file config.php, and change those constants to fit your database:

    >define('DBMS_NAME','mysql');          // Database management system name

    >define('DB_HOST'  ,'localhost');      // If the server is on the same ip as mysql(or other dbms) the host is localhost

    >define('DB_PORT'  ,'3306');           // 3306 is default port for mysql

    >define('DB_USER'  ,'root');           // Name of the user with access to Boomboom and log databases

    >define('DB_PASS'  ,$passwords[0]);    // Password of the user
 
    >define('DB_DATABASENAME','Boomboom'); // Name of the main database

    >define('DB_DATABASENAME_LOG','log');  // Name of database for log errors

5. Go to .htaccess in main folder and admin, and change Boomboom adn Boomboom/admin for directories that you use

Admin
=====
Access to your admin in websitename/admin

user: admin

pass: 123

