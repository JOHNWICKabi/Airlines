--------------------------------------------------------
--  File created - Sunday-June-23-2024   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Procedure ADDTRIP
--------------------------------------------------------
set define off;

  CREATE OR REPLACE NONEDITIONABLE PROCEDURE "ADDTRIP" (
    p_flight_id VARCHAR2,
    p_from VARCHAR2,
    p_to VARCHAR2,
    p_type VARCHAR2,
    p_departure DATE,
    p_depart_time VARCHAR2,
    p_arrival_time VARCHAR2,
    p_duration NUMBER,
    p_stops NUMBER,
    p_e_price NUMBER, -- Add price parameters
    p_b_price NUMBER,
    p_f_price NUMBER
)
IS
    v_trip_id NUMBER;
    v_e_available NUMBER;
    v_b_available NUMBER;
    v_f_available NUMBER;
BEGIN
    -- Insert trip information
    INSERT INTO TRIP (
        TRIP_ID,
        FLIGHT_ID,
        FROM_,
        TO_,
        TYPE_,
        DEPARTURE,
        DEPART_TIME,
        ARRIVAL_TIME,
        DURATION_,
        STOPS
    ) VALUES (
        TRIP_SEQ.NEXTVAL,
        p_flight_id,
        p_from,
        p_to,
        p_type,
        p_departure,
        p_depart_time,
        p_arrival_time,
        p_duration,
        p_stops
    )
    RETURNING TRIP_ID INTO v_trip_id;

    -- Fetch seat information for the given flight and trip
    SELECT f.e_seats, f.b_seats, f.f_seats
    INTO v_e_available, v_b_available, v_f_available
    FROM flight f, trip t
    WHERE t.trip_id = v_trip_id AND f.flight_id = t.flight_id;

    -- Insert seat and price information
    INSERT INTO SEATS (
        TRIP_ID,
        E_AVAILABLE,
        B_AVAILABLE,
        F_AVAILABLE,
        E_PRICE,
        B_PRICE,
        F_PRICE
    ) VALUES (
        v_trip_id,
        v_e_available,
        v_b_available,
        v_f_available,
        p_e_price,
        p_b_price,
        p_f_price
    );

    COMMIT;
END;

/
