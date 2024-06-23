--------------------------------------------------------
--  File created - Sunday-June-23-2024   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Table CUSTOMER
--------------------------------------------------------

  CREATE TABLE "CUSTOMER" 
   (	"C_ID" NUMBER(4,0), 
	"F_NAME" VARCHAR2(50 BYTE), 
	"L_NAME" VARCHAR2(50 BYTE), 
	"ADDRESS" VARCHAR2(200 BYTE), 
	"SEX" VARCHAR2(10 BYTE), 
	"PHONE_NO" NUMBER(10,0), 
	"USER_ID" VARCHAR2(255 BYTE), 
	"USER_PWD" VARCHAR2(255 BYTE)
   ) PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
REM INSERTING into CUSTOMER
SET DEFINE OFF;
Insert into CUSTOMER (C_ID,F_NAME,L_NAME,ADDRESS,SEX,PHONE_NO,USER_ID,USER_PWD) values (1001,'KUMAR','VARMAN','Nityanand Society, J P Road, Andheri ','MALE',9843758334,'varman436','57689769');
Insert into CUSTOMER (C_ID,F_NAME,L_NAME,ADDRESS,SEX,PHONE_NO,USER_ID,USER_PWD) values (1002,'MEENA','KUMARI','180 Kukul Kunj, 11 Th Road, Khar','FEMALE',8377438223,'kum4ri','uuygu8768');
Insert into CUSTOMER (C_ID,F_NAME,L_NAME,ADDRESS,SEX,PHONE_NO,USER_ID,USER_PWD) values (1003,'ABEL','TESFAYE','42, Zaveri Building, Old Nagardas Rd, Andheri','MALE',7386534394,'theweeknd','5465gyh');
Insert into CUSTOMER (C_ID,F_NAME,L_NAME,ADDRESS,SEX,PHONE_NO,USER_ID,USER_PWD) values (1004,'SAUL','GOODMAN','9, 3rd Floor, Mangoe Lane, Bedon Street','MALE',6473957593,'jimmy','787tug');
Insert into CUSTOMER (C_ID,F_NAME,L_NAME,ADDRESS,SEX,PHONE_NO,USER_ID,USER_PWD) values (1005,'MIKE','ERMAN','1st Floor,shop-112, 52/54, Bibijan Street, Mandvi','MALE',9345834933,'mikky77','hgu777');
Insert into CUSTOMER (C_ID,F_NAME,L_NAME,ADDRESS,SEX,PHONE_NO,USER_ID,USER_PWD) values (1006,'JOHN','WICK',' 8478, Arakashan Road, Pahar Ganj','MALE',8374593845,'mydoggy','8t878');
Insert into CUSTOMER (C_ID,F_NAME,L_NAME,ADDRESS,SEX,PHONE_NO,USER_ID,USER_PWD) values (1007,'FEROZ','ADMED','2/b, Gangar House, Sv Rd, Borivli','MALE',9395345025,'iamgood454','768ygyg');
Insert into CUSTOMER (C_ID,F_NAME,L_NAME,ADDRESS,SEX,PHONE_NO,USER_ID,USER_PWD) values (1008,'HUELL','JACKMAN',' 21, Sejal Society, Fatehgunj','MALE',7394579742,'massman55','yg7g88');
Insert into CUSTOMER (C_ID,F_NAME,L_NAME,ADDRESS,SEX,PHONE_NO,USER_ID,USER_PWD) values (1009,'JON','SNOW','33, 2rd Floor, Mangoe Lane, Bedon Street,BENGALUR','MALE',7354956067,'dragonminw99','88gjhuu');
Insert into CUSTOMER (C_ID,F_NAME,L_NAME,ADDRESS,SEX,PHONE_NO,USER_ID,USER_PWD) values (1010,'abhinav','s','39,poonthotta st,mudaliarpet,puducherry-4','MALE',7604959674,'abhinav123','abhinav40');
Insert into CUSTOMER (C_ID,F_NAME,L_NAME,ADDRESS,SEX,PHONE_NO,USER_ID,USER_PWD) values (1020,'frtgdh','tyuhgt','39,poonthotta st,mudaliarpet,puducherry-4','MALE',987654321,'abhinav123','abhinav40');
Insert into CUSTOMER (C_ID,F_NAME,L_NAME,ADDRESS,SEX,PHONE_NO,USER_ID,USER_PWD) values (1031,'anish','t k','fasdlkdgjasl','MALE',9345690672,'anish2004','Voldemort');
Insert into CUSTOMER (C_ID,F_NAME,L_NAME,ADDRESS,SEX,PHONE_NO,USER_ID,USER_PWD) values (1016,'FRANSC','CHICO','40,RED STREET,BRAZIL','MALE',7603459674,'CHICO01','JORDAN');
Insert into CUSTOMER (C_ID,F_NAME,L_NAME,ADDRESS,SEX,PHONE_NO,USER_ID,USER_PWD) values (1017,'JORDAN','BELFUR','30,LEMON ST,NEW YORK','MALE',7604989857,'JORDAN01','CHICO');
Insert into CUSTOMER (C_ID,F_NAME,L_NAME,ADDRESS,SEX,PHONE_NO,USER_ID,USER_PWD) values (1018,'cyrill','sui','40,RED light STREET,BRAZIL','MALE',5795979172,'cyrill54','victor55');
Insert into CUSTOMER (C_ID,F_NAME,L_NAME,ADDRESS,SEX,PHONE_NO,USER_ID,USER_PWD) values (1019,'bala','rizzler','30,LEMON ST,kerala,NEW YORK','MALE',6785676489,'bala123','rizzly');
