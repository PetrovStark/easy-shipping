# Easy Shipping
A spreadsheet importer capable of handling large amounts of data.

## Prerequisites
- Install [Docker](https://www.docker.com/get-started/) in your local machine.

## Introduction
I use a total of 4 services to get the job done: 

The **webapp** handles the user interface, where the user will import the shipping adjustment spreadsheet, i chose the Laravel framework for this service, as it offers me all the basic structure for storing files, saving me the time needed to implement it natively.

The **messagebroker** handles the messaging service, when a new spreadsheet is imported in **webapp**, a new message is triggered for this service and stored in a execution queue, which will be intercepted by the **consumer** service in the future. I choose RabbitMQ due to its simplicity, the documentation is quite intuitive even for those who do not have much experience with messaging services like me.

The **consumer** intercept messages from the **messagebroker** queue and handles the process of importing the spreadsheets files into the database. Despite the project requirements requiring the use of PHP, i took the liberty of using Python for this service, as it works better with this kind of data processing.

The **db** contains the database into which the spreadsheet will be imported. I decided to reuse the MySQL database used by the **webapp** service, so I can implement the shipping readjustment views with the imported data.

## First steps
Firstly, clone this repo to your local environment, build the docker container network, and run the laravel migrations inside the **webapp** container:

```shell
$ sudo docker-compose up -d
$ sudo docker exec -it frete-facil_webapp_1 /bin/bash
$ php artisan migrate
```

Access the **db** database (access information will be in the `docker-compose.yml` file), and run this SQL query:
```sql
SELECT * FROM spreadsheets;
```
It should render an empty table with the columns of the database structure.

## Upload a new spreadsheet
Access the **webapp** application in [http://localhost:8000](http://localhost:8000), and upload the `price-table.csv` spreadsheet which you can find in the repo.

## Check the imported data
Access again the **db** database running the same query from "First Steps", you should see the imported data from the spreadsheet.