--------------------------------------------------------
--  File created - Sunday-June-23-2024   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Procedure SEARCHTRIPS
--------------------------------------------------------
set define off;

  CREATE OR REPLACE NONEDITIONABLE PROCEDURE "SEARCHTRIPS" (
    p_from VARCHAR2,
    p_to VARCHAR2,
    p_departure_date DATE,
    p_cursor OUT SYS_REFCURSOR
)
IS
BEGIN
    OPEN p_cursor FOR
        SELECT * 
        FROM trip
        WHERE FROM_ = p_from AND TO_ = p_to AND TRUNC(DEPARTURE) = TRUNC(p_departure_date);
END;

/
