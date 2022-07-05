import os
import mysql.connector
from mysql.connector import errorcode

def get_connection():
    """Opens a new connection to the database."""
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
    """Inserts a new shipping row to the database."""
    insert_spreadsheet = """
    INSERT INTO spreadsheets (client_id, from_postcode, to_postcode, from_weight, to_weight, cost) VALUES (1, {})
    """.format(data)

    conn = get_connection()
    cursor = conn.cursor()
    cursor.execute(insert_spreadsheet)
    conn.commit()
    cursor.close()
    conn.close()

def get_sql_values(row, delimiter=';'):
    """Gets the SQL values from a given spreadsheet row."""
    row = row.split(delimiter)
    value = ''

    counter = 1
    for field in row:
        if row.index(field) in [2, 3, 4]:
            field = field.replace('.', '')
            field = field.replace(',', '.')
            value += str(float(field))
        else:
            value += "\'"+field+"\'"
        
        if counter < len(row):
            value += ', '
        
        counter+=1
    
    return value
  
