--------------------------------------------------------
--  File created - Sunday-June-23-2024   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Trigger TRG_DELETE_SEATS
--------------------------------------------------------

  CREATE OR REPLACE NONEDITIONABLE TRIGGER "TRG_DELETE_SEATS" 
AFTER DELETE ON TRIP
FOR EACH ROW
BEGIN
    DELETE FROM SEATS WHERE TRIP_ID = :OLD.TRIP_ID;
END;

/
ALTER TRIGGER "TRG_DELETE_SEATS" ENABLE;
