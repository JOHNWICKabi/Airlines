--------------------------------------------------------
--  File created - Sunday-June-23-2024   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Procedure DISPLAYTRIPS
--------------------------------------------------------
set define off;

  CREATE OR REPLACE NONEDITIONABLE PROCEDURE "DISPLAYTRIPS" (
  p_from_location VARCHAR2,
  p_to_location VARCHAR2,
  p_order_by VARCHAR2
) AS
BEGIN
  FOR trip_record IN (
    SELECT *
    FROM TRIP
    WHERE "FROM_" = p_from_location AND "TO_" = p_to_location
    ORDER BY CASE WHEN p_order_by = 'DURATION' THEN DURATION_ END,
             CASE WHEN p_order_by = 'DEPARTURE' THEN DEPARTURE END
  ) LOOP
    DBMS_OUTPUT.PUT_LINE('Trip ID: ' || trip_record.TRIP_ID || ', Flight ID: ' 
    || trip_record.FLIGHT_ID || ', From: ' || trip_record."FROM_" || ', To: ' || 
    trip_record."TO_" || ', Type: ' || trip_record.TYPE_ || ', Departure: ' || 
    trip_record.DEPARTURE || ', Depart Time: ' || trip_record.DEPART_TIME || 
    ', Arrival Time: ' || trip_record.ARRIVAL_TIME || ', Duration: ' || 
    trip_record.DURATION_ || ', Stops: ' || trip_record.STOPS);
  END LOOP;
END;

/
