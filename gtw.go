package main

import (
	"flag"
	"fmt"
	"io"
	"log"
	"time"

	"github.com/gliderlabs/ssh"
	"github.com/globalsign/mgo"
	"github.com/mgutz/ansi"
	"golang.org/x/crypto/ssh/terminal"
	"gopkg.in/mgo.v2/bson"
)

type SectorLinks struct {
	SectorID int    `json:"sectorid"`
	Link     string `json:"link"`
}

type SectorData struct {
	SectorID int    `json:"sectorid"`
	Planet   string `json:"planet"`
	Starbase string `json:"starbase"`
	Fighters int    `json:"fighters"`
}

var ()

func main() {

	const (
		DATABASE   = "gtw"
		COLLECTION = "sectors"
	)

	// Commandline Arguments:
	// -port=8080 -host localhost:27017 -pass 12345 -user myUser -db trailDB
	portPtr := flag.Int("port", 2222, "an int")
	//	userPtr := flag.String("user", "default", "Username")
	//	passPtr := flag.String("pass", "12345", "Password")
	//	mgoHostPtr := flag.String("host", "localhost:27017", "hostname:port")
	//	dbPtr := flag.String("db", "thejml-trail", "Database to use")
	testPtr := flag.Bool("test", false, "Validate Build")
	IdleTimeout := 10 * time.Second

	flag.Parse()

	port := fmt.Sprint(*portPtr)
	//	user := fmt.Sprint(*userPtr)
	//	pass := fmt.Sprint(*passPtr)
	//	db := fmt.Sprint(*dbPtr)
	//	mgoHost := fmt.Sprint(*mgoHostPtr)
	test := *testPtr

	// Create an mgo client
	session, err := mgo.Dial("192.168.1.199")

	if err != nil {
		// Handle error
	}

	c := session.DB(DATABASE).C(COLLECTION)

	var sectors []SectorData
	err = c.Find(bson.M{}).All(&sectors)

	log.Println(sectors)

	// Better info should be put here.
	if test != false {
		log.Println("Test Passed")
		return
	}

	ssh.Handle(func(s ssh.Session) {
		log.Println("new connection")
		// Color baselines:
		phosphorize := ansi.ColorFunc("green+h:black")
		sectorize := ansi.ColorFunc("red+h:black")
		//		shipize     := ansi.ColorFunc("blue+h:black")

		term := terminal.NewTerminal(s, sectorize("Sector 48")+phosphorize(" Move ship: Y/n? "))
		line, err := term.ReadLine()
		if err == nil {
			io.WriteString(s, "Hello "+line+"\n")
		} else {
			io.WriteString(s, "I didn't get that!\n")
		}
	})

	mainServer := &ssh.Server{
		Addr:        ":" + port,
		IdleTimeout: IdleTimeout,
	}

	log.Fatal(mainServer.ListenAndServe())

	//	log.Fatal(ssh.ListenAndServe(":"+port, nil))
}
