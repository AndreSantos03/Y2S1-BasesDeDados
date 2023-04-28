CREATE TABLE user (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT,
    "name" TEXT NOT NULL,
    "username" TEXT NOT NULL UNIQUE,
    "email" TEXT NOT NULL UNIQUE,
    "password" TEXT NOT NULL,
    "privilege_id" INTEGER NOT NULL,
    FOREIGN KEY(privilege_id) REFERENCES Privilege(id)
);

CREATE TABLE privilege (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT,
    "name" TEXT NOT NULL,
    "department" TEXT
);

CREATE TABLE ticket (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT,
    "client_id" INTEGER NOT NULL,
    "status_id" INTEGER NOT NULL,
    "last_message_id" INTEGER,
    FOREIGN KEY(client_id) REFERENCES User(id),
    FOREIGN KEY(status_id) REFERENCES Status(id),
    FOREIGN KEY(last_message_id) REFERENCES Message(id)
);

CREATE TABLE message (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT,
    "ticket_id" INTEGER NOT NULL,
    "sender_id" INTEGER NOT NULL,
    "message" TEXT NOT NULL,
    "datetime" TIMESTAMP NOT NULL,
    FOREIGN KEY(ticket_id) REFERENCES Ticket(id),
    FOREIGN KEY(sender_id) REFERENCES User(id)
);

CREATE TABLE attachment (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT,
    "message_id" INTEGER NOT NULL,
    "filename" TEXT NOT NULL,
    "file" BLOB NOT NULL,
    FOREIGN KEY(message_id) REFERENCES Message(id)
);

CREATE TABLE status (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT,
    "ticket_id" INTEGER NOT NULL,
    "agent_id" INTEGER NOT NULL,
    "admin_id" INTEGER,
    "status" TEXT NOT NULL,
    "priority" TEXT NOT NULL,
    "datetime" TIMESTAMP NOT NULL,
    FOREIGN KEY(ticket_id) REFERENCES Ticket(id),
    FOREIGN KEY(agent_id) REFERENCES User(id),
    FOREIGN KEY(admin_id) REFERENCES User(id)
);