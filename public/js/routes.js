import { AdminController } from "./controllers/admin.controller.js";
import { HomeController } from "./controllers/home.controller.js";
import { BaseController } from "./core/base.controller.js";
import { BaseService } from "./core/base.service.js";
import { AdminGuard } from "./guards/admin.guard.js";
import { ApiService } from "./services/api.service.js";
/**
 * Route mapping between path and controllers
 * @type {Object.<string, {controller: typeof BaseController, guard?: typeof BaseGuard, services: typeof BaseService[]}>}
 */
export const routes = {
	'/': {
		controller: HomeController,
		services: [ApiService],
		guard: null
	},
	'/admin': {
		controller: AdminController,
		services: [],
		guard: AdminGuard
	}
};