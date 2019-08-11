FROM nginx:stable

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        bc \
        curl \
        unzip \
    && rm -rf /var/lib/apt/lists/*

# set www-data user to match the home user
RUN groupmod -g 1000 www-data && usermod -u 1000 -g 1000 www-data

CMD ["nginx", \
        "-g", \
        "daemon off;"]