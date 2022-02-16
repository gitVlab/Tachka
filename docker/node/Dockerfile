FROM node:16-alpine3.14

# Change uid of node
ARG uid
RUN apk add --no-cache; \
    usermod -u ${uid} node; \
    groupmod -g ${uid} node; \
    apk del --purge

USER root
WORKDIR /home/node
