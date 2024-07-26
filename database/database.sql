CREATE DATABASE todo;
USE todo;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT,
    username TEXT,
    user_password TEXT,
    PRIMARY KEY (user_id)
);

CREATE TABLE tasks (
    task_id INT AUTO_INCREMENT,
    task TEXT,
    user_id INT,
    PRIMARY KEY (task_id),
    FOREIGN KEY FK_TASKS_USERS (user_id) REFERENCES users(user_id)
);
