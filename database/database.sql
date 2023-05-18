CREATE TABLE User (
    "UserId" INTEGER PRIMARY KEY AUTOINCREMENT,
    "FirstName" TEXT(40) NOT NULL,
    "LastName" TEXT(20) NOT NULL,
    "City" TEXT(40),
    "Country" TEXT(40),
    "Phone" TEXT(24),
    "Email" TEXT(60) NOT NULL,
    "Password" TEXT(72) NOT NULL,
    "Privilege" TEXT(32) NOT NULL,
    "Department" TEXT(32)
);


CREATE TABLE Ticket (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT,
    "client_id" INTEGER NOT NULL,
    "title" TEXT NOT NULL,
    "desc" TEXT NOT NULL,
    "datetime" TIMESTAMP NOT NULL,
    FOREIGN KEY(client_id) REFERENCES User(UserId)
);

CREATE TABLE Message (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT,
    "ticket_id" INTEGER NOT NULL,
    "sender_id" INTEGER NOT NULL,
    "message" TEXT NOT NULL,
    "datetime" TIMESTAMP NOT NULL,
    FOREIGN KEY(ticket_id) REFERENCES Ticket(id),
    FOREIGN KEY(sender_id) REFERENCES User(UserId)
);

CREATE TABLE Attachment (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT,
    "message_id" INTEGER NOT NULL,
    "filename" TEXT NOT NULL,
    "file" BLOB NOT NULL,
    FOREIGN KEY(message_id) REFERENCES Message(id)
);

CREATE TABLE Status (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT,
    "ticket_id" INTEGER NOT NULL,
    "agent_id" INTEGER NOT NULL,
    "admin_id" INTEGER,
    "status" TEXT NOT NULL,
    "priority" TEXT NOT NULL,
    "datetime" TIMESTAMP NOT NULL,
    FOREIGN KEY(agent_id) REFERENCES User(UserId),
    FOREIGN KEY(admin_id) REFERENCES User(UserId)
);