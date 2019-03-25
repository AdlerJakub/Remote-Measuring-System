import mysql.connector
import datetime
import random

from pip._vendor.distlib.compat import raw_input


def insertPythonVaribleInTable(id, value, date, device_id):
    try:
        connection = mysql.connector.connect(host='localhost',
                                             database='project',
                                             user='root',
                                             password='')
        cursor = connection.cursor(prepared=True)

        sql_insert_query = """ INSERT INTO `voltage` 
                                (`id`, `value`, `date`, `device_id`) VALUES (%s,%s,%s,%s)"""
        insert_tuple = (id, value, date, device_id)
        result = cursor.execute(sql_insert_query, insert_tuple)
        connection.commit()
        print("Record inserted successfully into python_users table")

        sql_insert_query = """ INSERT INTO `current` 
                                  (`id`, `value`, `date`, `device_id`) VALUES (%s,%s,%s,%s)"""
        insert_tuple = (id, value, date, device_id)
        result = cursor.execute(sql_insert_query, insert_tuple)
        connection.commit()
        print("Record inserted successfully into python_users table")

        sql_insert_query = """ INSERT INTO `bptransistorgain` 
                                  (`id`, `value`, `date`, `device_id`) VALUES (%s,%s,%s,%s)"""
        insert_tuple = (id, value, date, device_id)
        result = cursor.execute(sql_insert_query, insert_tuple)
        connection.commit()
        print("Record inserted successfully into python_users table")

        sql_insert_query = """ INSERT INTO `resistance` 
                                  (`id`, `value`, `date`, `device_id`) VALUES (%s,%s,%s,%s)"""
        insert_tuple = (id, value, date, device_id)
        result = cursor.execute(sql_insert_query, insert_tuple)
        connection.commit()
        print("Record inserted successfully into python_users table")

        sql_insert_query = """ INSERT INTO `capacity` 
                                  (`id`, `value`, `date`, `device_id`) VALUES (%s,%s,%s,%s)"""
        insert_tuple = (id, value, date, device_id)
        result = cursor.execute(sql_insert_query, insert_tuple)
        connection.commit()
        print("Record inserted successfully into python_users table")

        sql_insert_query = """ INSERT INTO `diodevoltage` 
                                  (`id`, `value`, `date`, `device_id`) VALUES (%s,%s,%s,%s)"""

        insert_tuple = (id, value, date, device_id)
        result = cursor.execute(sql_insert_query, insert_tuple)
        connection.commit()
        print("Record inserted successfully into python_users table")
    except mysql.connector.Error as error:
        connection.rollback()
        print("Failed to insert into MySQL table {}".format(error))
    finally:
        # closing database connection.
        if (connection.is_connected()):
            cursor.close()
            connection.close()
            print("MySQL connection is closed")



data = datetime.datetime.today().strftime('%Y-%m-%d')
value=random.random() + 9.5
deviceid= random.randint(1,3)
insertPythonVaribleInTable(None, value, data, deviceid)

liczby = raw_input()