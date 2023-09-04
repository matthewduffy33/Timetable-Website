
Drop DATABASE timetable;
CREATE DATABASE timetable;
USE `timetable`;



CREATE TABLE Classes(
	ClassID VARCHAR(5),
	ClassName VARCHAR(50),
	LecturerName VARCHAR(50),
    PRIMARY KEY (ClassID)
);



CREATE TABLE Type(
    TypeID Varchar(12),
	ClassID VARCHAR(5),
    TypeOfSession Varchar(8),
    MultipleSessions Bit,
    PRIMARY KEY(TypeID),
    Foreign Key (ClassID) REFERENCES Classes(ClassID)
);

CREATE TABLE Sessions(
	SessionID Int NOT NULL AUTO_INCREMENT,
    TypeID Varchar(12),
	WhichDay Varchar(10),
	StartTime Time,
    EndTime Time,
    Room Varchar(40),
    PRIMARY KEY(SessionID),
    Foreign Key (TypeID) REFERENCES Type(TypeID) ON DELETE CASCADE
);

CREATE TABLE Courses(
    CourseName VARCHAR(30),
    AmountOfYears INTEGER,
    PlacementYear INTEGER,
    PRIMARY KEY (CourseName)
);

CREATE TABLE CourseYears(
    YearID VARCHAR(5) /*AUTO_INCREMENT*/,
    CourseName VARCHAR(30),
    Year INTEGER,
    PRIMARY KEY(YearID),
    FOREIGN KEY (CourseName) REFERENCES Courses(CourseName) ON DELETE CASCADE
);

CREATE TABLE CourseSubjects(
    YearID VARCHAR(5),
    ClassID VARCHAR(5),
    PRIMARY KEY(YearID, ClassID),
    FOREIGN KEY (YearID) REFERENCES CourseYears(YearID) ON DELETE CASCADE,
    FOREIGN KEY (ClassID) REFERENCES Classes(ClassID) ON DELETE CASCADE
);

