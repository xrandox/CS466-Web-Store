/* 
proof of concept example flow 
obviously most of the numbers will be variables in the actual code, but this is just to demonstrate the workflow
*/

/*Products get added either by us or potentially create a web page for the owner to add products*/
INSERT INTO products (prodName, descr, qtyAvailable, price)
VALUES ("Mystery Box", "N/A", 5, 5.00),
("Mystery Box 2", "N/A", 5, 5.00);

/*Users get added as they create accounts*/
INSERT INTO users (username, pass)
VALUES ("user1234", "supersecretpass123");

/*Products + QTY get added to users cart as they shop*/
REPLACE INTO shoppingcart 
SET userID = 1, prodID = 1, qty = 2;
REPLACE INTO shoppingcart 
SET userID = 1, prodID = 2, qty = 1;

/*And removed from the inventory at the same time*/
UPDATE products
SET qtyAvailable = qtyAvailable - 2
WHERE prodID = 1;
UPDATE products
SET qtyAvailable = qtyAvailable - 1
WHERE prodID = 2;

/*When user clicks checkout, first an order is created with only the reference to userID*/
INSERT INTO orders (userID)
VALUES (1);

/*Immediately after, the shopping cart is placed into orderproducts*/
INSERT INTO orderproducts (prodID, qty, orderID) 
SELECT prodID, qty, 1 
FROM shoppingcart 
WHERE userID = 1 AND qty > 0;

/*orderproducts would get totaled up, total added to order*/
UPDATE orders 
SET total = 15.00
WHERE orderID = 1;

/*billing and shipping info would be acquired and stored after displaying total -- this example shows where billing info is also used for shipping*/
INSERT INTO orderinfo (recipientName, street, city, stateAbbr, zip, isBilling, cardNumber, cvc, expMon, expYear)
VALUES ("Ryan", "123 Elmo Street", "Dekalb", "IL", "60112", 1, "123456789123456789", "123", "04", "22");

/*billing and shipping info attached to order, status changed to order success*/
UPDATE orders
SET billingID = 1, shippingID = 1, status = 1
WHERE orderID = 1;

/*After order success, clear shopping cart*/
UPDATE shoppingcart
SET qty = 0
WHERE userID = 1;

/*later on, when an employee begins processing the package it can be changed to processing*/
UPDATE orders
SET status = 2
WHERE orderID = 1;

/*when shipped, can then have shipping num added and changed to shipped*/
UPDATE orders
SET shippingNumber = 123456, status = 3
WHERE orderID = 1;