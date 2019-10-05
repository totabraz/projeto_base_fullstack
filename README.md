# What is this? 
- CodeIgniter 3 <PHP> project
- A CMS to start projects faster, with a better interface
  
# What u will need? 
- Xampp, wampp,.. or something like. (or apache + mysql)


# Setup:
- First, create a DB: 
`http://localhost/phpmyadmin, ..
- /_start_db/dp_projeto.sql

# To change: 
- _folder name:_
  `at: /projeto_base_fullstack/application/config/config.php`
  $config['base_url'] = 'http://localhost/projeto_base_fullstack/'; 
 - _DB name:_
  `at: /projeto_base_fullstack/application/config/database.php`
  defined('DATABASE_NAME') OR define('DATABASE_NAME', "db_projeto");
