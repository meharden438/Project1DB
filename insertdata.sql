SET SQL_SAFE_UPDATES = 0;
# insertion of the employess
delete from Employee;
call create_employee('bob123', 'bob123@store.com');
call create_employee('stanley321', 'stanley321@store.com');
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

delete from Products;
-- Insert products
call insert_product('Aloe Vera', 'An easy-to-care-for succulent with green, spiky leaves, often regarded for the gel its leaves produce', 10.00, 5, 40, false, (select cat_Name from Category where cat_Name = 'Succulents'), 'aloe_vera.jpg');
call insert_product('Old Man’s Bones', 'Tall and slender plant', 12.99, 8, 37, false, 'Succulents', 'old_mans_bones.jpg');
call insert_product('Rose', 'A flower known for its stunning blooms', 2.50, 15, 57, false, 'Flowers', 'rose.jpg');
select * from Products;

-- insert customers
delete from Customer;
call insert_customer('happyGuy92', 'password1', 'Emille', 'John', 'happyGuy92@customer.com', '123 Maple Street, Springfield, IL, 62701');
call insert_customer('artLover123', 'password2', 'Taylor', 'Jessica', 'artLover123@customer.com', '654 Cedar Lane, Central City, IL, 62704');
call insert_customer('gamerDude99', 'password3', 'Dennis', 'Brown', 'gamerDude99@customer.com', '246 Oakwood Circle, Crystal Lake, IL, 60014');
-- show all customers
select * from Customer;

select sleep(1);

-- insert orders
delete from Orders;
select insert_order(1, '2023-10-01 09:00:00', 'Completed', 20.00);
select insert_order(2, '2023-10-01 09:15:00', 'Completed', 12.99);
select insert_order(3, '2023-10-01 09:17:00', 'Completed', 24.00);
-- show all orders
select * from Orders;


select * from Products;

-- insert order items
delete from Order_Items;
select insert_order_item(1, 1, 2, 10.00);
select insert_order_item(2, 2, 1, 12.99);
select insert_order_item(3, 3, 3, 8.00);
select * from Order_Items;
select * from Products;

select * from product_history_price order by update_date desc;
select * from product_history_stock order by update_date desc;

