FROM php:7.3-cli-alpine

# ref. https://github.com/dapr/cli/blob/d585612185a4a525c05fb62b86e288ccad510006/pkg/standalone/standalone.go#L265
RUN curl -Lo /tmp/daprd.tar.gz \
      https://github.com/dapr/dapr/releases/download/v0.3.0/daprd_linux_amd64.tar.gz \
  && tar xzvf /tmp/daprd.tar.gz -C /usr/local/bin

WORKDIR /app
COPY . .

EXPOSE 3500 50001
ENTRYPOINT ["daprd",\
    "--dapr-id",\
    "dapr-endpoint",\
    "--dapr-http-port",\
    "3500",\
    "--dapr-grpc-port",\
    "50001",\
    "--log-level",\
    "info",\
    "--max-concurrency",\
    "-1",\
    "--protocol",\
    "http",\
    "--placement-address",\
    "placement:50005"\
]
CMD [""]