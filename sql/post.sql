/**
 * Author:  piotr
 * Created: Jun 30, 2017
 */
CREATE TABLE IF NOT EXISTS post (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    content VARCHAR(240),
    user_id INT NOT NULL, 
    FOREIGN KEY(user_id) REFERENCES user(id)
);