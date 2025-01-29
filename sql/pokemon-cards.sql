CREATE TABLE cards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    type VARCHAR(100) NOT NULL,
    description TEXT
);

INSERT INTO cards (name, type, description) VALUES
('Pikachu', 'Elektrisch', 'Elektrisch type Pokémon'),
('Charmander', 'Vuur', 'Vuur type Pokémon'),
('Squirtle', 'Water', 'Water type Pokémon');