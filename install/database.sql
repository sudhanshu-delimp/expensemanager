

CREATE TABLE `cf_values` (
  `cf_values_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `rel_crud_id` int(11) DEFAULT NULL,
  `cf_id` int(11) DEFAULT NULL,
  `curd` varchar(250) DEFAULT NULL,
  `value` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`cf_values_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `custom_fields` (
  `custom_fields_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `rel_crud` varchar(250) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `type` varchar(250) DEFAULT NULL,
  `required` int(11) DEFAULT NULL,
  `options` varchar(250) DEFAULT NULL,
  `status` varchar(250) DEFAULT NULL,
  `show_in_grid` int(11) DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`custom_fields_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `expense_category` (
  `expense_category_id` int(121) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) DEFAULT NULL,
  `expense_category_category_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`expense_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `expenses` (
  `expenses_id` int(121) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) DEFAULT NULL,
  `expenses_date` varchar(255) DEFAULT NULL,
  `expenses_description` varchar(255) DEFAULT NULL,
  `expenses_amount` float DEFAULT NULL,
  `expenses_category` varchar(255) DEFAULT NULL,
  `expenses_upload_receipt` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`expenses_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `income` (
  `income_id` int(121) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) DEFAULT NULL,
  `income_date` varchar(255) DEFAULT NULL,
  `income_description` varchar(255) DEFAULT NULL,
  `income_amount` float DEFAULT NULL,
  `income_category` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`income_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `income_category` (
  `income_category_id` int(121) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) DEFAULT NULL,
  `income_category_category_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`income_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `permission` (
  `id` int(122) unsigned NOT NULL AUTO_INCREMENT,
  `user_type` varchar(250) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;


INSERT INTO permission VALUES
("1","admin","{\"expenses\":\"expenses\",\"income\":\"income\",\"expense_category\":\"expense_category\",\"income_category\":\"income_category\",\"user\":\"user\"}"),
("2","user","{\"expenses\":\"expenses\",\"income\":\"income\",\"expense_category\":\"expense_category\",\"income_category\":\"income_category\",\"user\":\"user\"}");




CREATE TABLE `setting` (
  `id` int(122) unsigned NOT NULL AUTO_INCREMENT,
  `keys` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;


INSERT INTO setting VALUES
("1","website","Expense Management"),
("2","logo","logo.png"),
("3","favicon","favicon.ico"),
("4","SMTP_EMAIL",""),
("5","HOST",""),
("6","PORT",""),
("7","SMTP_SECURE",""),
("8","SMTP_PASSWORD",""),
("9","mail_setting","simple_mail"),
("10","company_name","Company Name"),
("11","crud_list","Expenses,Income,Expense Category,Income Category,User"),
("12","EMAIL",""),
("13","UserModules","yes"),
("14","register_allowed","1"),
("15","email_invitation","1"),
("16","admin_approval","0"),
("17","language","english"),
("18","user_type","[\"user\"]");




CREATE TABLE `templates` (
  `id` int(121) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `template_name` varchar(255) DEFAULT NULL,
  `html` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;


INSERT INTO templates VALUES
("1","forgot_pass","forgot_password","Forgot password","<html xmlns=\"http://www.w3.org/1999/xhtml\"><head>
("2","users","invitation","Invitation","<p>Hello <strong>{var_user_email}</strong></p>
("3","registration","registration","Registration","<p>Hello <strong>{var_user_name}</strong></p>




CREATE TABLE `users` (
  `users_id` int(121) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) DEFAULT NULL,
  `var_key` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_deleted` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `user_type` varchar(255) DEFAULT NULL,
  `create_date` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`users_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


INSERT INTO users VALUES
("1","1","","active","0","admin","admin_password","admin_email","demo_pic.png","admin","2017-08-18");

