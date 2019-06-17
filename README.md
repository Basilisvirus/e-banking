# e-banking
an online e-banking application 

Steps one needs to follow to reproduce the project:


#**On Ubuntu, usind xampp:**

-Download or clone the project. If downloaded, you need to extract it.

-If xampp is not installed, you will need to install it.
============================XAMPP START
//once you install xampp, Will be installed in opt/lampp

//The location you need to save your files to run the web-app (you can add other folders with your project name inside there):
/opt/lampp/htdocs/projects

//To start xampp, use this command:
$ sudo /opt/lampp/lampp start

//The url you need to open to run the files saved in /projects folder:
http://localhost/projects/nameOfFile.FileExtension


//you also need net tools in order to make xampp run
sudo apt install net-tools

//in order to uninstall it:
cd /opt/lampp
sudo ./uninstall
//and then 
sudo rm -r /opt/lampp
============================XAMPP END

-Open nautilus. run: $ sudo nautilus

-Copy the files from e-banking-master to /opt/lampp/htdocs/projects . If the projects file is not there, you may create it.

-Run xampp using this command: $ sudo /opt/lampp/lampp start (you should see task starting correctly)

-go to a drowser, paste: http://localhost/projects/e-banking/login_page.php
    Note that i placed my poject inside a new folder 'e-banking'. If ours is different, you may change the directory.

-You should see the webpage now, it has a green background and asks you to register or sign in, but your database is not yet set up.
**Lets set up the database (the place where your files will be stored online)**

-Go to http://localhost/phpmyadmin/

-On the left, click "new", paste this database name: ebanking , and click "create"

-Click the "SQL" tab. Paste these lines, to create our necesary tables:

```
create table users (
	id int(9) not null PRIMARY KEY AUTO_INCREMENT,
    email varchar(48) not null,
    nickname varchar(30) not null,
    password varchar(48) not null
);

create table funds (
	id int(9) not null PRIMARY KEY AUTO_INCREMENT,
    bank int(9) not null,
    card int(9) not null
);

create table transactions (
	sender int(9) not null PRIMARY KEY,
    receiver int(9) not null,
    date varchar(10) not null,
    view boolean not null
);
```

-Click "Go", on bottom left. Your database is now complete. Time to fill it up.

-Go back to the webpage, http://localhost/projects/e-banking/login_page.php [Or your own link, directing to the login_page]

-Sign up, enjoy the app


#**On Windows:**

-Download or clone the project. If downloaded, you need to extract it.

-Install and run xampp, run apache and mysql server from xampp.

-Install an ide to run the webpage. For example you can use phpstorm, from jetbrains.

-Configure phpstorm with xampp

-load the webpage files on the ide (phpstorm)

-Click to run the project [the login_page.php]

-You should see the webpage now, it has a green background and asks you to register or sign in, but your database is not yet set up.
**Lets set up the database (the place where your files will be stored online)**

-Go to http://localhost/phpmyadmin/

-On the left, click "new", paste this database name: ebanking , and click "create"

-Click the "SQL" tab. Paste these lines, to create our necesary tables:

```
create table users (
	id int(9) not null PRIMARY KEY AUTO_INCREMENT,
    email varchar(48) not null,
    nickname varchar(30) not null,
    password varchar(48) not null
);

create table funds (
	id int(9) not null PRIMARY KEY AUTO_INCREMENT,
    bank int(9) not null,
    card int(9) not null
);

create table transactions (
	sender int(9) not null PRIMARY KEY,
    receiver int(9) not null,
    date varchar(10) not null,
    view boolean not null
);
```

-Click "Go", on bottom left. Your database is now complete. Time to fill it up.

-This is how your db should look after setting it up:
[![db.jpg](https://i.postimg.cc/brCSzSpg/db.jpg)](https://postimg.cc/RJtZdF3J)

-Go back to the webpage, http://localhost/projects/e-banking/login_page.php [Or your own link, directing to the login_page]

-Sign up, enjoy the app


[![login.jpg](https://i.postimg.cc/wvJdqCzG/login.jpg)](https://postimg.cc/bDz5LFsx)

[![main.jpg](https://i.postimg.cc/Kj2hR0vv/main.jpg)](https://postimg.cc/2b2KtFZP)

