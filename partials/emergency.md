
| feature | Query |
| -------| ------------|
| the name of the database is | **cse370_project** |
| query for database creating | **CREATE DATABASE cse370_project;** |
| signup | 
```sql
CREATE TABLE signup (
    username VARCHAR(50),
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    gmail VARCHAR(100) PRIMARY KEY,
    std_id VARCHAR(10),
    gsuit VARCHAR(100),
    dob DATE,
    home_town VARCHAR(50),
    password_ VARCHAR(255),
    signup_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
``` 
|
