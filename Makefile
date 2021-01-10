build_stack:
	docker build ./server -t img.ltm.be:latest
	docker run --name ltm.fe -v ${PWD}/client:/usr/share/nginx/html -p 9000:80 -d nginx:latest
	docker run --name ltm.be -p 9090:90 -d img.ltm.be:latest

start_dev:
	docker start ltm.fe
	docker start ltm.be

stop_dev:
	docker stop ltm.fe
	docker stop ltm.be


remove_stack:
	-docker stop ltm.fe
	-docker stop ltm.be
	-docker container rm ltm.be
	-docker container rm ltm.fe
