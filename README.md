# CJ Vehicle Tracker

Welcome to the `cj-vehicle-tracker-be` repository. This project is designed to track vehicles efficiently.


## Installed
1. php artisan install:api
2. composer require darkaonline/l5-swagger
    - php artisan vendor:publish --provider="L5Swagger\L5SwaggerServiceProvider"
    - add to base controller
    /** @OA\Info(title="My First API", version="0.1")*/ 
    /** @OA\Server(url="http://127.0.0.1:8000/api")*/
    - add to controller
    /** @OA\Get( path="/users", summary="Get users", @OA\Response( response=200, description="Successful operation"))*/
    - php artisan l5-swagger:generate