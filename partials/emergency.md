
| feature | Query |
| -------| ------------|
| the name of the database is | **cse370_project** |
| query for database creating | **CREATE DATABASE cse370_project;** |
| signup | 
```sql
CREATE TABLE `signup` (
  `username` varchar(50) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `gmail` varchar(100) NOT NULL,
  `std_id` varchar(10) NOT NULL,
  `gsuit` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `home_town` varchar(50) DEFAULT NULL,
  `password_` varchar(255) NOT NULL,
  `signup_time` timestamp NULL DEFAULT current_timestamp(),
  `otp` int(11) DEFAULT NULL,
  PRIMARY KEY (`std_id`)
);

CREATE TABLE `courses` (
  `student_id` varchar(10) NOT NULL,
  `course_code` char(6) DEFAULT NULL,
  `section` int(11) DEFAULT NULL,
  UNIQUE KEY `student_id` (`student_id`,`course_code`,`section`),
  CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `signup` (`std_id`)
);

``` 
|
my name is naimur
