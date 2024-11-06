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
call insert_product('S001', 'Aloe Vera', 'A easy-to-care for succulent with green, spiky leaves, often regarded for the gel its leaves produce', 10.00, 5, 40, false, 'Succulents', NULL );