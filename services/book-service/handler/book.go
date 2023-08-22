package handler

import (
	"fmt"
	"github.com/gofiber/fiber/v2"
)

func GetAllProducts(c *fiber.Ctx) error {
	//db := database.ConnDB()
	//result, err := db.Query("select * from books")
	//if err != nil {
	//	panic(err)
	//}
	fmt.Println("result")

	return c.JSON(fiber.Map{"status": "success", "message": "All books", "data": "result"})
}
