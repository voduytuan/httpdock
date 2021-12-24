# httpdock

Very simple mock HTTP Server for testing Restful API, running via Docker.

## Start Server

Starting this server via command:

```ssh
docker run -ti -d -p 8080:80 voduytuan/httpdock
```

Above command will serve HTTP Restful request at port `8080`. You can change port 8080 to another port if this port had already used on your host.

## Usage

After starting, this web server will expose url `/v1/mocks`. Request to `http://localhost:8080/v1/mocks` will get response. This endpoint accepts HTTP Method `GET`, `POST`, `PUT`, `DELETE` and `OPTIONS`.

### Query parameters:

This API support following query parameters:

- `status`: return HTTP Status code with this value. Eg: `/v1/mocks?status=201`, `/v1/mocks?status=404`...
- `format`: Support 2 format, `json` (default) and `text`. Eg: `/v1/mocks?format=text`
- `size`: payload size (in byte), in case you want to receive long length response. Eg: `/v1/mocks?size=1024`
- `delay`: response delay (in microsecond). Eg: `/v1/mocks?delay=2000000` (this response will delay 2 seconds = 2.000.000 microseconds)

You can use one or all parameters in one request. Eg: `/v1/mocks?status=422&format=json&size=2048&delay=300`...

## Source code

Source code of this project hosted at [https://github.com/voduytuan/httpdock]. This project is developed in Slim Framework v4, and running with Apache & PHP 8. You can customize service behaviors in file `./public/index.php` and build your own docker image (eg: `docker build . -t your-image`).
