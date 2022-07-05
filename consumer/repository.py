import os
import mysql.connector
from mysql.connector import errorcode

def get_connection():
    try:
        cnx = mysql.connector.connect(
            user=os.environ['DB_USER'], 
            password=os.environ['DB_PASSWORD'],
            host='db',
            database=os.environ['DB_DATABASE']
        )

        return cnx

    except mysql.connector.Error as err:
        if err.errno == errorcode.ER_ACCESS_DENIED_ERROR:
            print("Something is wrong with your user name or password")
        elif err.errno == errorcode.ER_BAD_DB_ERROR:
            print("Database does not exist")
        else:
            print(err)
    else:
        cnx.close()

def insert(data):
    insert_spreadsheet = """
    INSERT INTO spreadsheets (client_id, from_postcode, to_postcode, from_weight, to_weight, cost) VALUES (1, '{}', 'test', 1.76, 2.67, 1.78)
    """.format(data)
    print(insert_spreadsheet)

    conn = get_connection()
    cursor = conn.cursor()
    cursor.execute(insert_spreadsheet)
    conn.commit()
    cursor.close()
    conn.close()
    
