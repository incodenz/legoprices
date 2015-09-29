INSERT INTO Lego (lego_id,title,price,createdAt,updatedAt) 
    SELECT t.lego_id, t.title, t.price, NOW(), NOW() FROM Lego l
    RIGHT JOIN Farmers t
      ON t.lego_id=l.lego_id
    WHERE t.id is not null && l.id is null;
    
INSERT INTO Lego (lego_id,title,price,createdAt,updatedAt) 
    SELECT t.lego_id, t.title, t.price, NOW(), NOW() FROM Lego l
    RIGHT JOIN Warehouse t
      ON t.lego_id=l.lego_id
    WHERE t.id is not null && l.id is null;    
    
INSERT INTO Lego (lego_id,title,price,createdAt,updatedAt) 
    SELECT t.lego_id, t.title, t.price, NOW(), NOW() FROM Lego l
    RIGHT JOIN Toyworld t
      ON t.lego_id=l.lego_id
    WHERE t.id is not null && l.id is null;