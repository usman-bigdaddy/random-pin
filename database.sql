create schema pin_auth;

use pin_auth;

create table tb_user(
  user_email varchar(50) primary key,
  user_pin varchar(3) not null,
  user_incremental_factor varchar(5),
  login_attempts varchar(5)
);