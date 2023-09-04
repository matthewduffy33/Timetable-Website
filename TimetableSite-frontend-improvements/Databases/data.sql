USE `timetable`;

INSERT INTO Classes
VALUES ("CS207","Advanced Programming","Isla Ross & Martin Goodfellow");

INSERT INTO Classes
VALUES ("CS208","Logic and Algorithms","Robert Atkey & Isla Ross & John Levine");

INSERT INTO Classes
VALUES ("CS209","User and Data Modelling","Gennaro Imperatore & Clemens Kupke");

INSERT INTO Classes
VALUES ("CS210","Computer Systems and Architecture","John Levine & Georgi Nakov");

INSERT INTO Classes
VALUES ("CS260","Functional Thinking","Alasdair Lambert & Jules Hedges");

INSERT INTO Type
VALUES("207Lab", "CS207", "Lab", 1);

INSERT INTO Type
VALUES("207Lecture", "CS207", "Lecture", 0);

INSERT INTO Type
VALUES("208Tut", "CS208", "Tutorial", 1);

INSERT INTO Type
VALUES("208Lecture", "CS208", "Lecture", 0);

INSERT INTO Type
VALUES("209Lecture", "CS209", "Lecture", 0);

INSERT INTO Type
VALUES("210Lecture", "CS210", "Lecture", 0);

INSERT INTO Type
VALUES("260Lecture", "CS260", "Lecture", 0);

INSERT INTO Type
VALUES("210Lab", "CS210", "Lab", 1);

INSERT INTO Sessions
VALUES(NULL,"207Lab","Monday","09:00","11:00","LT1105");

INSERT INTO Sessions
VALUES(NULL,"207Lab","Monday","11:00","13:00","LT1105");

INSERT INTO Sessions
VALUES(NULL,"207Lab","Thursday","11:00","13:00","LT1301");

INSERT INTO Sessions
VALUES(NULL,"208Tut","Tuesday","12:00","13:00","TG223");

INSERT INTO Sessions
VALUES(NULL,"208Tut","Tuesday","16:00","17:00","RC540");

INSERT INTO Sessions
VALUES(NULL,"210Lab","Tuesday","09:00","11:00","LT1105");

INSERT INTO Sessions
VALUES(NULL,"210Lab","Tuesday","11:00","13:00","LT1320");

INSERT INTO Sessions
VALUES(NULL,"210Lab","Thursday","09:00","11:00","LT1201");

INSERT INTO Sessions
VALUES(NULL,"208Lecture","Tuesday","15:00","16:00","GH514");

INSERT INTO Sessions
VALUES(NULL,"208Lecture","Thursday","15:00","16:00","GH514");

INSERT INTO Sessions
VALUES(NULL,"210Lecture","Monday","14:00","15:00","RC512");

INSERT INTO Sessions
VALUES(NULL,"209Lecture","Monday","15:00","17:00","RC471");

INSERT INTO Sessions
VALUES(NULL,"207Lecture","Tuesday","14:00","15:00","GH514");

INSERT INTO Sessions
VALUES(NULL,"260Lecture","Wednesday","10:00","11:00","RC512");

INSERT INTO Sessions
VALUES(NULL,"207Lecture","Thursday","14:00","15:00","UC317");

INSERT INTO Sessions
VALUES(NULL,"209Lecture","Friday","11:00","12:00","JA314");

INSERT INTO Sessions
VALUES(NULL,"210Lecture","Friday","12:00","13:00","RC512");

INSERT INTO Courses
VALUES("Software Engineering", 5, 4);

INSERT INTO Courses
VALUES("Computing Science", 4, NULL);

INSERT INTO CourseYears
VALUES(1, "Computing Science", 1);

INSERT INTO CourseYears
VALUES(2, "Computing Science", 2);

INSERT INTO CourseYears
VALUES(3, "Computing Science", 3);

INSERT INTO CourseYears
VALUES(4, "Computing Science", 4);

INSERT INTO CourseSubjects
VALUES(2, "CS207");

INSERT INTO CourseSubjects
VALUES(2, "CS208");

INSERT INTO CourseSubjects
VALUES(2, "CS209");

INSERT INTO CourseSubjects
VALUES(2, "CS210");

INSERT INTO CourseSubjects
VALUES(2, "CS260");