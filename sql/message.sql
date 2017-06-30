/**
 * Author:  piotr
 * Created: Jun 30, 2017
 */
CREATE TABLE IF NOT EXISTS message (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    content VARCHAR(255) NOT NULL,
    dateOfSending DATETIME NOT NULL,
    FOREIGN KEY(sender_id) REFERENCES user(id),
    FOREIGN KEY(receiver_id) REFERENCES user(id)
);

