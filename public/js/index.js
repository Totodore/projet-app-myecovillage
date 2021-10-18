import { routes } from "./routes.js";
import { BaseController } from "./core/base.controller.js";
class Main {

	/**
	 * @type {BaseController}
	 */
	currentController;

	currentView;

	constructor() {
		console.log(routes);
		const route = this.routeParser();
		if (route)
			this.render(route);
	}

	/**
	 * @param {[string, string[]]} route
	 */
	async render(route) {
		this.currentController = new routes[route[0]](route[1]);
	}

	/**
	 * @returns {null|[string, string[]]}
	 */
	routeParser() {
		const location = window.location.pathname.replace(baseUrl + "/", "");
		if (routes[location]) {
			const params = Object.fromEntries(window.location.search.replace("?", "").split("&").map(el => el.split("=")));
			return [location, params];
		} else {
			console.log("Error 404");
		} 
	}

}

document.addEventListener('DOMContentLoaded', () => new Main());