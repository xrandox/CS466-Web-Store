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





