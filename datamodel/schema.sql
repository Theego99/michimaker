create table users (
  id int(11) not null auto_increment primary key,
  name varchar(128) not null,
  email varchar(255) not null,
  password_hash varchar(255) default null,
  created_at timestamp not null default current_timestamp,
  unique key email (email)
);

create table shortcuts (
  id int(11) not null auto_increment primary key,
  point_a varchar(17) not null,
  point_b varchar(17) not null,
  created_at timestamp not null default current_timestamp,
  name varchar(128) default null,
  comments varchar(248) default null
);