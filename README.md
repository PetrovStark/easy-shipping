# Easy Shipping
Easy Shipping is a simple application for file (CSV) ingestion to automate the updating of cargo prices data process.

## Stack
- Docker Community
- PHP v7.4 / Laravel v8.83
- Apache v2
- MySQL v5.7
- Python v3
- RabbitMQ v3.10

## Prerequisites
- Install [Docker](https://www.docker.com/get-started/) in your local machine.

## How it works
I use a total of 4 services to get the job done: 

The **webapp** handles the user interface, where the user will import the shipping adjustment spreadsheet.

The **messagebroker** handles the messaging service, when a new spreadsheet is uploaded in **webapp**, a new message is triggered for this service and stored in a execution queue, which will be intercepted by the **consumer** service in the future.

The **consumer** intercept messages from the **messagebroker** queue and handles the process of importing the spreadsheets files into the database.

The **db** contains the database into which the spreadsheet will be uploaded, which is accessible for **webapp** and **consumer**.

## First steps
Firstly, clone this repo to your local environment, build the docker container network, and run the laravel migrations inside the **webapp** container:

```shell
$ sudo docker-compose up -d
$ sudo docker exec -it webapp /bin/bash
$ php artisan migrate
```

Access the database hosted in **db** container (You can find the credentials in the `docker-compose.yml` file), and run this SQL query:
```sql
SELECT * FROM spreadsheets;
```
It should retrieve an empty table with the columns of the database structure.

## Upload a new spreadsheet
Access the **webapp** application in [http://localhost:8000](http://localhost:8000), and upload the `price-table.csv` spreadsheet which you can find in the repo.

## Check the uploaded data
Access again the database from **db** running the same query from "First Steps":

```sql
SELECT * FROM spreadsheets;
```

It should retrieve the uploaded data from the spreadsheet, if you run this query several times, you'll notice that the import is happening in real-time, because I'm using python generator functions, ideal for reading large files.

## This project is unfinished :(
Unfortunately, this project is not finished yet, I still have to deal with consumer exceptions regarding the spreadsheet format, create a customer entity to allow processing of multiple spreadsheets, I intend to continue working on it even if it doesn't pass the technical challenge.