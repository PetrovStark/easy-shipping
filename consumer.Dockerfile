# syntax=docker/dockerfile:1
FROM python:3.7-alpine
WORKDIR /code
RUN apk add --no-cache gcc musl-dev linux-headers
COPY ./consumer/requirements.txt requirements.txt
RUN pip install -r requirements.txt
EXPOSE 5000
COPY ./consumer .
CMD ["python3", "app.py"]