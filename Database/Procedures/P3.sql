--------------------------------------------------------
--  File created - Sunday-June-23-2024   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Procedure CHECKFLIGHTSTATUS
--------------------------------------------------------
set define off;

  CREATE OR REPLACE NONEDITIONABLE PROCEDURE "CHECKFLIGHTSTATUS" (
    p_flight_id VARCHAR2,
    p_departure_date DATE
) AS
BEGIN
    FOR trip_record IN (
        SELECT *
        FROM TRIP
        WHERE FLIGHT_ID = p_flight_id AND TRUNC(DEPARTURE) = TRUNC(p_departure_date)
    ) LOOP
        DBMS_OUTPUT.PUT_LINE(
            'Trip ID: ' || trip_record.TRIP_ID ||
            ', Flight ID: ' || trip_record.FLIGHT_ID ||
            ', Departure: ' || trip_record.DEPARTURE ||
            ', Depart Time: ' || trip_record.DEPART_TIME ||
            ', Arrival Time: ' || trip_record.ARRIVAL_TIME ||
            ', Duration: ' || trip_record.DURATION_ ||
            ', Stops: ' || trip_record.STOPS /* Replace 'STOPS' with the correct column name */
        );
    END LOOP;
END;

/
