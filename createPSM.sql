-- 1 create employee 
delimiter $$

drop procedure if exists create_employee $$

create procedure create_employee(
    emp_id char(4),
    username varchar(30),
    email varchar (30)  
)
begin
	insert into Employee values(emp_id, username, email, SHA2('TEMPPASSWORD', 256), false);
end $$

delimiter ;


-- 2 insert category
delimiter $$

drop procedure if exists insert_category $$
create procedure insert_category(
	cat_Name varchar(30),
    cat_Desc varchar(200)
)
begin
	insert into Category values(cat_Name, cat_Desc);
end $$

delimiter ;


-- 3 insert product
delimiter $$
drop procedure if exists insert_product $$
create procedure insert_product(p_ID char(4), name varchar(30),
descript varchar(250), price numeric(5,2), adv_stock int, act_stock int,
discont bool, catergory varchar(30), image varchar(25))
begin
insert into insert_products values (p_ID, name, descirpt, price, adv_stock, act_stock, category, image);
end $$
delimiter ;


-- 4 update product price
delimiter $$
drop procedure if exists update_product_price $$
create procedure update_product_price(p_id char(4), newPrice numeric(5,2))
begin
update product set price = newPrice where product_id = p_id;
end $$
delimiter ;

-- 5 restock product
delimiter $$

drop procedure if exists restock_product $$

create procedure restock_product(
	prodct_id char(4),
    quantity int
)
begin
	insert into product values (product_id, quantity);
end $$

delimiter ;


-- FUNCTIONS

-- 1 insert order

delimiter $$ 

drop function if exists insert_order$$
create function insert_order(
	c_id char(4), 
	order_Date date, 
    order_status varchar(250), 
    total numeric(10, 2)
)
returns int
begin
	declare new_order_id int;
    
	insert into orders(c_id, order_Date, order_status, total)
	values (c_id, order_Date, order_status, total);
        
	set new_order_id = LAST_INSERT_ID();
        
    return new_order_id;
end $$

delimiter ; 

-- 2 insert_order_item
delimiter $$

drop function if exists insert_order_item $$

create function insert_order_item(
    p_order_id char(4),
    p_product_id char(4),
    p_quantity int
)
returns varchar(255)
begin
    -- Insert the order item into the Order_Items table
    insert into Order_Items (order_id, product_id, quantity)
    values (p_order_id, p_product_id, p_quantity);

    -- Update the actual stock in the Products table
    update Products
    set act_stock = act_stock - p_quantity
    where product_id = p_product_id;

    -- Return a success message
    return (act_stock);
end $$

delimiter ;

-- TRIGGERS

-- 1 after insert, insert in product history
delimiter $$

drop trigger if exists product_import$$

create
	trigger product_insert
    after insert on product
    for each row begin
		insert into product_history (product_id, action_type)
        values (NEW.product_id, 'INSERT');
	end $$
    
delimiter ;

-- after update, insert in product history
delimiter $$

drop trigger if exists product_update$$

create
	trigger product_update
    after update on product
    for each row begin
		insert into product_history (product_id, action_type)
        values (NEW.product_id, 'UPDATE');
	end $$

delimiter ;

-- before update, raise error to reject update if product_id is changed
delimiter $$

drop trigger if exists edit_error$$

create 
	trigger edit_error
    before update on product
	for each row
    begin
		if OLD.product_id <> NEW.product_id then
			signal sqlstate '45000'
            set message_text = 'The product ID is not allowed to be changed';
		end if;
end $$
    
delimiter ;
    
-- before delete, raise error to reject delete
delimiter $$

drop trigger if exists delete_error$$

create 
	trigger delete_error
	before delete on product
    for each row
	begin
		signal sqlstate '45000'
		set message_text = 'cannot delete product';
end $$

delimiter ;





		
			
