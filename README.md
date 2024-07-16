For run project:
    1. run: composer install
    2. run: (for Windows) cp .env.example .env | (for Linux) copy .env.example .env
    3. configure .env
    4. run: php artisan migrate
    5. run: php artisan key:generate
    6. run: php artisan serve

For test:
    1. run: php artisan test


Registration for API:

    Request:
    POST http://127.0.0.1:8000/api/register 
            {
                "name":"Your Name",
                "email":"Your Email",
                "password":"New Password",
                "c_password":"Retry Password"
            }
    Responce:
            {
                "success": true,
                "data": {
                    "token": "1|DqNmIhlyIk358Mbe5AIhb1argIJe7U7pQllU13G08500d414",//this is a Bearer token
                    "name": "sohibjon"
                },
                "message": "User register successfully."
            }

    After registration you can delete route Route::post('register', 'register'); 

Getting Token with credentials:

    Request:
    POST http://127.0.0.1:8000/api/login
            {
                "email":"Your Email",
                "password":"Ypur Password",
            }

List Tasks:
        Request:
        GET http://127.0.0.1:8000/api/v1/tasks Bearer Token
                {
                    "status":"todo",
                    "deadline_from":"2024-01-01",
                    "deadline_to":"2024-07-01"
                }

Create Task:
        Request:
        POST http://127.0.0.1:8000/api/v1/tasks Bearer Token
                {
                    "title": "Title",
                    "description": "Description",
                    "deadline": "[Date]",
                    "status": "todo | in_progress | completed"
                }
Update Task:
        Request:
        PUT http://127.0.0.1:8000/api/v1/tasks/update/{task_id} Bearer Token
                {
                    "title": "Title", // Nullable
                    "description": "Description", // Nullable
                    "deadline": "[Date]", // Nullable
                    "status": "todo | in_progress | completed" // Nullable
                }
        All parameters nullable but at least one of the fields must be modified;

Delete Task:
        Request:
        DELETE http://127.0.0.1:8000/api/v1/tasks/delete/{task_id}

        Used SoftDeletes
