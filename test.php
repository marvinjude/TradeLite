//sql query for the sale part of the table

SELECT sales.sale_date,customers.customer_name,sales.invoice_number,stocks.description,stocks.cost_per_ton,subsales.quantity,subsales.subtotal FROM sales INNER JOIN customers ON customers.id = sales.customer_id INNER JOIN subsales on sales.id = subsales.sale_id INNER JOIN stocks ON stocks.id = subsales.stock_id WHERE sales.sale_date BETWEEN 
'2017-09-12' AND '2017-09-12' ORDER BY sales.invoice_number DESC

//sales total for those days 
SELECT SUM(sales.total) FROM sales WHERE sales.sale_date BETWEEN '2017-09-12' AND '2017-09-12'


//total of balance brought foward

SELECT SUM(balance_brought_foward.amount) from balance_brought_foward where balance_brought_foward.date BETWEEN '2017-09-12' AND '2017-09-12'


//total bank deposits
SELECT SUM(bank_deposits.amount) from bank_deposits where bank_deposits.date BETWEEN '2017-09-12' AND '2017-09-12'


//total customer deposits
SELECT SUM(customer_deposits.amount) from customer_deposit where customer_deposit.date BETWEEN '2017-09-12' AND '2017-09-12'

//sum of expenses
SELECT SUM(expenses.amount) from expenses where expenses.date BETWEEN '2017-09-12' AND '2017-09-12'

//get total qty sold for each stocks 

SELECT stocks.description, SUM(subsales.quantity) FROM subsales INNER JOIN stocks ON stocks.id = subsales.stock_id GROUP BY subsales.stock_id

