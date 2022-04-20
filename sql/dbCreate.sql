/*File for the database CREATE scripts*/

/*order info table - holds shipping and billing info for an order*/
CREATE TABLE IF NOT EXISTS orderinfo (
	infoID INT NOT NULL AUTO_INCREMENT,
	recipientName VARCHAR(255) NOT NULL,
	street VARCHAR(255) NOT NULL,
	city VARCHAR(18) NOT NULL,
	stateAbbr VARCHAR(2) NOT NULL,
	zip VARCHAR(5) NOT NULL,
	isBilling BOOLEAN DEFAULT 0,
	cardNumber VARCHAR(19),
	cvc VARCHAR(4),
	expMon VARCHAR(2),
	expYear VARCHAR(4),
	PRIMARY KEY (infoID),
	/* Make sure we get all billing info if it is billing*/
	CONSTRAINT checkBilling CHECK ( NOT (isBilling AND (cardNumber IS NULL OR 
														cvc IS NULL OR 
														expMon IS NULL OR 
														expYear IS NULL)
                                        )
                                  )
);
/*users table - holds all account info for users + employees/owner*/
CREATE TABLE IF NOT EXISTS users (
	userID INT NOT NULL AUTO_INCREMENT,
	username VARCHAR(255) NOT NULL,
	pass VARCHAR(255) NOT NULL,
	email VARCHAR(255),
	isEmployee BOOLEAN DEFAULT 0,
	isOwner BOOLEAN DEFAULT 0,
	/*billing/shipping can be left out, just added them in case we want to save info down the line*/
	billingID INT,
	shippingID INT,
	PRIMARY KEY (userID),
	FOREIGN KEY (billingID) REFERENCES orderinfo (infoID),
	FOREIGN KEY (shippingID) REFERENCES orderinfo (infoID)
);

/*products table - holds all product info + inventory*/
CREATE TABLE IF NOT EXISTS products (
	prodID INT NOT NULL AUTO_INCREMENT,
	prodName VARCHAR(255) NOT NULL,
	descr TEXT NOT NULL,
	qtyAvailable INT NOT NULL,
	price DOUBLE(10,2) NOT NULL,
	imageLink VARCHAR(255) DEFAULT "https://upload.wikimedia.org/wikipedia/commons/thumb/7/7f/Replacement_character.svg/220px-Replacement_character.svg.png",
	PRIMARY KEY (prodID),
	CONSTRAINT noNegQty CHECK (qtyAvailable >= 0)
);

/*shopping cart table - tracks whats in shopping cart, cleared after an order is submitted*/
CREATE TABLE IF NOT EXISTS shoppingcart (
	userID INT NOT NULL,
	prodID INT NOT NULL,
	qty INT NOT NULL DEFAULT 0,
	PRIMARY KEY (userID, prodID),
	FOREIGN KEY (userID) REFERENCES users (userID),
	FOREIGN KEY (prodID) REFERENCES products (prodID)
);

/*orders table - connects all the info for the order together*/
CREATE TABLE IF NOT EXISTS orders (
	orderID INT NOT NULL AUTO_INCREMENT,
	userID INT NOT NULL,
	billingID INT,
	shippingID INT,
	total DOUBLE(10,2),
    notes TEXT,
    shippingNumber INT,
	orderStatus TINYINT DEFAULT 0, /*0 - checkout, 1 - order success, 2 - processing, 3 - shipped*/
	PRIMARY KEY (orderID),
	FOREIGN KEY (userID) REFERENCES users (userID),
	FOREIGN KEY (billingID) REFERENCES orderinfo (infoID),
	FOREIGN KEY (shippingID) REFERENCES orderinfo (infoID),
    /* check and make sure someone doesnt manage to checkout without creating a billing/shipping ID for order */
    CONSTRAINT preventSuccess CHECK ( NOT (orderStatus > 0 AND billingID IS NULL OR shippingID IS NULL)),
    /* check and make sure product is not shipped without giving shipping number*/
    CONSTRAINT preventShipping CHECK ( NOT (orderStatus > 2 AND shippingNumber IS NULL))
);

/*order products table - keeps track of all the products + their quantity in an order*/
CREATE TABLE IF NOT EXISTS orderproducts (
	orderID INT NOT NULL,
	prodID INT NOT NULL,
	qty INT NOT NULL,
	PRIMARY KEY (orderID, prodID),
	FOREIGN KEY (orderID) REFERENCES orders (orderID),
	FOREIGN KEY (prodID) REFERENCES products (prodID)
);
