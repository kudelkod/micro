FROM golang:latest

WORKDIR /var/www/html

COPY . .
RUN go mod tidy
EXPOSE 3000