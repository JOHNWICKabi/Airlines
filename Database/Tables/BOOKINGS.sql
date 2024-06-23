--------------------------------------------------------
--  File created - Sunday-June-23-2024   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Table BOOKINGS
--------------------------------------------------------

  CREATE TABLE "SYSTEM"."BOOKINGS" 
   (	"B_ID" VARCHAR2(10 BYTE), 
	"C_ID" NUMBER(4,0), 
	"NO_OF_TICKETS" NUMBER(1,0), 
	"B_DATE" DATE, 
	"STATUS" VARCHAR2(50 BYTE), 
	"CHECKIN" VARCHAR2(3 BYTE) DEFAULT 'NO', 
	"CLASS" VARCHAR2(50 BYTE), 
	"TOTAL_PAYMENT" NUMBER(10,2), 
	"TRIP_ID" NUMBER(3,0)
   ) PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
REM INSERTING into SYSTEM.BOOKINGS
SET DEFINE OFF;
Insert into SYSTEM.BOOKINGS (B_ID,C_ID,NO_OF_TICKETS,B_DATE,STATUS,CHECKIN,CLASS,TOTAL_PAYMENT,TRIP_ID) values ('YFGT15',1004,4,to_date('02-NOV-23','DD-MON-RR'),'REFUND','YES','Economy',11000,200);
Insert into SYSTEM.BOOKINGS (B_ID,C_ID,NO_OF_TICKETS,B_DATE,STATUS,CHECKIN,CLASS,TOTAL_PAYMENT,TRIP_ID) values ('YBIR17',1001,6,to_date('03-NOV-23','DD-MON-RR'),'BOOKED','NO','Economy',22000,112);
Insert into SYSTEM.BOOKINGS (B_ID,C_ID,NO_OF_TICKETS,B_DATE,STATUS,CHECKIN,CLASS,TOTAL_PAYMENT,TRIP_ID) values ('SAHF56',1009,1,to_date('03-NOV-23','DD-MON-RR'),'REFUND','NO','Business',5000,112);
Insert into SYSTEM.BOOKINGS (B_ID,C_ID,NO_OF_TICKETS,B_DATE,STATUS,CHECKIN,CLASS,TOTAL_PAYMENT,TRIP_ID) values ('JFFI83',1017,2,to_date('04-NOV-23','DD-MON-RR'),'REFUND','NO','Business',10000,115);
Insert into SYSTEM.BOOKINGS (B_ID,C_ID,NO_OF_TICKETS,B_DATE,STATUS,CHECKIN,CLASS,TOTAL_PAYMENT,TRIP_ID) values ('BIET11',1003,3,to_date('05-NOV-23','DD-MON-RR'),'BOOKED','NO','First Class',27000,201);
Insert into SYSTEM.BOOKINGS (B_ID,C_ID,NO_OF_TICKETS,B_DATE,STATUS,CHECKIN,CLASS,TOTAL_PAYMENT,TRIP_ID) values ('JIST45',1006,2,to_date('06-NOV-23','DD-MON-RR'),'BOOKED','NO','Economy',6700,200);
Insert into SYSTEM.BOOKINGS (B_ID,C_ID,NO_OF_TICKETS,B_DATE,STATUS,CHECKIN,CLASS,TOTAL_PAYMENT,TRIP_ID) values ('KLPW28',1010,5,to_date('07-NOV-23','DD-MON-RR'),'BOOKED','YES','Economy',15000,112);
Insert into SYSTEM.BOOKINGS (B_ID,C_ID,NO_OF_TICKETS,B_DATE,STATUS,CHECKIN,CLASS,TOTAL_PAYMENT,TRIP_ID) values ('UWFI73',1010,3,to_date('07-NOV-23','DD-MON-RR'),'REFUND','NO','Economy',10000,112);
Insert into SYSTEM.BOOKINGS (B_ID,C_ID,NO_OF_TICKETS,B_DATE,STATUS,CHECKIN,CLASS,TOTAL_PAYMENT,TRIP_ID) values ('100009',1010,2,to_date('29-JAN-24','DD-MON-RR'),'BOOKED','NO','First Class',9450,112);
Insert into SYSTEM.BOOKINGS (B_ID,C_ID,NO_OF_TICKETS,B_DATE,STATUS,CHECKIN,CLASS,TOTAL_PAYMENT,TRIP_ID) values ('100010',1010,2,to_date('29-JAN-24','DD-MON-RR'),'BOOKED','NO','First Class',9450,112);
Insert into SYSTEM.BOOKINGS (B_ID,C_ID,NO_OF_TICKETS,B_DATE,STATUS,CHECKIN,CLASS,TOTAL_PAYMENT,TRIP_ID) values ('100008',1010,1,to_date('27-JAN-24','DD-MON-RR'),'BOOKED','NO','Economy',3420,112);
Insert into SYSTEM.BOOKINGS (B_ID,C_ID,NO_OF_TICKETS,B_DATE,STATUS,CHECKIN,CLASS,TOTAL_PAYMENT,TRIP_ID) values ('100011',1010,4,to_date('29-JAN-24','DD-MON-RR'),'BOOKED','NO','Business',12000,112);
Insert into SYSTEM.BOOKINGS (B_ID,C_ID,NO_OF_TICKETS,B_DATE,STATUS,CHECKIN,CLASS,TOTAL_PAYMENT,TRIP_ID) values ('100012',1010,1,to_date('30-JAN-24','DD-MON-RR'),'BOOKED','NO','Business',4230,207);
Insert into SYSTEM.BOOKINGS (B_ID,C_ID,NO_OF_TICKETS,B_DATE,STATUS,CHECKIN,CLASS,TOTAL_PAYMENT,TRIP_ID) values ('100013',1010,1,to_date('30-JAN-24','DD-MON-RR'),'BOOKED','NO','Business',4230,207);
Insert into SYSTEM.BOOKINGS (B_ID,C_ID,NO_OF_TICKETS,B_DATE,STATUS,CHECKIN,CLASS,TOTAL_PAYMENT,TRIP_ID) values ('100014',1010,2,to_date('15-MAY-24','DD-MON-RR'),'BOOKED','NO','Economy',6000,206);
Insert into SYSTEM.BOOKINGS (B_ID,C_ID,NO_OF_TICKETS,B_DATE,STATUS,CHECKIN,CLASS,TOTAL_PAYMENT,TRIP_ID) values ('100015',1010,2,to_date('25-MAY-24','DD-MON-RR'),'BOOKED','NO','Economy',6000,206);
Insert into SYSTEM.BOOKINGS (B_ID,C_ID,NO_OF_TICKETS,B_DATE,STATUS,CHECKIN,CLASS,TOTAL_PAYMENT,TRIP_ID) values ('100016',1010,2,to_date('21-JUN-24','DD-MON-RR'),'BOOKED','NO','First Class',9450,112);
Insert into SYSTEM.BOOKINGS (B_ID,C_ID,NO_OF_TICKETS,B_DATE,STATUS,CHECKIN,CLASS,TOTAL_PAYMENT,TRIP_ID) values ('100017',1031,2,to_date('21-JUN-24','DD-MON-RR'),'BOOKED','YES','Economy',6000,206);
--------------------------------------------------------
--  DDL for Trigger UPDATE_AVAILABLE_SEATS
--------------------------------------------------------

  CREATE OR REPLACE NONEDITIONABLE TRIGGER "SYSTEM"."UPDATE_AVAILABLE_SEATS" 
AFTER INSERT ON BOOKINGS
FOR EACH ROW
DECLARE
    v_class VARCHAR2(50);
BEGIN
    -- Assuming you have a column named 'class' in the BOOKINGS table
    v_class := :NEW.CLASS;

    -- Update available seats based on the booked class
    CASE v_class
        WHEN 'Economy' THEN
            UPDATE SEATS SET E_AVAILABLE = E_AVAILABLE - :NEW.NO_OF_TICKETS WHERE TRIP_ID = :NEW.TRIP_ID;
        WHEN 'Business' THEN
            UPDATE SEATS SET B_AVAILABLE = B_AVAILABLE - :NEW.NO_OF_TICKETS WHERE TRIP_ID = :NEW.TRIP_ID;
        WHEN 'First Class' THEN
            UPDATE SEATS SET F_AVAILABLE = F_AVAILABLE - :NEW.NO_OF_TICKETS WHERE TRIP_ID = :NEW.TRIP_ID;
        ELSE
            -- Handle an invalid class if needed
            NULL;
    END CASE;
END;

/
ALTER TRIGGER "SYSTEM"."UPDATE_AVAILABLE_SEATS" ENABLE;
