SET SQL_SAFE_UPDATES = 0;
# insertion of the employess
delete from Employee;
call create_employee('E001', 'bob123', 'bob123@store.com');
call create_employee('E002', 'stanley321', 'stanley321@store.com');
#display of the employess
select * from Employee;

#insertion of all the categories
delete from Category;
call insert_category('Succulents', 'A plant with thick fleshy leaves or stems adapted to storing water.');
call insert_category('Flowers', 'The flower part of a plant');
call insert_category('Tropical Plants', 'Plants from a tropical area.');
call insert_category('Aquatic Plants', 'Plants that grow in water.');
#show all the categories
select * from Category;

#insert all the products
delete from Products;
call insert_product('S001', 'Aloe Vera', 'A easy-to-care for succulent with green, spiky leaves, often regarded for the gel its leaves produce', 10.00, 5, 40, false, 'Succulents', NULL );
call insert_product('S002', 'Old Man’s Bones', 'Tall and slender plant', 12.99, 8, 37, false, 'Succulents', 'old_mans_bones.jpg');
call insert_prodcut('F001', 'Rose', 'A flower known for its stunning blooms', 2.50, 15, 57, false, 'Flowers', 'rose.jpg');
select * from Product;

-- insert customers
delete from Customers;
call insert_customer('C001', 'happyGuy92', 'password1', 'Emille', 'John', 'happyGuy92@customer.com', '123 Maple Street, Springfield, IL, 62701');
call insert_customer('C002', 'artLover123', 'password2', 'Taylor', 'Jessica', 'artLover123@customer.com', '654 Cedar Lane, Central City, IL, 62704');
call insert_customer('C003', 'gamerDude99', 'password3', 'Dennis', 'Brown', 'gamerDude99@customer.com', '246 Oakwood Circle, Crystal Lake, IL, 60014');
-- show all customers
select * from Customer;

-- insert orders
delete from Orders;
call insert_order('O001', 'C001', '2023-10-01 09:00:00', 'Completed', 20.00);
call insert_order('O002', 'C002', '2023-10-01 09:15:00', 'Completed', 12.99);
call insert_order('O003', 'C003', '2023-10-01 09:17:00', 'Completed', 24.00);
-- show all orders
select * from Orders;

-- insert order items
delete from Order_items;
call insert_order_item('O001', 'S001', 2, 10.00);
call insert_order_item('O002', 'S002', 1, 12.99);
call insert_order_item('O003', 'T001', 3, 8.00);

update Product set act_stock = act_stock - 2 WHERE product_id = 'S001';
update Product set act_stock = act_stock - 1 WHERE product_id = 'S002';
update Product set act_stock = act_stock - 3 WHERE product_id = 'T001';
-- show all order items
select * from Order_Items;


select * from Product_history;




