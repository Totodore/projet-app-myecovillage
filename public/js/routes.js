import { AccountController } from "./controllers/account.controller.js";
import { AccountEditController } from "./controllers/account_edit.controller.js";
import { HomeController } from "./controllers/home.controller.js";
import { MainController } from "./controllers/main.controller.js";
import { SigninController } from "./controllers/signin.controller.js";
import { SignupController } from "./controllers/signup.controller.js";
import { FaqController } from "./controllers/faq.controller.js";
import { BaseController } from "./core/base.controller.js";
import { AdminController } from "./controllers/admin/admin.controller.js";
import { ApiService } from "./services/api.service.js";
import { ContactusController } from "./controllers/contactus.controller.js";
import { CguController } from "./controllers/cgu.controller.js";
import { ForumController } from "./controllers/forum.controller.js";
import { GestionForumController } from "./controllers/gestion-forum.controller.js";
import { TicketController } from "./controllers/ticket.controller.js";
import { AdminTicketController } from "./controllers/admin/admin-ticket.controller.js";
import { AdminUserController } from "./controllers/admin/admin-user.controller.js";
import { UserController } from "./controllers/user.controller.js";
import { MinigameController } from "./controllers/minigame.controller.js";
import { AdminForumController } from "./controllers/admin/admin-forum.controller.js";
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
		guard: null
	},
	'/faq': {
		controller: FaqController,
		services: [],
		guard: null
	},
	'/contactus': {
		controller: ContactusController,
		services: [ApiService],
		guard: null
	},
	'/account': {
		controller: AccountController,
		services: [ApiService],
		guard: null
	},
	'/account/edit': {
		controller: AccountEditController,
		services: [ApiService],
		guard: null
	},
	'/cgu': {
		controller: CguController,
		services: [],
		guard: null
	},
	'/forum': {
		controller: ForumController,
		services: [ApiService],
		guard: null
	},
	'/gestion_forum': {
		controller: GestionForumController,
		services: [ApiService],
		guard: null
	},
	'/ticket': {
		controller: TicketController,
		services: [ApiService],
		guard: null
	},
	'/admin': {
		controller: AdminController,
		services: [ApiService],
		guard: null
	},
	'/admin/ticket': {
		controller: AdminTicketController,
		services: [ApiService],
		guard: null
	},
	'/admin/user': {
		controller: AdminUserController,
		services: [ApiService],
		guard: null
	},
	'/admin/forum': {
		controller: AdminForumController,
		services: [ApiService],
		guard: null
	},
	'/user': {
		controller: UserController,
		services: [],
		guard: null
	},
	'/minigame': {
		controller: MinigameController,
		services: [ApiService],
		guard: null
	}
}