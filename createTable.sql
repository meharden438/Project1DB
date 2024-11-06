#drop previously exisiting tables
drop table if exists Employee;
drop table if exists Product;
drop table if exists Category;
drop table if exists Customer;
drop table if exists Orders;
drop table if exists Order_Item;
drop table if exists Updates;
drop table if exists Makes;
drop table if exists In_Cart;
drop table if exists Belongs_To;

#emplyoee table
create table Employee(
	employee_id char(4) primary key,
    username varchar(30),
    email varchar(30),
    passwrd varchar(30) not null
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
create table Catergory(
	cat_Name varchar(30) primary key,
    cat_Desc varchar(200) not null
);

#product table
create table Product(
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
create table order_Items(
	order_id char(4) primary key,
    product_id char(4),
    quanity int,
    price numeric(5,2),
    foreign key (product_id) references Product(product_id),
    foreign key (price) references Product(price)
);

#update table
create table Updates(
	employee_id char(4) primary key,
    product_id char(4),
	up_Time date not null,
    desc_of_uodate varchar(250),
    foreign key (employee_id) references Employee(employee_id),
    foreign key (product_id) references Product(product_id)
);



    
