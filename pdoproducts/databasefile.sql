CREATE DATABASE productsdatabase;
CREATE TABLE categories(
category_id INT AUTO_INCREMENT PRIMARY KEY,
category_Name VARCHAR(255)
);

CREATE TABLE pdo_products (
prodId INT AUTO_INCREMENT PRIMARY KEY,
prodName VARCHAR(255),
prodDesc VARCHAR(255),
prodPrice FLOAT,
prodImage TEXT,
prodRating FLOAT,
category_id INT, 
FOREIGN KEY (category_id) REFERENCES categories(categories_id) ON DELETE CASCADE
);






