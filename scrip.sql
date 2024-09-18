CREATE TABLE city
(
    id   INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE address
(
    id        INT AUTO_INCREMENT PRIMARY KEY,
    street    VARCHAR(255) NOT NULL,
    city_id   INT          NOT NULL,
    zip       VARCHAR(20)  NOT NULL,
    email     VARCHAR(255) NOT NULL,
    name      VARCHAR(255) NOT NULL,
    firstName VARCHAR(255) NOT NULL,
    FOREIGN KEY (city_id) REFERENCES city (id)
);

INSERT INTO city (name)
VALUES ('São Paulo'),
       ('Rio de Janeiro'),
       ('Belo Horizonte'),
       ('Salvador'),
       ('Fortaleza'),
       ('Curitiba'),
       ('Recife'),
       ('Porto Alegre'),
       ('Brasília'),
       ('Manaus');

INSERT INTO address (street, city_id, zip, email, name, firstName)
VALUES ('Rua A, 100', 1, '01000-001', 'joao@example.com', 'Santos', 'João'),
       ('Rua B, 200', 2, '02000-002', 'maria@example.com', 'Silva', 'Maria'),
       ('Rua C, 300', 3, '03000-003', 'pedro@example.com', 'Oliveira', 'Pedro'),
       ('Rua D, 400', 4, '04000-004', 'ana@example.com', 'Costa', 'Ana'),
       ('Rua E, 500', 5, '05000-005', 'luiz@example.com', 'Martins', 'Luiz'),
       ('Rua F, 600', 6, '06000-006', 'carla@example.com', 'Pereira', 'Carla'),
       ('Rua G, 700', 7, '07000-007', 'roberto@example.com', 'Ferreira', 'Roberto'),
       ('Rua H, 800', 8, '08000-008', 'juliana@example.com', 'Rodrigues', 'Juliana'),
       ('Rua I, 900', 9, '09000-009', 'ricardo@example.com', 'Souza', 'Ricardo'),
       ('Rua J, 1000', 10, '10000-010', 'patricia@example.com', 'Oliveira', 'Patricia'),
       ('Rua K, 110', 1, '01001-011', 'marcio@example.com', 'Oliveira', 'Marcio'),
       ('Rua L, 220', 2, '02001-012', 'jose@example.com', 'Martins', 'José'),
       ('Rua M, 330', 3, '03001-013', 'marcia@example.com', 'Costa', 'Marcia'),
       ('Rua N, 440', 4, '04001-014', 'fernando@example.com', 'Pereira', 'Fernando'),
       ('Rua O, 550', 5, '05001-015', 'claudia@example.com', 'Silva', 'Claudia'),
       ('Rua P, 660', 6, '06001-016', 'andre@example.com', 'Santos', 'André'),
       ('Rua Q, 770', 7, '07001-017', 'luana@example.com', 'Rodrigues', 'Luana'),
       ('Rua R, 880', 8, '08001-018', 'tiago@example.com', 'Martins', 'Tiago'),
       ('Rua S, 990', 9, '09001-019', 'leticia@example.com', 'Oliveira', 'Leticia'),
       ('Rua T, 1001', 10, '10001-020', 'roberto@example.com', 'Souza', 'Roberto');