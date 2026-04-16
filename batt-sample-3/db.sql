create table residents (
    id primary key auto_increment,
    resident_code VARCHAR(200) NOT NULL,
    last_name VARCHAR(200) NOT NULL,
    given_name VARCHAR(200) NOT NULL,
    middle_name VARCHAR(200) NOT NULL,
    date_of_birth date NOT NULL,
    date_of_stay date NOT NULL,
    civil_status ENUM('Single', 'Married', 'Divorced', 'Separated', 'Widow/Widower') NOT NULL
);



