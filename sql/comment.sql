/**
 * Author:  piotr
 * Created: Jun 30, 2017
 */
CREATE TABLE IF NOT EXISTS comment (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    post_id INT,
    user_id INT,
    dateOfCreation DATETIME NOT NULL,
    content VARCHAR(60) NOT  NULL,
    FOREIGN KEY(post_id) REFERENCES post(id),
    FOREIGN KEY(user_id) REFERENCES user(id)
);
