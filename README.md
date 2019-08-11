## File Upload Service

### List of available API endpoints

* POST /api/v1/upload -> UploadController@upload : Upload files accepts JSON POST and 
returns JSON with links to download uploaded files

- Request:
{"0":{"fileName":"61036-LM Lime.jpg","fileContent":"base64 encoded file content"}}

- Response on success:
{"success":1,"message":"Files uploaded","files":[{"name":"61036-LM Lime.jpg","url":"\/api\/v1\/file\/e835c880-bbb5-11e9-88d9-0242ac160004"}]}

- Response on error:
{"success":0,"message":"Unauthorized"}

- Header is required
API-KEY: EPo1vxXzgDrNfUhe (from .env)

### create test docker containers

- make up / docker-compose up -d / docker-compose build and after make up

### install components with composer

- make install

### run test container (docker container)

- make cli / docker-compose exec fpm bash

### to install database

- php artisan migrate:install
  
- php artisan migrate

### configure application 

- cp .env.dist .env

You can configure application from .env file

### to run application

- http://localhost:8080 (async upload) - one file one call
- http://localhost:8080/sync (sync upload) - all files in one call

nginx has port map to localhost 8080 port.
This is a simple form to upload files. 
It is configured by default to accept only images. 
As a result you will see message with links where files can be downloaded.

Files are stored locally in storage/app grouped in directories my date (2019-08-09).
File are stored crypted with key APP_KEY from .env





