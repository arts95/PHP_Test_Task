# PHP_Test_Task
The applicant must write a small RESTful web service that allows a user to store and retrieve physical addresses.


Create database.
Create table:
```sql
create table ADDRESS (
ADDRESSID int not null auto_increment primary key,
LABEL varchar(100) not null,
STREET varchar(100) not null,
HOUSENUMBER varchar(10) not null,
POSTALCODE varchar(6) not null,
CITY varchar(100) not null,
COUNTRY varchar(100) not null)
engine 'InnoDB',
character set utf8
```
Edit db.php in config folder.
