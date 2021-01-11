# DEVELOPMENT 

## PRE REQ
 - docker
 - Make (optional)

## BUILD
execute `make build_stack` or if make is not installed
```
docker build ./server -t img.ltm.be:latest
docker run --name ltm.fe -v ${PWD}/client:/user/share/nginx/html -p 9000:80 -d nginx:latest
docker run --name ltm.be -p 9090:90
```

## RUN APP
execute `make start_dev` or if make is not intalled
```
docker start ltm.fe
docker start ltm.be
```

## ACCESS
access via browser at `0.0.0.0:9000`

