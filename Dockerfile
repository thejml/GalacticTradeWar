FROM golang

COPY ./ /app/src/

ENV GOPATH=/app/src/
ENV GOBIN=/app/bin/

WORKDIR /app/

# Install requirements
RUN go get github.com/gliderlabs/ssh golang.org/x/sys/unix golang.org/x/crypto/ssh/terminal

# Compile
RUN go install src/gtw.go

# Run
CMD ["bin/gtw"]
