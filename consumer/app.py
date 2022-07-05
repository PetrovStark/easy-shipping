import pika
import sys
import os
import time
from repository import insert

time.sleep(10)
print('RabbitMQ is ready to rock!')

def import_csv(ch, method, properties, body):
    insert(body.decode('utf-8'))

def main():
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