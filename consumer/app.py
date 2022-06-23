# import Flask object from flask library
# you can install flask by pip install flask
from flask import Flask
# initialize Flask app with the name of the file
app = Flask(__name__)

# define the url for which the application should send an http response to
@app.route('/')
# plain python function to handle the request
def hello_world():
    # expected return from the function for the request (to the browser)
    return "Hello World!"

# executed the above defined Flask app
if __name__ == '__main__':
    # initialize the app by invoking the Flask function run()
    app.run()