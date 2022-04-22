/*File for database INSERT scripts*/
------------------------------------
/*
 *
 * Insert 20 products into the database
 *
 */ 
INSERT INTO products (prodName, descr, qtyAvailable, price)
	values('Batman Headphones',
           'Echo location headphones, allows for up to 24 hours of stream time',
           25,
           125
           );

INSERT INTO products (prodName, descr, qtyAvailable, price)
	values('Fuzzy dice',
           'Black dice with white dots, wrap them around your rear view mirror!',
           100,
           8
           ); 
INSERT INTO products (prodName, descr, qtyAvailable, price)
	values('Wireless mouse',
           'Uses 2 AA batteries, comes with a FREE mouse pad.',
           30,
           18.50
           );
INSERT INTO products (prodName, descr, qtyAvailable, price)
	values('Lockpicking set',
           'Pack contains 8 different tools and a get started guide!',
           75,
           8
           );
INSERT INTO products (prodName, descr, qtyAvailable, price)
	values('OBD2 Scanner',
           'Reads engine codes, and diagnoses problems.',
           5,
           125.25
           );
INSERT INTO products (prodName, descr, qtyAvailable, price)
	values('Camping tent',
           'This tent can fit 4 people comfortably!, made with only the best material!',
           15,
           99.99
           );
INSERT INTO products (prodName, descr, qtyAvailable, price)
	values('American flag',
           'Show your colors with this 3ft x 5ft incredibly durable flag!',
           35,
           14.99
           ); 
INSERT INTO products (prodName, descr, qtyAvailable, price)
	values('Neck pillow',
           'Peak sleeping performance on the go, made out of 100% cotton.',
           55,
           8
           );
INSERT INTO products (prodName, descr, qtyAvailable, price)
	values('Baby stroller',
           'Seats one child in luxury with two cupholders and tons of storage space.',
           10,
           49.99
           );
INSERT INTO products (prodName, descr, qtyAvailable, price)
	values('800cc Lawn Mower',
           'Tired of wasting your time cutting grass? This high performance lawn mower garuntees a better cut in 50% less time then a normal mower.',
           10,
           249.99
           );
--------------ten-----------------
INSERT INTO products (prodName, descr, qtyAvailable, price)
	values('Handhel vaccum',
           'Small vaccum for hard to reach areas, lithium ion battery.',
           10,
           24.99
           );

INSERT INTO products (prodName, descr, qtyAvailable, price)
	values('Portable charger',
           'Small and durable 2500mah portable charger with two USB ports.',
           55,
           15.79
           ); 
INSERT INTO products (prodName, descr, qtyAvailable, price)
	values('Zero gravity Chair',
           'Folds up for easy transportation.',
           20,
           128.50
           );
INSERT INTO products (prodName, descr, qtyAvailable, price)
	values('Basketball',
           'Full size NBA spec basketball.',
           75,
           5.52
           );
INSERT INTO products (prodName, descr, qtyAvailable, price)
	values('20 Pack of ankle socks',
           '100% cotton, good for breathability and warmth.',
           65,
           15.99
           );
INSERT INTO products (prodName, descr, qtyAvailable, price)
	values('Full knife set/block',
           'Contains every knife required for a professional chef, includes a built in knife sharpener!',
           10,
           249.99
           );
INSERT INTO products (prodName, descr, qtyAvailable, price)
	values('Dashboard camera',
           'Records up to 12 hours of 720p footage + audio upon incident!',
           30,
           36.99
           ); 
INSERT INTO products (prodName, descr, qtyAvailable, price)
	values('Tape measure',
           'Small portable device that is durable and can be extended up to six feet.',
           75,
           9.99
           );
INSERT INTO products (prodName, descr, qtyAvailable, price)
	values('Magnetic flashlight',
           'Contains two super bright white bulbs, able to stick on or hang from multiple surfaces.',
           250,
           12.99
           );
INSERT INTO products (prodName, descr, qtyAvailable, price)
	values('Coffee Maker',
           'Programmable coffeemaker, wake up to a fresh cup whenever you please!',
           75,
           34.99
           );
-----------------twenty------------------
/*
 *
 * Insert 5 customers
 *
 */ 
 INSERT INTO users (username, pass, email)
    values('jdoe44','johniscool@', 'johnboy@gmail.com');

 INSERT INTO users (username, pass, email)
    values('kingdave','appleTree1', 'kingdavi2000@gmail.com');

 INSERT INTO users (username, pass, email)
    values('saladlover','Savetheplanet00', 'fruitflies@gmail.com');

 INSERT INTO users (username, pass, email)
    values('Warmwinter','strongPassword', 'warmW@gmail.com');

 INSERT INTO users (username, pass, email)
    values('test','1234', 'test@yahoo.com');

--Insert Extra 2 for employee/owner testing---
 INSERT INTO users (username, pass, email, isEmployee)
    values('employee','1234', 'employee@hotmail.com', 1);

 INSERT INTO users (username, pass, email, isOwner)
    values('owner','1234', 'owner@hotmail.com', 1);
/*
 *
 * Insert orders for 5 customers
 *
 */ 
----------------------------------------------
 /* Insert order for jdoe44
 ----------------------------------------------

/*Order 1, the order ID will change for future orders*/
INSERT INTO orderproducts (orderID, prodID, qty)
VALUES 
   (1, 1, 2),
   (1, 2, 1);

/*This example, the address is the same for billing and shipping. If different, you need to insert another row of orderinfo*/
INSERT INTO orderinfo (recipientName, street, city, stateAbbr, zip, isBilling, cardNumber, cvc, expMon, expYear)
VALUES
   ('John Doe', '123 Pickle lane', 'DeKalb', 'IL', '60112', 1, '12345678912345678', '123', '04', '2050');

/*Now link all the info together, billing and shipping ID are the same here*/
INSERT INTO orders (userID, billingID, shippingID, total)
VALUES
   (1, 1, 1, 258.00);

/*If you want to change the status, that must be done after adding the info, or the constraint will prevent it*/
UPDATE orders 
SET orderStatus=1
WHERE orderID=1;

----------------------------------------------
/* Insert order for kingdave */
----------------------------------------------
INSERT INTO orderproducts (orderID, prodID, qty)
VALUES 
   (2, 18, 2),
   (2, 10, 1);

INSERT INTO orderinfo (recipientName, street, city, stateAbbr, zip, isBilling, cardNumber, cvc, expMon, expYear)
VALUES
   ('Dave Wright', '404 Error Ct.', 'Elgin', 'IL', '60123', 1, '12345678912345678', '123', '04', '2050');

INSERT INTO orders (userID, billingID, shippingID, total)
VALUES
   (2, 2, 2, 269.97);

UPDATE orders 
SET orderStatus=1
WHERE orderID=2;


----------------------------------------------
/* Insert order for saladlover */
----------------------------------------------
INSERT INTO orderproducts (orderID, prodID, qty)
VALUES 
   (3, 20, 1),
   (3, 14, 1);

INSERT INTO orderinfo (recipientName, street, city, stateAbbr, zip, isBilling, cardNumber, cvc, expMon, expYear)
VALUES
   ('Riley Williams', '555 Five Dr.', 'Crystal Lake', 'IL', '60014', 1, '12345678912345678', '123', '04', '2050');

INSERT INTO orders (userID, billingID, shippingID, total)
VALUES
   (3, 3, 3, 40.51);

UPDATE orders 
SET orderStatus=1
WHERE orderID=3;

----------------------------------------------
/* Insert order for warmwinter */
----------------------------------------------
INSERT INTO orderproducts (orderID, prodID, qty)
VALUES 
   (4, 13, 4);

INSERT INTO orderinfo (recipientName, street, city, stateAbbr, zip, isBilling, cardNumber, cvc, expMon, expYear)
VALUES
   ('Cozy Holmes', '202 West street', 'DeKalb', 'IL', '60112', 1, '12345678912345678', '123', '04', '2050');

INSERT INTO orders (userID, billingID, shippingID, total)
VALUES
   (4, 4, 4, 514);

UPDATE orders 
SET orderStatus=1
WHERE orderID=4;

----------------------------------------------
/* Insert order for test */
----------------------------------------------
INSERT INTO orderproducts (orderID, prodID, qty)
VALUES 
   (5, 17, 1),
   (5, 15, 1),
   (5, 12, 1),
   (5, 11, 1),

INSERT INTO orderinfo (recipientName, street, city, stateAbbr, zip, isBilling, cardNumber, cvc, expMon, expYear)
VALUES
   ('Dr. Test', '111 Test ave.', 'DeKalb', 'IL', '60112', 1, '12345678912345678', '123', '04', '2050');

INSERT INTO orders (userID, billingID, shippingID, total)
VALUES
   (5, 5, 5, 93.76);

UPDATE orders 
SET orderStatus=1
WHERE orderID=5;

----------------------------------------------
/* Five orders inserted */
----------------------------------------------







