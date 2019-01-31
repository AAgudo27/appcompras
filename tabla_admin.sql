create table admin
(id integer(11),
 username char(50),
 passcode char(50));

alter table admin add constraint  pk_admin primary key (id);

insert into admin (id,username,passcode)
	select customernumber,customername,contactlastname from customers;

update admin set username=trim(substr(username,1,8));