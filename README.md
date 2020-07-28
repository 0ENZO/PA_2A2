# PA_2A2
A full symfony application coupled with three.js, Java and C that spotlights a fictional food trucks industry : Driv'n Cook !


## About



> What is this project ?

It is the final project from our 2 years during ESGI computer science Study.
This is the end of 2 years of general learning about global computer science knowlegde.
If our project is validated, we can continue our studies by selecting a speciality, which we will focus on during the next 3 years.

> What's the subject ?

To tranform a fictive food truck firm buisness into a computerized firm, that have the same goals.

This is a franchise, and some people can be franchised, to belong to the firm.
In that way, they can have a truck, and start working like it was its own firm (the franchised will to give royalties to the mother firm).
Franchised people can supply themselves by bying to one of the different warehouses available of the firm.

Clients can register themselves to the website, to perform an order to some franchised.
The registered client can win some fidelity points by spending money or buy a specific menu.
These points can be spent to have a discount in the next order, or win a free menu, depending of the type of the points they would have.

The firm has to keep an eye on everythings related to their brand, that's why there is also and big backend-processus for all of the Website application, like a CRUD (Create, Read, Update, Delete) operations on all of the entites, like warehouses, money management, products and articles etc.

The last :  communication has to be secure, and a Network proposal with EVE-NG technology have to be used to represent the trafic between the warehouses
(This part is independant of the website processus and is not showed here in this repository)

> How can we succeed ?

We have to respect some programming rules on all the projetcs :
* Make the registering of franchised people only in C language, via a QRcode creation, FTP/SFTP transfer and reading to the hosting server)
* Use Php/JS for the backend (We were free to use anything related to php/js, so we choose Symfony)
* Make a 3D three.js model as website showcase
* Use JAVA for the fidelity card system (Not present on the site itself, just an desktop application we have to lunch and connect with our account to manage cards)
* Have a fonctionnal Network Shema in EVE-NG with IP-sec and NAT process
* Respect all the rules defined in the subject

## 1. Prerequisites   



To run successfuly this __web application__ localy, you will have to verify the following checklist :

* Having **composer** installed on your machine
* Having **yarn** installed on your machine
* Having a local server such as **MAMP**, **WAMP** or **XAMPP**.
* (Optional) Having a **Linux machine** (VM or real) to handle the **C language** part

Our project is full Symfony Web Application. It is based on some packages that are always updated by the Symfony developers and community (with a lot of bundles managed by Symfony).

Knowing that, **compser** does help the php dependencies trought all the application, and yarn helps javascript dependancies trought all the assets used by the application.
That's why you need to perfom the following commands when you have downloaded all the web project :

(NB : All the following commands have to be performed at the root of the Web Application, which is ` PA_2A2/drivncook/` )

```
composer require
yarn install
```

Of course, you will need a server to run the Web Application localy.

And the last, having a Machine linux to run the C programm will be useful. This step is optionnal, because all the Application will works without that.
This is just better to have one, to register the franchise people throught the database
(Because we had to manage the franchise people registration only in C language, but you can still add one manually with the __fixtures__)

### UPDATE

For some security reasons, we let you devide the configuration of the database connexion etc in the C and Java files.

That's why you have to modify these files, for the given paths :

```
/Applications/MAMP/htdocs/PA_2A2/C/Envoi bdd/try.c 											// At line 32
/Applications/MAMP/htdocs/PA_2A2/Java/Gestion/src/mysql/App_login.java 	// At line 34
```



## 2. Installation

### 2.05 Activate the assets (CSS et JS)

We user Webpack encore for this projet, and that's why you need to perform the following commands in order to activate the assets

```
yarn encore dev
```

### 2.1 Configuration of the database

Symfony includes its own **ORM** (Object Relationnal Mapping) , wihch is **Doctrine**
It does use file named *.env* to know the related database configuration.
It includes this specific ligne (arround ligne n°32) :

```
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7
```

This is here you have to check your own local configuration to fill the right informations through this ligne.

Or you can copy this line, and create a file  `.env.local` at the root of the folder, paste it, and check the configurations.

This way, symfony will only looks at the `.env.local` instead of the `.env` file when you are performing local processing.

### 2.2 Creation of the database

With Doctrine, Entity Classes represent our database. So we have to tell Doctrine to translate what's inside our class, to SQL satements. In order to perform this action, you have to execute the following commands :

(NB : All the following commands have to be performed at the root of the Web Application, which is ` PA_2A2/drivncook/` )

1. Create the database according the filled information inside the `.env.local` file :
```
php bin/console doctrine:database:create
```

2. Execute the migrations to the last, which represent Entity modifications in the projet thought time, from the begining to the last one :
````
php bin/console doctrine:migrations:migrate
````

3. Fill the database with all the pre-built data object (called fixtures as well) :
```
php bin/console doctrine:fixtures:load
```

### 2.3 Run the Web application

If all the previous actions have been performed successfully, then you can lauch your local server and the following command :

```
symfony server:start
```

Then you can acess to the url that are given in the CLI to navigate through the Web Application. Enjoy ! 
