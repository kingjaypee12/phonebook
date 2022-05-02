## PART II: MYSQL 

1. SELECT ProductName AS NAME, QuantityPerUnit AS QuantityUnit  FROM products

2. SELECT CONCAT(ProductId,ProductName) AS 'Product List' FROM products

3. SELECT CONCAT(MAX(unitprice), productname) AS 'Product List' ,CONCAT(MIN(unitprice), productname) AS 'Product List' FROM products

4. SELECT ProductName AS 'Name', UnitPrice AS 'Unit Price' FROM products WHERE UnitPrice > (SELECT AVG(unitprice) FROM products)

5. SELECT productid AS id, productname AS 'name', unitprice AS 'unit price' FROM products WHERE UnitPrice < 20

6. SELECT productname AS 'name', unitsonorder AS 'units on order', unitsinstock AS 'units in stock' FROM products WHERE unitsinstock < unitsonorder