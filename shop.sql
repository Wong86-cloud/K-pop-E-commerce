CREATE TABLE artists (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    image_url VARCHAR(255) NOT NULL
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(50) NOT NULL,
    celebrity VARCHAR(100) NOT NULL,  -- Same type as `name` in `artists`
    image VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (celebrity) REFERENCES artists(name)
        ON DELETE CASCADE  -- Optional, but useful for ensuring integrity
        ON UPDATE CASCADE
);
