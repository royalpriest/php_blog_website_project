-- Users table (unchanged except for adding a UNIQUE constraint)
CREATE TABLE usersInfo (
                           id INT AUTO_INCREMENT PRIMARY KEY,
                           name VARCHAR(100) NOT NULL,
                           email VARCHAR(100) NOT NULL UNIQUE ,
                           password VARCHAR(255) NOT NULL,
                           profile_picture VARCHAR(255) DEFAULT NULL,
                           created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Content table with just the connection added
CREATE TABLE content (
                         id INT AUTO_INCREMENT PRIMARY KEY,
                         user_id INT NOT NULL,  -- Only new column added
                         username VARCHAR(50),
                         title VARCHAR(255) NOT NULL,
                         body TEXT NOT NULL,
                         image VARCHAR(255) DEFAULT NULL,
                         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                         FOREIGN KEY (user_id) REFERENCES usersInfo(id)
);

