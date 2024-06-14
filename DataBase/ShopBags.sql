CREATE DATABASE ShopBags;

use ShopBags;

CREATE TABLE categories (
  category_id int(5) unsigned NOT NULL auto_increment,
  category_name varchar(50) NOT NULL default '',
  description varchar(100),
  PRIMARY KEY  (category_id)
);

INSERT INTO categories (category_name, description) VALUES ('Рюкзаки', 'Для подорожі');
INSERT INTO categories (category_name, description) VALUES ('Чоловіче', 'Сумки для чоловіків');
INSERT INTO categories (category_name, description) VALUES ('Жіноче', 'Сумки для жінок');
INSERT INTO categories (category_name, description) VALUES ('Дитячі', 'Для школи');

CREATE TABLE suppliers (
  supplier_id int(5) unsigned NOT NULL auto_increment,
  supplier_name varchar(50) NOT NULL default '',
  supplier_email varchar(50) NOT NULL default '',
  supplier_address varchar(50) NOT NULL default '',
  supplier_phone_mobile int(12) ,
  supplier_phone_work int(12) ,
  PRIMARY KEY  (supplier_id)
);

INSERT INTO suppliers (supplier_name, supplier_email, supplier_address, supplier_phone_mobile, supplier_phone_work) VALUES ('Demix', 'Demix@gmail.com', 'вул. Чуднівського 10', 0505670208, 066525029);
INSERT INTO suppliers (supplier_name, supplier_email, supplier_address, supplier_phone_mobile, supplier_phone_work) VALUES ('Bagland', 'BagLand@gmail.com', 'вул. Небесної сотні 4', 0506672008, 0725670208);
INSERT INTO suppliers (supplier_name, supplier_email, supplier_address, supplier_phone_mobile, supplier_phone_work) VALUES ('Wittchen', 'SupportWittchen@ukr.com', 'вул. Проспект Миру 34', 0507670288, 0725672008);

CREATE TABLE bags (
  bag_id int(6) unsigned NOT NULL auto_increment,
  bag_name varchar(50) NOT NULL default '',
  bag_description varchar(100) NOT NULL default '',
  bag_price decimal(5,2) NOT NULL default 000.00,
  bag_image_link varchar(200) NOT NULL default '',
  category_id int(5) unsigned NOT NULL ,
  supplier_id int(5) unsigned NOT NULL ,
  PRIMARY KEY  (bag_id) ,
  INDEX `category_key_idx` (`category_id` ASC),
  INDEX `supplier_key_idx` (`supplier_id` ASC),
  CONSTRAINT `category_key`
    FOREIGN KEY (`category_id`)
    REFERENCES `ShopBags`.`categories` (`category_id`) ,
  CONSTRAINT `supplier_key`
    FOREIGN KEY (`supplier_id`)
    REFERENCES `ShopBags`.`suppliers` (`supplier_id`)
);

INSERT INTO bags (bag_name, bag_description, bag_price, bag_image_link, category_id, supplier_id) VALUES ('Carrymate', 'неймовірна дорожня сумка', 2000, 'images/products/bag1.jpg', 1, 1);
INSERT INTO bags (bag_name, bag_description, bag_price, bag_image_link, category_id, supplier_id) VALUES ('Ladyies', 'жіноча сумка через плече', 2500, 'images/products/bag2.jpg', 3, 2);
INSERT INTO bags (bag_name, bag_description, bag_price, bag_image_link, category_id, supplier_id) VALUES ('Travelbud', 'дорожня сумка', 1500, 'images/products/bag3.jpg', 1, 3);
INSERT INTO bags (bag_name, bag_description, bag_price, bag_image_link, category_id, supplier_id) VALUES ('Profit', 'неймовірна для подорожі сумка', 3000, 'images/products/bag4.jpg', 2, 2);
INSERT INTO bags (bag_name, bag_description, bag_price, bag_image_link, category_id, supplier_id) VALUES ('Travelled', 'Подорож для Екстриму', 1700, 'images/products/bag5.jpg', 1, 1);
INSERT INTO bags (bag_name, bag_description, bag_price, bag_image_link, category_id, supplier_id) VALUES ('ChildBag', 'чудові шкільні дні', 3500, 'images/products/bag6.jpg', 4, 3);

CREATE TABLE users (
  user_id int(6) unsigned NOT NULL auto_increment ,
  last_name varchar(100) NOT NULL default '' ,
  first_name varchar(100) NOT NULL default '' ,
  email varchar(100) NOT NULL UNIQUE default '' ,
  address varchar(100) NOT NULL default '' ,
  mobile_phone int(12) NOT NULL ,
  username varchar(100) UNIQUE NOT NULL ,
  password varchar(100) NOT NULL ,
  status enum ('1', '2', '3', '4') NOT NULL default '1' ,
  PRIMARY KEY  (user_id)
);

INSERT INTO users (last_name,first_name, email, address, mobile_phone, username, password, status) VALUES ('Admin', 'Admin', 'adminShop@gmail.com', 'Проспект миру 12', 0665350208, 'Admin', 'admin4439', '4');

CREATE TABLE orders (
  order_id int(6) unsigned NOT NULL auto_increment,
  order_last_name varchar(100) NOT NULL default '' ,
  order_first_name varchar(100) NOT NULL default '' ,
  order_address varchar(100) NOT NULL default '' ,
  order_mobile_phone int(12) NOT NULL ,
  order_status enum ('В очікуванні', 'Відправлено') NOT NULL default 'В очікуванні',
  order_date date NOT NULL ,
  total decimal(6,2) NOT NULL default 0000.00 ,
  user_id int(6) unsigned NOT NULL ,
  PRIMARY KEY  (order_id) ,
  INDEX `user_key_idx` (`user_id` ASC),
  CONSTRAINT `user_key`
    FOREIGN KEY (`user_id`)
    REFERENCES `ShopBags`.`users` (`user_id`)
);

CREATE TABLE order_items (
  order_item_id int(7) unsigned NOT NULL auto_increment,
  bag_id int(6) unsigned NOT NULL ,
  quantity int(5) unsigned NOT NULL ,
  subtotal decimal(6,2) NOT NULL default 0000.00 ,
  order_id int(6) unsigned NOT NULL ,
  PRIMARY KEY  (order_item_id) ,
  INDEX `bag_key_idx` (`bag_id` ASC),
  INDEX `order_key_idx` (`order_id` ASC),
  CONSTRAINT `bag_key`
    FOREIGN KEY (`bag_id`)
    REFERENCES `ShopBags`.`bags` (`bag_id`) ,
  CONSTRAINT `order_key`
    FOREIGN KEY (`order_id`)
    REFERENCES `ShopBags`.`orders` (`order_id`)
);
