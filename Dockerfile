FROM golang

COPY ./ /app/src/

ENV GOPATH=/app/src/
ENV GOBIN=/app/bin/

WORKDIR /app/

# Install requirements
RUN go get github.com/gliderlabs/ssh

# Compile
RUN go install src/gtw.go

# Run
CMD ["bin/gtw"]
