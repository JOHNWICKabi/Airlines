--------------------------------------------------------
--  File created - Sunday-June-23-2024   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Procedure DELETE_TRIP
--------------------------------------------------------
set define off;

  CREATE OR REPLACE NONEDITIONABLE PROCEDURE "DELETE_TRIP" (
    p_trip_id NUMBER
) AS
BEGIN
    DELETE FROM TRIP WHERE TRIP_ID = p_trip_id;
    COMMIT;
END DELETE_TRIP;

/
