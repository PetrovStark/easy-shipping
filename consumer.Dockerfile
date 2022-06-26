FROM python:3.7-alpine
WORKDIR /code
COPY ./consumer/requirements.txt requirements.txt
RUN pip install -U pip && pip install -r requirements.txt;
COPY . .
CMD gunicorn -c gunicorn.conf.py