-- 1 create employee 
delimiter $$

drop procedure if exists create_employee $$

create procedure create_employee(
    username varchar(30),
    email varchar (30)  
)
begin
	insert into Employee (username, email, passwrd, passwrdUpdated) 
    values (username, email, SHA2('TEMPPASSWORD', 256), false);
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
create procedure insert_product(name varchar(30),
descript varchar(250), price numeric(5,2), adv_stock int, act_stock int,
discont bool, category varchar(30), image varchar(25))
begin
insert into Products(product_name, product_desc, price, adv_stock, act_stock, discont, category, image)
values (name, descript, price, adv_stock, act_stock, discont, category, image);
end $$
delimiter ;


-- 4 
delimiter $$
drop procedure if exists insert_customer $$
create procedure insert_customer(user varchar(30), passwrd varchar(250), f_name varchar(30), l_name varchar(30), email varchar(100), address varchar(250))
begin
insert into Customer(user, passwrd, f_name, l_name, email, address)
values (user, SHA2(passwrd, 256), f_name, l_name, email, address);
end $$
delimiter ;


-- 4 update product price
delimiter $$
drop procedure if exists update_product_price $$
create procedure update_product_price(p_id int, newPrice numeric(5,2))
begin
update product set price = newPrice where product_id = p_id;
end $$
delimiter ;

-- 5 restock product
delimiter $$

drop procedure if exists restock_product $$

create procedure restock_product(
	prodct_id int,
    quantity int
)
begin
	insert into Products values (product_id, quantity);
end $$

delimiter ;


-- FUNCTIONS

-- 1 insert order

delimiter $$ 

drop function if exists insert_order$$
create function insert_order(
	c_id int, 
	order_Date date, 
    order_status varchar(250), 
    total numeric(10, 2)
)
returns int
begin
	declare new_order_id int;
    
	insert into Orders(c_id, order_Date, order_status, total)
	values (c_id, order_Date, order_status, total);
        
	set new_order_id = LAST_INSERT_ID();
        
    return new_order_id;
end $$

delimiter ; 

-- 2 insert_order_item
delimiter $$

drop function if exists insert_order_item $$

create function insert_order_item(
    p_order_id int,
    p_product_id char(4),
    p_quantity int,
    p_price numeric(5,2)
    )
returns varchar(255)
begin
    -- Insert the order item into the Order_Items table
    insert into Order_Items (order_id, product_id, quantity)
    values (p_order_id, p_product_id, p_quantity);

    -- Update the actual stock in the Products table
    update Products
    set act_stock = act_stock - p_quantity
    where Products.product_id = p_product_id;

    -- Return a success message
    return 'Added to order sucessfully!';
end $$

delimiter ;

-- TRIGGERS

-- 1 after insert, insert in product history
delimiter $$

drop trigger if exists product_insert$$

create
	trigger product_insert
    after insert on Products
    for each row begin
		insert into product_history_stock (product_id, update_date, old_stock, new_stock, changes)
        values (NEW.product_id, current_timestamp(), null, new.act_stock, new.act_stock);
        insert into product_history_price (product_id, update_date, old_price, new_price, percentage)
        values (NEW.product_id, current_timestamp(), null, new.price, null);
	end $$
    
delimiter ;

-- after update, insert in product history
delimiter $$

drop trigger if exists product_update$$

create
	trigger product_update
    after update on Products
    for each row begin
         if old.price <> new.price then
			insert into product_history_price (product_id, update_date, old_price, new_price, percentage)
            values (new.product_id, current_timestamp(), old.price, new.price,
                (case when old.price = 0 then null else (new.price - old.price) / old.price * 100 end));
		end if;
        
        if old.act_stock <> new.act_stock then
        insert into product_history_stock(product_id, update_date, old_stock, new_stock, changes)
            values (new.product_id, current_timestamp(), old.act_stock, new.act_stock, new.act_stock - old.act_stock);
        end if;
        
	end $$

delimiter ;

-- before update, raise error to reject update if product_id is changed
delimiter $$

drop trigger if exists edit_error$$

create 
	trigger edit_error
    before update on Products
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
	before delete on Products
    for each row
	begin
		signal sqlstate '45000'
		set message_text = 'cannot delete product';
end $$

delimiter ;





		
			
