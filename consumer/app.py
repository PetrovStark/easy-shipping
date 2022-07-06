import pika
import sys
import os
import time
import repository
from generators import read_csv

def import_csv(ch, method, properties, body):
    """Imports the spreadsheet to the database when a new message arrives."""
    csv_gen = read_csv(body.decode('utf-8'))

    next(csv_gen) # Generator should skip the spreadsheet headers.
    for row in csv_gen:
        repository.insert(repository.get_sql_values(row))

def main():
    """Listens to new csv_paths queue messages and handles the spreadsheet import."""
    connection = pika.BlockingConnection(pika.ConnectionParameters('messagebroker', 5672))
    channel = connection.channel()
    channel.queue_declare(queue='csv_paths')

    channel.basic_consume(queue='csv_paths', on_message_callback=import_csv, auto_ack=True)
    channel.start_consuming()

if __name__ == '__main__':
    try:
        main()
    except KeyboardInterrupt:
        print('Hasta la vista, baby!')
        try :
            sys.exit(0)
        except SystemExit:
            os._exit(0)