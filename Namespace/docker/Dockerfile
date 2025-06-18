#Docker container begins as a simple vanilla linux machine that does not have anything installed for the application
#We tell the container what neeeds to be installed like all the dependencies that are needed to run the application
#This is done through this file, Dockerfile, it is a text file where you write instructions on how to build
#a docker image which is a read-only executable package that includes everything needed to run your application 


FROM php:8.0.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip 

WORKDIR /var/www