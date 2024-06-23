--------------------------------------------------------
--  File created - Sunday-June-23-2024   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Procedure GETBOOKEDSEATS
--------------------------------------------------------
set define off;

  CREATE OR REPLACE NONEDITIONABLE PROCEDURE "GETBOOKEDSEATS" (
    p_trip_id NUMBER,
    p_class VARCHAR2,
    p_cursor OUT SYS_REFCURSOR
)
IS
BEGIN
    OPEN p_cursor FOR
    SELECT SEAT_NO
    FROM BOOKED_TRIP
    WHERE TRIP_ID = p_trip_id AND BOOKED_CLASS = p_class;
END;

/
