select product_id, action_date, action_type, old_price, new_price
from Product_history
where product_id = 'S001'; 

select product_id, 
       MAX(price) as highest_price, 
       MIN(price) as lowest_price
from Order_items
where order_date between '2023-01-01' and '2023-12-31' 
group by product_id;

select product_id, 
       sum(quantity) as total_quantity_sold
from Order_items
join Orders on Order_items.order_id = Orders.order_id
where Orders.order_date between '2023-01-01' and '2023-12-31' 
group by product_id
having total_quantity_sold > 0;


select product_id, 
       SUM(quantity) as total_quantity_sold
from Order_items
join Orders on Order_items.order_id = Orders.order_id
where Orders.order_date between '2023-01-01' and '2023-12-31' 
group by product_id
having total_quantity_sold > 0;

select product_id, 
       name, 
       adv_stock - act_stock AS quantity_needed
from Product
where act_stock < adv_stock;

