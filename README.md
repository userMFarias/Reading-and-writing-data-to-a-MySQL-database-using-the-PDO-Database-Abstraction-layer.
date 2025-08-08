Task 2 – Reading and writing data to a MySQL database, using the PDO Database Abstraction layer.
You are required to create a PHP application which reads juice data from a text file into a MySQL database
table. The application should then read the juice data from the database table, run MySQL queries to
generate two datasets for each juice type and then display the required data in two HTML tables a browser.
The desired output can be seen by clicking on the following link; click here to see a working example.
You are provided with an index.php file, which will contain your PHP solution code, a data file
‘juiceData.csv’ containg the data and a CSS file ‘styles.css’ which contains some basic styles for formatting
a HTML table. You can refactor index.php to achieve better separation of concerns.
Your php application should conform to the following requirements:
1. You are to use the PHP Data Objects (PDO) database abstraction layer/class to implement your
PHP database access code.
2. The data file contains 19 lines of data, and each line has 4 items of data, separated by a comma:
juice_name, juice_type, juice_price, juice_description
3. Using PHP code, you should create a suitable MySQL table in your titan MySQL Database called
‘Juices’ to store the data read from the ‘juiceData.csv’ file. The database fields should be as
follows:
Field Name
Type
Settings
juice_id
INT
Primary Key, NOT NULL
juice_name
VARCHAR(30)
NOT NULL, Unique
juice_type
ENUM('Fruit', 'Veg')
juice_price
DECIMAL(4,2)
juice_description
TEXT
4. The data file should be read using PHP code and then stored in the created MySQL table ‘Juices’.
N.B. your PHP code will need to detect if the table already exists and should not duplicate any data
when your application is run after its initial execution.
5. Once the data is stored in the database table you should query it to create a dataset for each type
of juice and then for each type of juice you need to satisfy the following requirements to be
displayed as a separate HTML table:
a. Display the juice table heading; either “Fruit Juices” or “Vegetable Juices”, as part of the
table row 1.
b. Display the data table headings “Name”, “Price” and “Description”.
c. Display the juice data relating to the table headings; sorted initially by juice_price in
DESCending order and then by juice_name in ASCending order.
d. Display “TOTAL juices” sum of the price of all the juices.
e. Display “AVERAGE juice cost” the average price of all the juices.
f. All prices should be shown with a preceding “£” sign and formatted to 2 decimal places.
6. The data file and CSS file should not be modified in any way, as this will be used to test you
have compiled the required data and displayed the HTML tables correctly.
7. Your php code should go between the <?php ?> tags in index.php, however, your final solution
should be well structured, with good separation of concerns, using user defined functions.


(There is no seperation of concerns in this example, eveirthing is in the index file).
