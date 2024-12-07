#drop tables in certain order to avoid dropping foreign keys
drop table if exists In_Cart;
drop table if exists Makes;
drop table if exists Updates;
drop table if exists Order_Items;
drop table if exists Orders;
drop table if exists product_history_price;
drop table if exists product_history_stock;
drop table if exists Products;
drop tables if exists Employee, Category;
drop table if exists Customer;

#emplyoee table
create table Employee(
	employee_id int auto_increment primary key,
    username varchar(30),
    email varchar(30),
    passwrd varchar(250) not null,
    passwrdUpdated bool
);

#customer table
create table Customer(
	c_id int auto_increment primary key,
    user varchar(30) unique,
    passwrd varchar(250) not null,
    f_name varchar(30) not null,
    l_name varchar(30) not null,
    email varchar(100) not null,
    address varchar(250) not null
);

#catergory table
create table Category(
	cat_Name varchar(30) primary key,
    cat_Desc varchar(200) not null
);

#product table
create table Products(
	product_id int auto_increment primary key,
    product_name varchar(30) not null,
    product_desc varchar(250) not null,
    price numeric(5,2) not null,
	adv_stock int not null,
    act_stock int not null,
    discont bool,
    category varchar(30),
    image varchar(250),
    foreign key (category) references Catergory(cat_Name) on delete cascade
);

#order table
create table Orders(
	order_id int auto_increment primary key,
    c_id int,
	order_Date date not null,
    order_Status varchar(250) not null,
    total numeric(10,2) not null,
    foreign key (c_id) references Customer(c_id)
);

#order_items table
create table Order_Items(
	order_id int,
    product_id int,
    quantity int,
    foreign key (order_id) references Orders(order_id),
    foreign key (product_id) references Products(product_id),
	primary key (order_id, product_id)
    );

#update table
create table Updates(
	employee_id int primary key,
    product_id int,
	up_Time date not null,
    desc_of_uodate varchar(250),
    foreign key (employee_id) references Employee(employee_id),
    foreign key (product_id) references Products(product_id)
);

#makes table
create table Makes(
	order_id int primary key,
    c_id int,
    foreign key (order_id) references Orders(order_id),
    foreign key (c_id) references Customer(c_id)
);

#in_cart table
create table In_Cart(
	c_id int primary key,
    product_id int,
    foreign key (c_id) references Customer(c_id),
    foreign key (product_id) references Products(product_id)
);    

#product_history_price table
create table product_history_price(
	product_id int,
    update_date timestamp,
    old_price numeric(5,2),
    new_price numeric(5,2),
	percentage numeric(5,2),
    foreign key (product_id) references Products(product_id),
    primary key(product_id, update_date)
);

#product_history_stock table
create table product_history_stock(
	product_id int,
    update_date timestamp,
    old_stock int,
    new_stock int,
    changes int,
    foreign key (product_id) references Products(product_id),
    primary key(product_id, update_date)
);
    