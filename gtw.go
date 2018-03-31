package main

import (
    "io"
    "log"
    "flag"
    "fmt"

    "github.com/gliderlabs/ssh"
)

func main() {
	// Commandline Arguments:
	// -port=8080 -host localhost:27017 -pass 12345 -user myUser -db trailDB
	portPtr := flag.Int("port", 2222, "an int")
//	userPtr := flag.String("user", "default", "Username")
//	passPtr := flag.String("pass", "12345", "Password")
//	mgoHostPtr := flag.String("host", "localhost:27017", "hostname:port")
//	dbPtr := flag.String("db", "thejml-trail", "Database to use")
	testPtr := flag.Bool("test", false, "Validate Build")

	flag.Parse()

	port := fmt.Sprint(*portPtr)
//	user := fmt.Sprint(*userPtr)
//	pass := fmt.Sprint(*passPtr)
//	db := fmt.Sprint(*dbPtr)
//	mgoHost := fmt.Sprint(*mgoHostPtr)
	test := *testPtr

	// Better info should be put here.
	if test != false {
		log.Println("Test Passed")
		return
	}

    ssh.Handle(func(s ssh.Session) {
        io.WriteString(s, "Hello world\n")
    })  

    log.Fatal(ssh.ListenAndServe(":"+port, nil))
}
