DELIMITER //
CREATE TRIGGER update_discount
BEFORE INSERT ON mycart
FOR EACH ROW
BEGIN
    IF NEW.quantity > 100 THEN
        SET NEW.discount = 20;
    ELSEIF NEW.quantity > 20 THEN
        SET NEW.discount = 5;
    END IF;
END;
//
DELIMITER ;





DELIMITER //
CREATE TRIGGER update_discount_on_update
BEFORE UPDATE ON mycart
FOR EACH ROW
BEGIN
    IF NEW.quantity > 100 THEN
        SET NEW.discount = 20;
    ELSEIF NEW.quantity > 20 THEN
        SET NEW.discount = 5;
    END IF;
END;
//
DELIMITER ;




DELIMITER //

CREATE TRIGGER update_discount_on_quantity_change
BEFORE UPDATE ON mycart
FOR EACH ROW
BEGIN
    -- Check if the quantity is decreasing
    IF NEW.quantity < OLD.quantity THEN
        -- Apply discount based on the new quantity
        IF NEW.quantity <= 20 THEN
            SET NEW.discount = 0;
        ELSEIF NEW.quantity <= 100 THEN
            SET NEW.discount = 20;
        END IF;
    END IF;
END;
//
DELIMITER ;





DELIMITER //

CREATE TRIGGER check_quantity_and_delete_after_delete
AFTER DELETE ON mycart
FOR EACH ROW
BEGIN
    DECLARE prod_id INT;
    DECLARE done BOOLEAN DEFAULT FALSE;

    -- Declare cursor to select product IDs from fproduct where quantity is 0
    DECLARE cur CURSOR FOR
        SELECT pid FROM fproduct WHERE quantity = 0;

    -- Declare handler for cursor
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    -- Open the cursor
    OPEN cur;

    -- Loop through the cursor data
    read_loop: LOOP
        -- Fetch the cursor data into variables
        FETCH cur INTO prod_id;

        -- If no more rows to process, exit loop
        IF done THEN
            LEAVE read_loop;
        END IF;

        -- Check if the product ID exists in mycart
        IF NOT EXISTS (SELECT * FROM mycart WHERE pid = prod_id) THEN
            -- Delete the row from fproduct if not found in mycart
            DELETE FROM fproduct WHERE pid = prod_id;
        END IF;
    END LOOP;

    -- Close the cursor
    CLOSE cur;
END;
//

DELIMITER ;
