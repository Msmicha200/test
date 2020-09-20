CREATE TABLE statuses(
    id INT PRIMARY KEY AUTO_INCREMENT,
    `status` VARCHAR
        (64) NOT NULL,
    class_name VARCHAR(128) NOT NULL
    
);

CREATE TABLE notes(
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(64) NOT NULL,
    email VARCHAR(128) NOT NULL,
    description TEXT(4096) NOT NULL,
    edited TINYINT NOT NULL DEFAULT 0,
    status_id INT NOT NULL DEFAULT 1,
    FOREIGN KEY(status_id) REFERENCES statuses(id)
);

INSERT INTO statuses (status, class_name) VALUES ('Rejected', 'rejected'), 
('In progress', 'inprogress'), ('Done', 'done');
