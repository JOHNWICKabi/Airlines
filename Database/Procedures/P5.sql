--------------------------------------------------------
--  File created - Sunday-June-23-2024   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Procedure DELETETRIPANDSEATS
--------------------------------------------------------
set define off;

  CREATE OR REPLACE NONEDITIONABLE PROCEDURE "DELETETRIPANDSEATS" (
  p_trip_id NUMBER
) AS
BEGIN

  DELETE FROM SEATS WHERE TRIP_ID = p_trip_id;

  DELETE FROM TRIP WHERE TRIP_ID = p_trip_id;

  COMMIT;
  DBMS_OUTPUT.PUT_LINE('Data for TRIP_ID ' || p_trip_id || ' deleted successfully.');
END;

/
