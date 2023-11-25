-- All users must introduce their first_name and last_name, email, phone_number, address, picture and password in order to register on the platform.


-- table users

--     id - int primary key auto_increment
--     email - varchar (validation in form)
--     password - varchar (hash)
--     status - varchar ( will be user or adm)
--     first_name - varchar
--     last_name - varchar
--     phone_number - varchar (can include specials like +, /, -)
--     address - varchar (street - city)
--     picture - varchar (good enough length, will be saved locally or on server)

create table `users` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `pass` VARCHAR(255) NOT NULL,
    `status` VARCHAR(50) NOT NULL DEFAULT 'user',
    `first_name` VARCHAR(50) NOT NULL,
    `last_name` VARCHAR(50) NOT NULL,
    `phone_number` VARCHAR(255) NOT NULL,
    `address` VARCHAR(255) NOT NULL,
    `picture` VARCHAR(255) NOT NULL
    )


-- All animals must have a name, a photo and live at a specific location(a single line like “Praterstrasse 23” is enough). 
-- They also have a description, size, age, vaccinated, must belong to a breed and have a status "Adopted" or "Available".

-- You love animals and think it is time to adopt one. 
-- You like all sorts of animals: small animals, large animals, you may like reptiles and birds and may be open to adopting animals of any age. 

-- table animals

--     id - int primary key auto_increment
--     name - varchar
--     address - varchar
--     size - varchar (to be queried later for small/large)
--     age - int
--     breed - varchar , better would be foreign key to breed table
--     description - varchar (likes to scratch your furniture)
--     vaccinated - varchar (yes or no)
--     status - varchar (Adopted or Available)
--     picture - varchar (good enough length, will be saved locally or on server)


create table `animals` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `status` VARCHAR(50) NOT NULL DEFAULT 'Available',
    `vaccinated` VARCHAR(50) NOT NULL DEFAULT 'no',
    `name` VARCHAR(50) NOT NULL,
    `address` VARCHAR(255) NOT NULL,
    `size` INT(10) NOT NULL,
    `age` INT(10) NOT NULL,
    `breed` VARCHAR(100) NOT NULL,
    `description`VARCHAR(255) NOT NULL,
    `picture` VARCHAR(255) NOT NULL
    )

-- Pet Adoption
--     In order to accomplish this task, a new table pet_adoption will need to be created. 
--     This table should hold the user_id and the pet_id (as foreign keys) plus other information that you may think is relevant i.e: adoption_date. 
--     Each Pet information/card should have a button "Take me home" that, when clicked, will "adopt" the pet. When it does, a new record should be created in the table pet_adoption.
    
-- table pet_adoption

--     id - int primary key auto_increment
--     fk_userid - foreign key references table user (id)
--     fk_animalid - foreign key references table animals (id)
--     adoption_date - date

create table `pet_adoption` (
     `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
     `adoption_date` DATE NOT NULL,
     `fk_userid` INT NOT NULL,
     `fk_animalid`INT NOT NULL,
FOREIGN KEY (fk_userid) REFERENCES `users` (`id`),
FOREIGN KEY (fk_animalid) REFERENCES `animals` (`id`)
 )


-- insert some data into animals


INSERT INTO `animals`(`status`, `vaccinated`, `name`, `address`, `size`, `age`, `breed`, `description`, `picture`) 
    VALUES ('Available','yes','Furry1','city1 street1',25,5,'Dog','crazy and aggressive', 'default.png'),
           ('Available','no','Furry2','city2 street2',30,4,'Cat','scratches everything', 'default.png'),
           ('Available','yes','Furry3','city3 street3',125,5,'Horse','tramples', 'default.png'),
           ('Available','yes','Furry4','city4 street4',23,50,'Squirrel','fast', 'default.png'),
           ('Available','yes','Furry5','city1 street5',35,25,'Spider','poisonous', 'default.png'),
           ('Available','yes','Furry6','city3 street5',45,9,'Sheep','relaxed', 'default.png'),
           ('Available','yes','Furry7','city9 street7',155,11,'Bison','majestic', 'default.png'),
           ('Available','no','Furry8','city10 street1',35,34,'Snake','wiggles', 'default.png'),
           ('Available','yes','Furry9','city6 street11',65,55,'Grasshopper','crazy and aggressive', 'default.png'),
           ('Available','yes','Furry10','city88 street23',75,65,'Bird','vertigo', 'default.png'),
           ('Available','yes','Furry11','city22 street12',85,2,'Dog','lazy', 'default.png'),
           ('Available','yes','Furry12','city5 street8',95,3,'Cat','vindictive', 'default.png'),
           ('Available','no','Furry13','city9 street11',5,8,'Sheep','adventureous', 'default.png'),
           ('Available','yes','Furry14','city10 street15',15,7,'Snake','smart', 'default.png'),
           ('Available','yes','Furry15','city43 street22',75,4,'Spider','lonley', 'default.png')