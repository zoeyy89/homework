use member ;

CREATE TABLE persons (
    -- id      INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,    
    email      varchar(50)   NOT NULL  PRIMARY KEY, 
    name       varchar(255)  NOT NULL,
	gender     char(1)       NOT NULL,
	phone      varchar(50),  
    address    varchar(255),
	password   varchar(60)   NOT NULL
);


