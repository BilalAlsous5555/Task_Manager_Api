## Api_Task_Manager

--this project implement Auth:sanctum and Authoriazation using Gates .
--i used FormRequest for validation and middleware to protect Api Pathes .

## Data Base

show this image to know the structure : Task_Manager_API\s.png

## Project Actions

-- TaskController.php :
responseble for CRUD Tasks By admin , users only show there own taks .

-- StatusController.php :
responseble for CRUD Status By admin , users only show there own Status .

## Seeding Data

php artisan migrate:fresh --seed
