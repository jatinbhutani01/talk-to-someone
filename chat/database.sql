create table available(
chatid int primary key auto_increment,
fpn varchar(100) not null,
fsid varchar(30),
spn varchar(100),
ssid varchar(30),
tablename varchar(10),
statustable varchar(10),
ended int
);
create table availabletable(
tablename varchar(10),
tableid int,
id int(20) primary key auto_increment
);
