--------------------------------------------------------
--  File created - Sunday-June-23-2024   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Trigger UPDATE_AVAILABLE_SEATS_AFTER_DELETE
--------------------------------------------------------

  CREATE OR REPLACE NONEDITIONABLE TRIGGER "UPDATE_AVAILABLE_SEATS_AFTER_DELETE" 
AFTER DELETE ON BOOKED_TRIP
FOR EACH ROW
DECLARE
    v_class VARCHAR2(50);
BEGIN
    -- Assuming you have a column named 'class' in the BOOKED_TRIP table
    v_class := :OLD.BOOKED_CLASS;

    -- Increment available seats based on the booked class
    CASE v_class
        WHEN 'Economy' THEN
            UPDATE SEATS SET E_AVAILABLE = E_AVAILABLE + 1 WHERE TRIP_ID = :OLD.TRIP_ID;
        WHEN 'Business' THEN
            UPDATE SEATS SET B_AVAILABLE = B_AVAILABLE + 1 WHERE TRIP_ID = :OLD.TRIP_ID;
        WHEN 'First Class' THEN
            UPDATE SEATS SET F_AVAILABLE = F_AVAILABLE + 1 WHERE TRIP_ID = :OLD.TRIP_ID;
        ELSE
            -- Handle an invalid class if needed
            NULL;
    END CASE;
END;

/
ALTER TRIGGER "UPDATE_AVAILABLE_SEATS_AFTER_DELETE" ENABLE;
