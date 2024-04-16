CREATE Database IF NOT EXISTS banking;
USE banking;

CREATE TABLE Customers (
        CustomerID INT AUTO_INCREMENT PRIMARY KEY,
        FirstName VARCHAR(100),
        LastName VARCHAR(100),
        Email   VARCHAR(100),
        PhoneNumber VARCHAR(15),
        username VARCHAR(100),
        password VARCHAR(25)
);

CREATE TABLE Accounts (
        AccountID INT AUTO_INCREMENT PRIMARY KEY,
        CustomerID INT,
        AccountType VARCHAR(50),
        Balance Decimal(15, 2),
        FOREIGN KEY (CustomerID) REFERENCES Customers(CustomerID)
);

CREATE TABLE Transactions (
        TransactionID INT AUTO_INCREMENT PRIMARY KEY,
        AccountID INT,
        Amount DECIMAL(15, 2),
        TransactionDate DATE,
        Description TEXT,
        FOREIGN KEY (AccountID) REFERENCES Accounts(AccountID)
);

