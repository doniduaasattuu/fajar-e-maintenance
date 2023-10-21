DROP DATABASE fajar_e_maintenance;
USE fajar_e_maintenance;
SHOW TABLES;

-- SELECT --
SELECT * FROM function_locations;
SELECT * FROM emos;
SELECT * FROM emo_details;
SELECT * FROM data_records;
SELECT * FROM users;
-----------------------

-- SHOW CREATE TABLE --
SHOW CREATE TABLE function_locations;
SHOW CREATE TABLE emos;
SHOW CREATE TABLE emo_details;
SHOW CREATE TABLE data_records;
SHOW CREATE TABLE users;
-----------------------

-- DELETE FROM TABLE --
DELETE FROM function_locations;
DELETE FROM emos;
DELETE FROM emo_details;
DELETE FROM data_records;
DELETE FROM users;
-----------------------