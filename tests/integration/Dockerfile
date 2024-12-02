FROM ubuntu:22.04

RUN apt update \
    && apt install -y git \
            python3-pip \
            python3-dev \
            libffi-dev \
            libssl-dev \
            libsqlite3-dev

WORKDIR /usr/local
RUN git clone --depth=1 https://github.com/OpenKMIP/PyKMIP.git
WORKDIR /usr/local/PyKMIP

RUN python3 /usr/local/PyKMIP/setup.py install

ENTRYPOINT ["python3", "/usr/local/PyKMIP/bin/run_server.py"]