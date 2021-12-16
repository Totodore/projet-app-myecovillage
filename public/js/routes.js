import { AdminController } from "./controllers/admin.controller.js";
import { HomeController } from "./controllers/home.controller.js";
import { MainController } from "./controllers/main.controller.js";
import { SigninController } from "./controllers/signin.controller.js";
import { SignupController } from "./controllers/signup.controller.js";
import { BaseController } from "./core/base.controller.js";
import { BaseService } from "./core/base.service.js";
import { AdminGuard } from "./guards/admin.guard.js";
import { ApiService } from "./services/api.service.js";
import { CguController } from "./controllers/cgu.controller.js";
import { ForumController } from "./controllers/forum.controller.js";
import { Gestion_forumController } from "./controllers/gestion_forum.controller.js";
/**
 * Route mapping between path and controllers
 * @type {Object.<string, {controller: typeof BaseController, guard?: typeof BaseGuard, services: typeof BaseService[]}>}
 */
export const routes = {
	'*': {
		controller: MainController,
		services: [ApiService],
		guard: null
	},
	'/': {
		controller: HomeController,
		services: [ApiService],
		guard: null
	},
	'/signin': {
		controller: SigninController,
		services: [ApiService],
		guard: null
	},
	'/signup': {
		controller: SignupController,
		services: [ApiService],
		guard: null
	},
	'/admin': {
		controller: AdminController,
		services: [],
		guard: AdminGuard
	},
	'/cgu': {
		controller: CguController,
		services: [],
		guard: null
	},
	'/forum': {
		controller: ForumController,
		services: [],
		guard: null
	},
	'/gestion_forum': {
		controller: Gestion_forumController,
		services: [],
		guard: null
	}
};