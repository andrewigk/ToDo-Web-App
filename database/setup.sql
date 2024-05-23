-- create database
CREATE DATABASE todo_db;
-- create custom database user
CREATE USER 'todo_user' @'localhost' IDENTIFIED BY 'todo_PASSWORD69!';
-- grant privileges to user
GRANT ALL PRIVILEGES ON todo_db.* TO 'todo_user' @'localhost';
FLUSH PRIVILEGES;
-- create Users table
CREATE TABLE Users (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(50) NOT NULL,
    Email VARCHAR(50) NOT NULL,
    Password VARCHAR(50) NOT NULL
);
-- create Tasks table
CREATE TABLE Tasks (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    UserId INT NOT NULL,
    Name VARCHAR(50) NOT NULL,
    Tag VARCHAR(50),
    Description LONGTEXT,
    Complete BOOLEAN NOT NULL,
    FOREIGN KEY (UserId) REFERENCES Users(Id) ON DELETE CASCADE
);
-- test user
INSERT INTO Users (Name, Email, Password)
VALUES (
        'John Doe',
        'john.doe@example.com',
        'password123'
    );
-- test data for user with id = 1
INSERT INTO Tasks (UserId, Name, Tag, Description, Complete)
VALUES (
        1,
        'Task 1',
        'Work',
        'Complete the project proposal',
        false
    ),
    (
        1,
        'Task 2',
        'Personal',
        'Buy groceries for the week',
        false
    ),
    (
        1,
        'Task 3',
        'Work',
        'Prepare presentation slides',
        true
    ),
    (
        1,
        'Task 4',
        'Personal',
        'Go for a run in the park',
        false
    ),
    (
        1,
        'Task 5',
        'Work',
        'Attend team meeting at 2pm',
        false
    ),
    (
        1,
        'Task 6',
        'Personal',
        'Read a chapter of the new book',
        true
    ),
    (
        1,
        'Task 7',
        'Work',
        'Review and submit weekly report',
        false
    ),
    (
        1,
        'Task 8',
        'Personal',
        'Call mom to catch up',
        false
    ),
    (
        1,
        'Task 9',
        'Work',
        'Fix bug in the code',
        false
    ),
    (
        1,
        'Task 10',
        'Personal',
        'Plan weekend trip with friends',
        false
    );