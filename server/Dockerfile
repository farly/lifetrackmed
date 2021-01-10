FROM php:7.4-cli

COPY . /app

WORKDIR /app

EXPOSE 90

RUN ls

CMD ["php","-S","0.0.0.0:90","-t","web"]
