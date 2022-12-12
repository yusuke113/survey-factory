FROM node:lts-buster-slim

WORKDIR /var/www/src

COPY client/ /var/www/

RUN npm install

CMD ["npm", "run", "dev"]