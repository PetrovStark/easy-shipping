# Easy Shipping
Easy Shipping is a simple POC (Proof Of Concept) for file (CSV) ingestion to automate the updating of cargo prices data process.

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

The **messagebroker** handles the messaging service, when a new spreadsheet is uploaded in **webapp**, a new message is triggered for this service and stored in a execution queue, which will be fetched by the **consumer** service in the future.

The **consumer** fetch new messages from the **messagebroker** queue and handles the process of importing the spreadsheets files into the database.

The **db** contains the database into which the spreadsheet will be uploaded, which is accessible for **webapp** and **consumer**.

## First steps
Firstly, clone this repo to your local environment, build the docker container network, copy the .env.example file to a new .env file, and run the laravel migrations inside the **webapp** container:

```shell
docker-compose up -d
cp ./webapp/.env.example ./webapp/.env
docker exec -it webapp /bin/bash
composer install --ignore-platform-reqs
php artisan migrate
php artisan key:generate
```

*If you're facing permissions issues, follow [this tutorial](https://docs.docker.com/engine/install/linux-postinstall/#manage-docker-as-a-non-root-user) to grant permissions to your user and you're good to go.*

Access the database hosted in **db** container (You can find the credentials in the `docker-compose.yml` file), and list the `spreadsheets` table:
```shell
docker exec -it db sh
mysql -uroot -pmauFJcuf5dhRMQrjj
```
```sql
mysql> USE frete_facil_db;
mysql> SELECT * FROM spreadsheets;
```
It should retrieve an empty table with the columns of the database structure.

## Upload a new spreadsheet
Access the **webapp** application in [http://localhost:8000](http://localhost:8000) and upload the `price-table.csv` spreadsheet which you can find in the repo.

## Check the uploaded data
Access again the database from **db** running the same commands from "First Steps":

```shell
docker exec -it db sh
mysql -uroot -pmauFJcuf5dhRMQrjj
```
```sql
mysql> USE frete_facil_db;
mysql> SELECT * FROM spreadsheets;
```

It should retrieve the uploaded data from the spreadsheet, if you run this query several times, you'll notice that the import is happening in real-time.
