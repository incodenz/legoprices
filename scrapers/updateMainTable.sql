INSERT INTO Lego (lego_id, title, price, createdAt, updatedAt) 
    SELECT * FROM (
        SELECT f.lego_id, f.title, ph.price, NOW() created, NOW() updated FROM Toyworld f 
        LEFT JOIN Lego l ON f.lego_id=l.lego_id
        LEFT JOIN PriceHistory ph ON f.lego_id=ph.lego_id
        WHERE l.lego_id is NULL
        ORDER BY price DESC
    ) X GROUP BY lego_id;

INSERT INTO Lego (lego_id, title, price, createdAt, updatedAt) 
    SELECT * FROM (
        SELECT f.lego_id, f.title, ph.price, NOW() created, NOW() updated FROM Warehouse f 
        LEFT JOIN Lego l ON f.lego_id=l.lego_id
        LEFT JOIN PriceHistory ph ON f.lego_id=ph.lego_id
        WHERE l.lego_id is NULL
        ORDER BY price DESC
    ) X GROUP BY lego_id;

INSERT INTO Lego (lego_id, title, price, createdAt, updatedAt) 
    SELECT * FROM (
        SELECT f.lego_id, f.title, ph.price, NOW() created, NOW() updated FROM Farmers f 
        LEFT JOIN Lego l ON f.lego_id=l.lego_id
        LEFT JOIN PriceHistory ph ON f.lego_id=ph.lego_id
        WHERE l.lego_id is NULL
        ORDER BY price DESC
    ) X GROUP BY lego_id;