FROM nginx:1.25.0-alpine

ARG NGINX_SERVER

RUN apk --update --no-cache add tzdata && \
    cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime && \
    apk del tzdata

# nginx.conf
COPY ./docker/nginx/remote/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/nginx/remote/vhost.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www

RUN mkdir public

COPY ./public/ public/
