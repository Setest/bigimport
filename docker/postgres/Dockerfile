FROM postgres:12.1

RUN apt-get update && apt-get install sudo -y && usermod -aG sudo postgres

# go get the entrypoint script from their git hub link and details to follow
COPY ./run.sh /usr/local/bin/run.sh
RUN chmod +x /usr/local/bin/run.sh
COPY init.sql /docker-entrypoint-initdb.d/
CMD ["bash", "/usr/local/bin/run.sh"]