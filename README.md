# Compression Service

## Introduction

This application, powered by Laravel, specializes in file compression. It delivers output in various formats, such as
zip, 7zip, or tar.gz, which are configurable. The application takes a file as input and provides a compressed version of
the file as output.

## Installation

1. Download the files.
2. Execute `composer install` to install dependencies.
3. Generate an application key with `php artisan key:generate`.
4. Set up a new database in MySql.
5. Copy the configuration sample from `.env.example` to `.env` and define all required properties, which are
   DB_DATABASE, DB_USERNAME, DB_PASSWORD, and COMPRESS_FILE_TYPE.
   DB_USERNAME,
   DB_PASSWORD,
   COMPRESS_FILE_TYPE`)
6. Run `php artisan migrate` to perform migrations.

## Usage Guide

### File Upload Endpoint

Use the following CURL command to upload a file:

```bash
curl --location 'http://127.0.0.1:8000/api/compress/upload' \
--header 'Accept: application/json' \
--form 'file=@"your_file.png"'
```

Sample Response:

```bash
{
    "message": "file uploaded successfully.",
    "download-link": "http://127.0.0.1:8000/api/compress/download/9b553d81-737d-4979-84fe-c978ac490f50",
    "uuid": "9b553d81-737d-4979-84fe-c978ac490f50"
}
```

### Compressed File Download Endpoint

Utilize the following CURL command to download the compressed file:

```bash
curl --location 'http://127.0.0.1:8000/api/compress/download/9b553d81-737d-4979-84fe-c978ac490f50' 
```
