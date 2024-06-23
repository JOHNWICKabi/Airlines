--------------------------------------------------------
--  File created - Sunday-June-23-2024   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Procedure GETSEATCOUNT
--------------------------------------------------------
set define off;

  CREATE OR REPLACE NONEDITIONABLE PROCEDURE "GETSEATCOUNT" (
    p_trip_id NUMBER,
    p_class VARCHAR2,
    p_seat_count OUT NUMBER
)
IS
BEGIN
    -- Initialize the seat count
    p_seat_count := 0;

    -- Check the class and execute the corresponding query
    IF p_class = 'Economy' THEN
        SELECT F.E_SEATS
        INTO p_seat_count
        FROM FLIGHT F, TRIP T
        WHERE F.FLIGHT_ID = T.FLIGHT_ID AND T.TRIP_ID = p_trip_id;
    ELSIF p_class = 'Business' THEN
        SELECT F.B_SEATS
        INTO p_seat_count
        FROM FLIGHT F, TRIP T
        WHERE F.FLIGHT_ID = T.FLIGHT_ID AND T.TRIP_ID = p_trip_id;
    ELSIF p_class = 'First Class' THEN
        SELECT F.F_SEATS
        INTO p_seat_count
        FROM FLIGHT F, TRIP T
        WHERE F.FLIGHT_ID = T.FLIGHT_ID AND T.TRIP_ID = p_trip_id;
    ELSE
        -- Handle invalid class (you may choose to raise an exception or set a default value)
        DBMS_OUTPUT.PUT_LINE('Invalid class provided');
    END IF;
END;

/
