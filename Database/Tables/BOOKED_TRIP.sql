--------------------------------------------------------
--  File created - Sunday-June-23-2024   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Table BOOKED_TRIP
--------------------------------------------------------

  CREATE TABLE "BOOKED_TRIP" 
   (	"C_ID" NUMBER(4,0), 
	"TRIP_ID" NUMBER(3,0), 
	"SEAT_NO" NUMBER(3,0), 
	"BOOKED_CLASS" VARCHAR2(30 BYTE)
   ) PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
REM INSERTING into BOOKED_TRIP
SET DEFINE OFF;
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1001,112,4,'Economy');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1001,112,70,'Economy');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1001,112,50,'Economy');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1010,112,4,'First Class');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1017,114,32,'Business');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1003,201,4,'First Class');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1003,201,23,'First Class');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1003,201,24,'First Class');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1006,200,67,'Economy');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1010,117,12,'Economy');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1010,119,44,'First Class');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1017,114,11,'Business');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1006,200,40,'Economy');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1001,112,2,'Economy');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1001,112,3,'Economy');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1001,112,5,'Economy');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1010,112,39,'Economy');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1010,112,40,'Economy');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1010,112,20,'Economy');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1010,112,61,'Economy');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1010,112,62,'Economy');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1010,112,38,'Economy');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1010,112,21,'Economy');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1010,112,22,'Economy');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1010,112,3,'First Class');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1010,112,1,'Economy');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1010,112,1,'First Class');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1010,112,2,'First Class');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1010,112,1,'Business');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1010,112,2,'Business');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1010,112,6,'Business');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1010,112,7,'Business');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1010,207,1,'Business');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1010,207,2,'Business');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1010,206,4,'Economy');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1010,206,5,'Economy');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1010,206,50,'Economy');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1010,206,49,'Economy');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1010,112,4,'First Class');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1010,112,10,'First Class');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1031,206,29,'Economy');
Insert into BOOKED_TRIP (C_ID,TRIP_ID,SEAT_NO,BOOKED_CLASS) values (1031,206,22,'Economy');
--------------------------------------------------------
--  DDL for Trigger UPDATE_AVAILABLE_SEATS_AFTER_DELETE
--------------------------------------------------------

  CREATE OR REPLACE NONEDITIONABLE TRIGGER "UPDATE_AVAILABLE_SEATS_AFTER_DELETE" 
AFTER DELETE ON BOOKED_TRIP
FOR EACH ROW
DECLARE
    v_class VARCHAR2(50);
BEGIN
    -- Assuming you have a column named 'class' in the BOOKED_TRIP table
    v_class := :OLD.BOOKED_CLASS;

    -- Increment available seats based on the booked class
    CASE v_class
        WHEN 'Economy' THEN
            UPDATE SEATS SET E_AVAILABLE = E_AVAILABLE + 1 WHERE TRIP_ID = :OLD.TRIP_ID;
        WHEN 'Business' THEN
            UPDATE SEATS SET B_AVAILABLE = B_AVAILABLE + 1 WHERE TRIP_ID = :OLD.TRIP_ID;
        WHEN 'First Class' THEN
            UPDATE SEATS SET F_AVAILABLE = F_AVAILABLE + 1 WHERE TRIP_ID = :OLD.TRIP_ID;
        ELSE
            -- Handle an invalid class if needed
            NULL;
    END CASE;
END;

/
ALTER TRIGGER "UPDATE_AVAILABLE_SEATS_AFTER_DELETE" ENABLE;
