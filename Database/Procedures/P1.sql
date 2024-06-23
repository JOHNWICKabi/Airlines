--------------------------------------------------------
--  File created - Sunday-June-23-2024   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Procedure ADDFLIGHT
--------------------------------------------------------
set define off;

  CREATE OR REPLACE NONEDITIONABLE PROCEDURE "ADDFLIGHT" (
    p_flight_id VARCHAR2,
    p_flight_type VARCHAR2,
    p_seats NUMBER,
    p_flight_weight NUMBER,
    p_e_seats NUMBER,
    p_b_seats NUMBER,
    p_f_seats NUMBER
)
IS
BEGIN
    INSERT INTO FLIGHT (
        FLIGHT_ID,
        FLIGHT_TYPE,
        SEATS,
        FLIGHT_WEIGHT,
        E_SEATS,
        B_SEATS,
        F_SEATS
    ) VALUES (
        p_flight_id,
        p_flight_type,
        p_seats,
        p_flight_weight,
        p_e_seats,
        p_b_seats,
        p_f_seats
    );
    COMMIT;
END;

/
