package router

import (
	"book-service/handler"
	"github.com/gofiber/fiber/v2"
)

func SetupRoutes(app *fiber.App) {
	api := app.Group("/api")

	book := api.Group("/book")
	book.Get("/", handler.GetAllProducts)
}
