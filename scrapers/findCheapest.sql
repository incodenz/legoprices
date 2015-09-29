SELECT * FROM 
    (
    select  lego_id, title, RRP, min(price), RRP - min(price) saving, source  
    FROM 
        ( /*
            SELECT 
                l.lego_id, l.title lego_title, t.title, l.price RRP, t.price, 'trademe' source 
                FROM `Trademe` t  
                JOIN Lego l 
                    ON t.lego_id=l.lego_id 
                WHERE t.price < l.price     
            UNION */ 
            SELECT l.lego_id, l.title lego_title, t.title, l.price RRP, t.price, 'toyworld' source 
                FROM `Toyworld` t  
                JOIN Lego l 
                    ON t.lego_id=l.lego_id 
                WHERE t.price < l.price     
            UNION 
            SELECT l.lego_id, l.title lego_title, w.title, l.price RRP, w.price, 'warehouse' source 
                FROM `Warehouse` w  
                JOIN Lego l 
                    ON w.lego_id=l.lego_id 
                WHERE w.price < l.price     
            UNION 
            SELECT l.lego_id, l.title lego_title, f.title, l.price RRP, f.price, 'farmers' source 
                FROM `Farmers` f  
                JOIN Lego l 
                    ON f.lego_id=l.lego_id 
                WHERE f.price < l.price  
        ) xx 
        GROUP BY lego_id
    ) v 
ORDER BY saving;
