:: Setup script to run mysql and create the neccessary databases and tables.
:: Note this expects 'mysql' to be avaliable on path as a command.
:: This does assume a need in varchar length for sertain columns.
:: It creates a table called tb_orders with the following config:
::     TableNr/TableName is assumed at max 45 in the format of window-1 or mid-1 or whatever.
::     Asswell as fullname att 255 just to be safe.
::     Telephone numbers are generally max 15 digits so 30 to be safe.
::     Email is given the full 255 aswell, once again to be safe.
::     Time is the time the quests want the table in format of 2023-11-28_21:57 as an example thus 20 len.
::     Details contains any extra info and is 255 long.
::     
:: It also creates a table called admin_pg standing for admin-page, where the admin/owner-of-site/employees can login.
::     Username at 45 char long.
::     Password at 80 char long.
mysql -u root < dbsetup.sql