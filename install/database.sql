

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
("1","forgot_pass","forgot_password","Forgot password","<html xmlns=\"http://www.w3.org/1999/xhtml\"><head>\n  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n  <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">\n  <style type=\"text/css\" rel=\"stylesheet\" media=\"all\">\n    /* Base ------------------------------ */\n    *:not(br):not(tr):not(html) {\n      font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;\n      -webkit-box-sizing: border-box;\n      box-sizing: border-box;\n    }\n    body {\n      \n    }\n    a {\n      color: #3869D4;\n    }\n\n\n    /* Masthead ----------------------- */\n    .email-masthead {\n      padding: 25px 0;\n      text-align: center;\n    }\n    .email-masthead_logo {\n      max-width: 400px;\n      border: 0;\n    }\n    .email-footer {\n      width: 570px;\n      margin: 0 auto;\n      padding: 0;\n      text-align: center;\n    }\n    .email-footer p {\n      color: #AEAEAE;\n    }\n  \n    .content-cell {\n      padding: 35px;\n    }\n    .align-right {\n      text-align: right;\n    }\n\n    /* Type ------------------------------ */\n    h1 {\n      margin-top: 0;\n      color: #2F3133;\n      font-size: 19px;\n      font-weight: bold;\n      text-align: left;\n    }\n    h2 {\n      margin-top: 0;\n      color: #2F3133;\n      font-size: 16px;\n      font-weight: bold;\n      text-align: left;\n    }\n    h3 {\n      margin-top: 0;\n      color: #2F3133;\n      font-size: 14px;\n      font-weight: bold;\n      text-align: left;\n    }\n    p {\n      margin-top: 0;\n      color: #74787E;\n      font-size: 16px;\n      line-height: 1.5em;\n      text-align: left;\n    }\n    p.sub {\n      font-size: 12px;\n    }\n    p.center {\n      text-align: center;\n    }\n\n    /* Buttons ------------------------------ */\n    .button {\n      display: inline-block;\n      width: 200px;\n      background-color: #3869D4;\n      border-radius: 3px;\n      color: #ffffff;\n      font-size: 15px;\n      line-height: 45px;\n      text-align: center;\n      text-decoration: none;\n      -webkit-text-size-adjust: none;\n      mso-hide: all;\n    }\n    .button--green {\n      background-color: #22BC66;\n    }\n    .button--red {\n      background-color: #dc4d2f;\n    }\n    .button--blue {\n      background-color: #3869D4;\n    }\n  </style>\n</head>\n<body style=\"width: 100% !important;\n      height: 100%;\n      margin: 0;\n      line-height: 1.4;\n      background-color: #F2F4F6;\n      color: #74787E;\n      -webkit-text-size-adjust: none;\">\n  <table class=\"email-wrapper\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"\n    width: 100%;\n    margin: 0;\n    padding: 0;\">\n    <tbody><tr>\n      <td align=\"center\">\n        <table class=\"email-content\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"width: 100%;\n      margin: 0;\n      padding: 0;\">\n          <!-- Logo -->\n\n          <tbody>\n          <!-- Email Body -->\n          <tr>\n            <td class=\"email-body\" width=\"100%\" style=\"width: 100%;\n    margin: 0;\n    padding: 0;\n    border-top: 1px solid #edeef2;\n    border-bottom: 1px solid #edeef2;\n    background-color: #edeef2;\">\n              <table class=\"email-body_inner\" align=\"center\" width=\"570\" cellpadding=\"0\" cellspacing=\"0\" style=\" width: 570px;\n    margin:  14px auto;\n    background: #fff;\n    padding: 0;\n    border: 1px outset rgba(136, 131, 131, 0.26);\n    box-shadow: 0px 6px 38px rgb(0, 0, 0);\n       \">\n                <!-- Body content -->\n                <thead style=\"background: #3869d4;\"><tr><th><div align=\"center\" style=\"padding: 15px; color: #000;\"><a href=\"{var_action_url}\" class=\"email-masthead_name\" style=\"font-size: 16px;\n      font-weight: bold;\n      color: #bbbfc3;\n      text-decoration: none;\n      text-shadow: 0 1px 0 white;\">{var_sender_name}</a></div></th></tr>\n                </thead>\n                <tbody><tr>\n                  <td class=\"content-cell\" style=\"padding: 35px;\">\n                    <h1>Hi {var_user_name},</h1>\n                    <p>You recently requested to reset your password for your {var_website_name} account. Click the button below to reset it.</p>\n                    <!-- Action -->\n                    <table class=\"body-action\" align=\"center\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"\n      width: 100%;\n      margin: 30px auto;\n      padding: 0;\n      text-align: center;\">\n                      <tbody><tr>\n                        <td align=\"center\">\n                          <div>\n                            <!--[if mso]><v:roundrect xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:w=\"urn:schemas-microsoft-com:office:word\" href=\"{{var_action_url}}\" style=\"height:45px;v-text-anchor:middle;width:200px;\" arcsize=\"7%\" stroke=\"f\" fill=\"t\">\n                              <v:fill type=\"tile\" color=\"#dc4d2f\" />\n                              <w:anchorlock/>\n                              <center style=\"color:#ffffff;font-family:sans-serif;font-size:15px;\">Reset your password</center>\n                            </v:roundrect><![endif]-->\n                            <a href=\"{var_varification_link}\" class=\"button button--red\" style=\"background-color: #dc4d2f;display: inline-block;\n      width: 200px;\n      background-color: #3869D4;\n      border-radius: 3px;\n      color: #ffffff;\n      font-size: 15px;\n      line-height: 45px;\n      text-align: center;\n      text-decoration: none;\n      -webkit-text-size-adjust: none;\n      mso-hide: all;\">Reset your password</a>\n                          </div>\n                        </td>\n                      </tr>\n                    </tbody></table>\n                    <p>If you did not request a password reset, please ignore this email or reply to let us know.</p>\n                    <p>Thanks,<br>{var_sender_name} and the {var_website_name} Team</p>\n                   <!-- Sub copy -->\n                    <table class=\"body-sub\" style=\"margin-top: 25px;\n      padding-top: 25px;\n      border-top: 1px solid #EDEFF2;\">\n                      <tbody><tr>\n                        <td> \n                          <p class=\"sub\" style=\"font-size:12px;\">If you are having trouble clicking the password reset button, copy and paste the URL below into your web browser.</p>\n                          <p class=\"sub\"  style=\"font-size:12px;\"><a href=\"{var_varification_link}\">{var_varification_link}</a></p>\n                        </td>\n                      </tr>\n                    </tbody></table>\n                  </td>\n                </tr>\n              </tbody></table>\n            </td>\n          </tr>\n        </tbody></table>\n      </td>\n    </tr>\n  </tbody></table>\n\n\n</body></html>"),
("2","users","invitation","Invitation","<p>Hello <strong>{var_user_email}</strong></p>\n\n<p>Click below link to register&nbsp;<br />\n{var_inviation_link}</p>\n\n<p>Thanks&nbsp;</p>\n"),
("3","registration","registration","Registration","<p>Hello <strong>{var_user_name}</strong></p>\n<p>Welcome to Notes&nbsp;<br />\n<p>To complete your registration&nbsp;<br /><br />\n<a href=\"{var_varification_link}\">please click here</a></p>\n\n<p>Thanks&nbsp;</p>");




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


