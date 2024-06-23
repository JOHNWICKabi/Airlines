--------------------------------------------------------
--  File created - Sunday-June-23-2024   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Trigger BEFOREDELETETRIP
--------------------------------------------------------

  CREATE OR REPLACE NONEDITIONABLE TRIGGER "BEFOREDELETETRIP" 
BEFORE DELETE ON TRIP
FOR EACH ROW
DECLARE
    v_e_price NUMBER(6);
    v_b_price NUMBER(6);
    v_f_price NUMBER(6);
BEGIN
    INSERT INTO BAK (TRIP_ID, FLIGHT_ID, FROM_, TO_, TYPE_, DEPARTURE, DEPART_TIME, ARRIVAL_TIME, DURATION_, STOPS, E_PRICE, B_PRICE, F_PRICE)
    SELECT
        :OLD.TRIP_ID,
        :OLD.FLIGHT_ID,
        :OLD.FROM_,
        :OLD.TO_,
        :OLD.TYPE_,
        :OLD.DEPARTURE,
        :OLD.DEPART_TIME,
        :OLD.ARRIVAL_TIME,
        :OLD.DURATION_,
        :OLD.STOPS,
        S.E_PRICE,
        S.B_PRICE,
        S.F_PRICE
    FROM
        SEATS S
    WHERE
        S.TRIP_ID = :OLD.TRIP_ID;

    DELETE FROM SEATS WHERE TRIP_ID = :OLD.TRIP_ID;
END BeforeDeleteTrip;

/
ALTER TRIGGER "BEFOREDELETETRIP" ENABLE;
