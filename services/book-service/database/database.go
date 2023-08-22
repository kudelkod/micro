package database

import (
	"database/sql"
)

func ConnDB() *sql.DB {
	connStr := "user=postgres password=mypass dbname=productdb sslmode=disable"
	db, err := sql.Open("postgres", connStr)
	if err != nil {
		panic(err)
	}

	return db
}
