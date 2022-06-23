FROM python:3.8-alpine
ADD ./consumer /code
WORKDIR /code
RUN pip3 install -r requirements.txt
CMD ['python', 'app.py']