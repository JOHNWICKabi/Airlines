--------------------------------------------------------
--  File created - Sunday-June-23-2024   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Procedure GETTRIPSWITHAVAILABLESEATS
--------------------------------------------------------
set define off;

  CREATE OR REPLACE NONEDITIONABLE PROCEDURE "GETTRIPSWITHAVAILABLESEATS" (
  p_from_location VARCHAR2,
  p_to_location VARCHAR2,
  p_min_available_seats NUMBER
) AS
BEGIN
  FOR trip_record IN (
    SELECT TRIP.TRIP_ID, TRIP.FROM_, TRIP.TO_, TRIP.DEPARTURE, TRIP.DEPART_TIME, TRIP.ARRIVAL_TIME, TRIP.DURATION_, SEATS.E_PRICE
    FROM TRIP
    JOIN SEATS ON TRIP.TRIP_ID = SEATS.TRIP_ID
    WHERE TRIP.FROM_ = p_from_location AND TRIP.TO_ = p_to_location AND SEATS.E_AVAILABLE > p_min_available_seats
  ) LOOP
    DBMS_OUTPUT.PUT_LINE('Trip ID: ' || trip_record.TRIP_ID || ', From: ' || trip_record.FROM_ || ', To: ' || trip_record.TO_ || ', Departure: ' || trip_record.DEPARTURE || ', Depart Time: ' || trip_record.DEPART_TIME || ', Arrival Time: ' || trip_record.ARRIVAL_TIME || ', Duration: ' || trip_record.DURATION_ || ', Economy Price: ' || trip_record.E_PRICE);
  END LOOP;
END;

/
