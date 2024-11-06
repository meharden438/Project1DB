#drop tables in certain order to avoid dropping foreign keys
drop table if exists In_Cart;
drop table if exists Makes;
drop table if exists Updates;
drop table if exists Order_Items;
drop table if exists Orders;
drop table if exists Products;
drop tables if exists Employee, Category;
drop table if exists Customer;

#emplyoee table
create table Employee(
	employee_id char(4) primary key,
    username varchar(30),
    email varchar(30),
    passwrd varchar(30) not null,
    passwrdUpdated bool
);

#customer table
create table Customer(
	c_id char(4) primary key,
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
	product_id char(4) primary key,
    product_name varchar(30) not null,
    product_desc varchar(250) not null,
    price numeric(5,2) not null,
	adv_stock int not null,
    act_stock int not null,
    discont bool,
    category varchar(30) not null,
    image varchar(250),
    foreign key (category) references Category(cat_Name)
);

#order table
create table Orders(
	order_id char(4) primary key,
    c_id char(4) not null,
	order_Date date not null,
    order_Status varchar(250) not null,
    total numeric(10,2) not null
);

#order_items table
create table Order_Items(
	order_id char(4) primary key,
    product_id char(4),
    quanity int,
    foreign key (product_id) references Products(product_id)
);

#update table
create table Updates(
	employee_id char(4) primary key,
    product_id char(4),
	up_Time date not null,
    desc_of_uodate varchar(250),
    foreign key (employee_id) references Employee(employee_id),
    foreign key (product_id) references Products(product_id)
);

#makes table
create table Makes(
	order_id char(4) primary key,
    c_id char(4),
    foreign key (order_id) references Orders(order_id),
    foreign key (c_id) references Customer(c_id)
);

#in_cart table
create table In_Cart(
	c_id char(4) primary key,
    product_id char(4),
    foreign key (c_id) references Customer(c_id),
    foreign key (product_id) references Products(product_id)
);    

describe Employee;
describe Customer;
describe Category;
describe Products;
describe Orders;
describe Order_Items;
describe Updates;
describe Makes;
describe In_Cart;