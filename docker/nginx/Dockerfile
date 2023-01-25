FROM nginx:stable-alpine

ENV TZ Asia/Tokyo

COPY ./docker/nginx/default.conf /etc/nginx/nginx.conf

CMD ["nginx", "-g", "daemon off;"]