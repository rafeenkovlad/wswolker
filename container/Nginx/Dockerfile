FROM nginx:stable-alpine

RUN mkdir /var/log/wswalker/ && \
    touch /var/log/wswalker/notifi.error.log && \
    chmod -R 777 /var/log/wswalker/
WORKDIR /etc/nginx/conf.d
