#drop previously exisiting tables
drop table if exists Employee;
drop table if exists Product;
drop table if exists Category;
drop table if exists Customer;
drop table if exists Orders;
drop table if exists Order_Item;
drop table if exists Epdates;
drop table if exists Makes;
drop table if exists In_Cart;
drop table if exists Belongs_To;

#emplyoee table
create table Employee(
	employee_ID char(4) primary key,
    username varchar(30),
    email varchar(30),
    passwrd varchar(30) not null
);

#customer table
create table Customer(
	c_ID char(4) primary key,
    user varchar(30),
    passwrd varchar(250),
    f_name varchar(30),
    l_name varchar(30),
    email varchar(100),
    address varchar(250)
);

#catergory table
create table Catergory(
	cat_Name varchar(30) primary key,
    cat_Desc varchar(200)
);

#product table
create table Product(
	product_ID char(4) primary key,
    product_name varchar(30),
    product_desc varchar(250),
    price numeric(5,2),
	adv_stock int,
    act_stock int,
    discont bool,
    category varchar(30),
    image varchar(250),
    foreign key (category) references Category(cat_Name)
);

create table Orders(
	order_ID char(4) primary key,
    c_ID char(4),
	order_Date date,
    order_Status varchar(250),
    total numeric(10,2)
);


    
