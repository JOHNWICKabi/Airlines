--------------------------------------------------------
--  File created - Sunday-June-23-2024   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Procedure GET_BOOKINGS_BY_CUSTOMER
--------------------------------------------------------
set define off;

  CREATE OR REPLACE NONEDITIONABLE PROCEDURE "SYSTEM"."GET_BOOKINGS_BY_CUSTOMER" (
    p_customer_id IN NUMBER,
    p_result OUT SYS_REFCURSOR
)
AS
BEGIN
    OPEN p_result FOR
        SELECT * FROM BOOKINGS WHERE C_ID = p_customer_id;
END GET_BOOKINGS_BY_CUSTOMER;

/
