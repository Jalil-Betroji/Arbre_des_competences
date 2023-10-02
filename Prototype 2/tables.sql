CREATE TABLE Ville (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Nom VARCHAR(100)
);

CREATE TABLE Personne (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Nom VARCHAR(50),
    CNE VARCHAR(50),
    Type VARCHAR(50),
    Ville_Id INT,
    CONSTRAINT fk_Ville
        FOREIGN KEY (Ville_Id)
        REFERENCES Ville (Id)
);

INSERT INTO `Ville` (`Id`, `Nom`)
VALUES
    (1, 'Tetouan'),
    (2, 'Tanger'),
    (3, 'Casablanca'),
    (4, 'Rabat'),
    (5, 'Larache'),
    (6, 'Khouribga'),
    (7, 'El Kelaa des Sraghna'),
    (8, 'Khenifra'),
    (9, 'Beni Mellal'),
    (10, 'Tiznit'),
    (11, 'Errachidia'),
    (12, 'Taroudant'),
    (13, 'Ouarzazate'),
    (14, 'Safi'),
    (15, 'Lahraouyine'),
    (16, 'Berrechid'),
    (17, 'Fkih Ben Salah'),
    (18, 'Taourirt'),
    (19, 'Sefrou'),
    (20, 'Youssoufia');
    INSERT INTO `Personne` (`Id`, `Nom`,`CNE`,`Type`, `Ville_Id`)
VALUES
    (1, 'Jalil Betroji','P1231311','personne', '1'),
    (2, 'Hamid Achauo' ,'P456712','personne', '1'),
    (3, 'Amine Lamchatab','P5761512','personne', '1'),
    (4, 'Adnane Benasar','P12176762','personne', '1'),
    (5, 'Mohamed-Amine Bkhit','P5565412','personne' , '1'),
    (6, 'Imrane Sarsri','P4614112','personne', '1'),
    (7, 'Amina Assaid','P76675212','personne', '1'),
    (8, 'Yassmine Daifane','P6687521','personne', '3'),
    (9, 'Hussein Bouik','P6554125','personne', '3'),
    (10, 'Adnane Lharrak','P656721','personne', '3'),
    (11, 'Hamza zaani','P5642117','personne', '3'),
    (12, 'Mohamed Baqqali','P4564211','personne', '6'),
    (13, 'Soufian Boukhal','P66751217','personne', '6'),
    (14, 'Mohamed Aymane','P6675211','personne', '5'),
    (15, 'Grain Reda','P51261198','personne', '11');