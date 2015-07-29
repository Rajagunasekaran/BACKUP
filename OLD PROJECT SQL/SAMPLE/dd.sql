



DROP table IF EXISTS staff; 
CREATE TABLE staff(empid INT(10) auto_increment, name varchar(20),designation varchar(20),salary int(10),primary key(empid));

insert into staff(name,designation,salary)values('kader','programmer',4000);
insert into staff(name,designation,salary)values('ravi','admin',5000);
insert into staff (name,designation,salary)values('ragul','manager',1000);
select * from staff;


delete from staff_del where empid=3;


DROP table IF EXISTS staff_del; 
CREATE TABLE staff_del(old_name varchar(20),old_designation varchar(20),old_salary int(10));



DROP trigger IF EXISTS trig_del_on_staff; 
 CREATE TRIGGER trig_del_on_staff 
  AFTER delete  ON staff
  FOR EACH ROW
  BEGIN
  DECLARE empid INTEGER DEFAULT '';DECLARE name TEXT DEFAULT ''; 
  DECLARE designation TEXT DEFAULT '';DECLARE salary INTEGER DEFAULT'';
  DECLARE g_name TEXT DEFAULT '';
  DECLARE i_designation TEXT DEFAULT '';
  DECLARE k_salary INTEGER DEFAULT '';
  set empid=old.empid;
  set name=old.name;
  set g_name=old.name;
  set designation=old.designation;
  set i_designation=old.designation;
  set salary=old.salary;
  set k_salary=old.salary;
  INSERT into staff_del(old_name,old_designation,old_salary)values(g_name,i_designation,k_salary) ;
 END;
 
  delete from staff where empid=2;
 
 select * from staff;
select * from staff_del;
 
 
 


 
 
