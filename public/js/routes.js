import { AdminController } from "./controllers/admin.controller.js";
import { HomeController } from "./controllers/home.controller.js";
import { BaseController } from "./core/base.controller.js";
/**
 * @type {Object.<string, typeof BaseController>}
 */
export const routes = {
	'/': HomeController,
	'/admin': AdminController
};