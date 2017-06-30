/**
 * Author:  piotr
 * Created: Jun 30, 2017
 */
CREATE TABLE IF NOT EXISTS user (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE,
    hashed_password VARCHAR(255)
);

