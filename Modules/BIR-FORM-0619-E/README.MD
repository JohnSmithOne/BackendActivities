# Pixel8 Core Backend

This is the core backend handler for all Pixel8 Subsystems.

## Please follow the steps given below.

Step 1. After cloning this repository open a cmd inside the root folder

```
core-backend
```

and run

```
composer install
```

Step 2. Go to

```
Server/Resources/
```

folder open cmd and clone the Subsystem that you will use

```
(ex. The JuanHR System. `git clone https://gitlab.com/pixel8is/juanhr/juanhr-backend.git`).
```

Step 3. Checkout to the module/branch that you will register

```
(ex. JuanHR - Allowance module/branch)
```

## CLI Feature Usage

Registration of modules. All modules that are not registered using the cli will not appear on the frontend sidebar.

In these steps you are about to register a specific module from the Subsystem to the database.

Step 1. Open a cmd inside the root folder

```
core-backend
```

and run

```
php bin/core register juanHR
```

`JuanHR` is the folder name of the subsystem you used.

Step 2. You will be instructed to type the system name for `JuanHR`. Just simply type

```
ex. juanHR
```

Step 3. You will be instructed to type the system description for `JuanHR`. Just simply type

```
ex. Human Resource Management System
```

Step 4. You will be instructed to type the main module name (the branch you are currently checkedout). Just simply type

```
ex. Allowance
```

Step 5. You will be instructed to type the main module description (the branch you are currently checkedout). Just simply type

```
ex. The description
```

Step 6. You will be instructed to type the sub module name (the branch you are currently checkedout). Just simply type

```
 ex. Allowance Configuration
```

Step 7. You will be instructed to type the sub module description (the branch you are currently checkedout). Just simply type

```
ex. The description
```

Step 8. Setting up permissions will appear. Just long press the enter until the

```
Resource registered successfully
```

appear. Great! you are almost done.

Step 9. Go and check the core database

```
p8_core_db
```

Step 10. Open

```
tbl_systems
```

and check the subsystem/system that you registered.

Step 11. Open

```
tbl_modules
```

and check the main module and submodule that you registered.

Step 12. Open

```
tbl_functions
```

and find the alias/requests of the module and submodule that you registered (

```
ex. ALLOWANCE_GET,POST,PUT,DELETE
```

From the submodule request columns

```
ex. ALLOWANCE_CONFIGURATION_GET,POST,PUT,DELETE
```

you will replicate the module id of the main module that you registered.

Step 13. Open

```
tbl_account_function_permissions
```

Here is where you will set the permissions of the user. Get the function id of the alias/requests from

```
tbl_functions
```

and add the permission you want.

```
ex. `account_id` = user account id, `function_id` = ALLOWANCE_GET id
```

Great! all is done. You can now start exploring the core frontend.
