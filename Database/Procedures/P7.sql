--------------------------------------------------------
--  File created - Sunday-June-23-2024   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Procedure FINDUSERTRIPS
--------------------------------------------------------
set define off;

  CREATE OR REPLACE NONEDITIONABLE PROCEDURE "FINDUSERTRIPS" (
    p_from IN VARCHAR2,
    p_to IN VARCHAR2,
    p_departureDate IN DATE,
    p_cursor OUT SYS_REFCURSOR
)
AS
BEGIN
    OPEN p_cursor FOR
    SELECT 
        T.TRIP_ID,
        T.FLIGHT_ID,
        T.FROM_,
        T.TO_,
        T.DEPARTURE,
        T.DEPART_TIME,
        T.ARRIVAL_TIME,
        T.DURATION_,
        T.STOPS,
        S.E_PRICE,
        S.B_PRICE,
        S.F_PRICE
    FROM 
        TRIP T
    JOIN 
        SEATS S ON T.TRIP_ID = S.TRIP_ID
    WHERE 
        T.FROM_ = p_from AND
        T.TO_ = p_to AND
        T.DEPARTURE = p_departureDate;
END FindUserTrips;

/
