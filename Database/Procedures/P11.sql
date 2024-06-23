--------------------------------------------------------
--  File created - Sunday-June-23-2024   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Procedure GETTRIPDETAILSWITHPRICES
--------------------------------------------------------
set define off;

  CREATE OR REPLACE NONEDITIONABLE PROCEDURE "GETTRIPDETAILSWITHPRICES" (
    p_departure_date DATE,
    p_from VARCHAR2,
    p_to VARCHAR2,
    p_cursor OUT SYS_REFCURSOR
)
IS
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
        S.F_PRICE,
        F.FLIGHT_TYPE,
        F.SEATS,
        F.FLIGHT_WEIGHT,
        S.E_AVAILABLE,
        S.B_AVAILABLE,
        S.F_AVAILABLE
    FROM
        TRIP T
        JOIN SEATS S ON T.TRIP_ID = S.TRIP_ID
        JOIN FLIGHT F ON T.FLIGHT_ID = F.FLIGHT_ID
    WHERE
        T.FROM_ = p_from
        AND T.TO_ = p_to
        AND T.DEPARTURE = p_departure_date;
END;

/
