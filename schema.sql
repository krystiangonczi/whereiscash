CREATE DATABASE IF NOT EXISTS `wykop_db`;

CREATE TABLE IF NOT EXISTS users (
    user_id int UNSIGNED NOT NULL AUTO_INCREMENT,
    email VARCHAR(250) NOT NULL UNIQUE,
    password VARCHAR(60) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(user_id)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS categories (
    category_id int UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(60) NOT NULL,
    PRIMARY KEY(category_id)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS targets (
    target_id int UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id int UNSIGNED NOT NULL,
    amount FLOAT (10,4) NOT NULL,
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    finished BIT NOT NULL DEFAULT 0,
    PRIMARY KEY(target_id),
    CONSTRAINT `targets_user` FOREIGN KEY (user_id) REFERENCES users (user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS transactions (
    transaction_id int UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id int UNSIGNED NOT NULL,
    category_id int UNSIGNED NOT NULL,
    title VARCHAR(60) NOT NULL DEFAULT '',
    amount FLOAT (10,4) NOT NULL,
    cash_flow BIT NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL,
    PRIMARY KEY(transaction_id),
    CONSTRAINT `transactions_user` FOREIGN KEY (user_id) REFERENCES users (user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT `transactions_category` FOREIGN KEY (category_id) REFERENCES categories (category_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE = InnoDB;
