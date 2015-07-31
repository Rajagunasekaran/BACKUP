/* delete all but system seeds */
DELETE FROM accountorders;
DELETE FROM accountpurchases;
DELETE FROM consignmentnotes;
DELETE FROM geolocations;
DELETE FROM idmasters;
DELETE FROM locations;
DELETE FROM logins WHERE `login` != 'admin';
DELETE FROM mailqueues;
DELETE FROM milestones;
DELETE FROM orderaddresses;
DELETE FROM orderpeople;
DELETE FROM orderproductdns;
DELETE FROM orderproducts;
DELETE FROM ordertaskpeople;
DELETE FROM ordertasks;
DELETE FROM otprgrshistories;
DELETE FROM payments;
DELETE FROM personaddresses;
DELETE FROM persontimeslots;
DELETE FROM purchasepeople;
DELETE FROM purchaseproducts;
DELETE FROM timeslotstatuses;
DELETE FROM orders WHERE `id` != 1;
DELETE FROM purchases;
DELETE FROM accounts;
/* take care */
/* DELETE FROM products; */
DELETE FROM productpeople WHERE TYPE != 'supplier';
DELETE FROM people WHERE `type` NOT IN ('admin', 'supplier', 'customer', 'contractor');
DELETE FROM tasks where id not in (1,2,3,4);
/*
*/