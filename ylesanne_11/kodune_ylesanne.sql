--Kodune ülesanne

--Tabeli tekitamine
CREATE TABLE Jkind_loomaaed (
	id integer PRIMARY KEY auto_increment,
	nimi varchar(100) NOT NULL, 
	vanus integer,
	liik varchar(100) NOT NULL,
	puur integer
);

--Andmete lisamine

INSERT INTO Jkind_loomaaed (nimi, vanus, liik, puur) VALUES 
('Jumbo', 8, 'elevant', 4),
('Katrin', 2, 'tiiger', 1),
('Olivia', 3, 'jõehobu', 4),
('Saskia', 1, 'hiir', 1),
('Roberto', 11, 'hunt', 3),
('Oliver', 4, 'tiiger', 2),
('Veneetsia', 3, 'rebane', 5),
('Paganel', 5, 'rebane', 5);


--Päringute koostamine

--mingis ühes kindlas puuris elavate loomade nimi ja puuri nr
SELECT nimi, puur FROM Jkind_loomaaed WHERE puur='4';

--vanima ja noorima looma vanused
SELECT MAX(vanus) FROM Jkind_loomaaed;
SELECT MIN(vanus) FROM Jkind_loomaaed;

--hankida puuri nr koos selles elavate loomade arvuga (vihjeks: group by ja count )

SELECT puur, COUNT(puur) AS loomi FROM Jkind_loomaaed GROUP BY puur;

--suurendada kõiki tabelis olevaid vanuseid 1 aasta võrra
UPDATE Jkind_loomaaed SET vanus=vanus+1;



