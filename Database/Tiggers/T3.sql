--------------------------------------------------------
--  File created - Sunday-June-23-2024   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Trigger UPDATE_AVAILABLE_SEATS
--------------------------------------------------------

  CREATE OR REPLACE NONEDITIONABLE TRIGGER "UPDATE_AVAILABLE_SEATS" 
AFTER INSERT ON BOOKINGS
FOR EACH ROW
DECLARE
    v_class VARCHAR2(50);
BEGIN
    
    v_class := :NEW.CLASS;

    CASE v_class
        WHEN 'Economy' THEN
            UPDATE SEATS SET E_AVAILABLE = E_AVAILABLE - :NEW.NO_OF_TICKETS WHERE TRIP_ID = :NEW.TRIP_ID;
        WHEN 'Business' THEN
            UPDATE SEATS SET B_AVAILABLE = B_AVAILABLE - :NEW.NO_OF_TICKETS WHERE TRIP_ID = :NEW.TRIP_ID;
        WHEN 'First Class' THEN
            UPDATE SEATS SET F_AVAILABLE = F_AVAILABLE - :NEW.NO_OF_TICKETS WHERE TRIP_ID = :NEW.TRIP_ID;
        ELSE
            -- Handle an invalid class if needed
            NULL;
    END CASE;
END;

/
ALTER TRIGGER "UPDATE_AVAILABLE_SEATS" ENABLE;
