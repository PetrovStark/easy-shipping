# syntax=docker/dockerfile:1
FROM python:3.7-alpine
WORKDIR /code
RUN apk update && apk add --no-cache gcc musl-dev linux-headers bash
COPY ./consumer/requirements.txt requirements.txt
RUN pip install -r requirements.txt
EXPOSE 5000
COPY ./consumer .
CMD ["./wait-for-it.sh", "messagebroker:5672", "--", "python3", "app.py"]