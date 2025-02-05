-- Table structure for Cards
CREATE TABLE Cards (
    card_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    type VARCHAR(50) NOT NULL,
    rarity VARCHAR(50),
    price DECIMAL(10, 2) NOT NULL
);

-- Table structure for Customers
CREATE TABLE Customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    address VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table structure for Purchases
CREATE TABLE Purchases (
    purchase_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    card_id INT NOT NULL,
    quantity INT NOT NULL,
    purchase_date DATE NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES Customers(customer_id),
    FOREIGN KEY (card_id) REFERENCES Cards(card_id)
);

-- Insert example data into Cards table
INSERT INTO Cards (name, type, rarity, price) VALUES
('Pikachu', 'Electric', 'Common', 4.99),
('Charizard', 'Fire', 'Rare', 15.99),
('Bulbasaur', 'Grass', 'Common', 3.50),
('Squirtle', 'Water', 'Common', 3.99),
('Eevee', 'Normal', 'Uncommon', 5.49);

-- Insert example data into Customers table
INSERT INTO Customers (name, email, password, address) VALUES
('John Doe', 'john@example.com', 'hashed_password1', '123 Main St'),
('Jane Smith', 'jane@example.com', 'hashed_password2', '456 Oak St'),
('Emily Brown', 'emily@example.com', 'hashed_password3', '789 Pine St');

-- Insert example data into Purchases table
INSERT INTO Purchases (customer_id, card_id, quantity, purchase_date) VALUES
(1, 1, 2, '2024-09-10'),
(2, 2, 1, '2024-09-11'),
(3, 3, 3, '2024-09-12');

-- Example CRUD Operations
