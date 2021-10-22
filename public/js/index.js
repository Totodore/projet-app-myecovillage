import { routes } from "./routes.js";
import { BaseController } from "./core/base.controller.js";
class Main {

	/**
	 * @type {BaseController}
	 */
	currentController;

	currentView;

	/**
	 * @type {Object.<typeof BaseService, BaseService>}
	 */
	services = {};

	async init() {
		await this.instantiateServices();
		const route = this.routeParser();
		if (route)
			this.render(route);
	}

	/**
	 * @param {[string, string[]]} route
	 * Render method, it will load the appropriate controller and view
	 */
	async render(route) {
		const servicesToInject = routes[route[0]].services.map(serviceId => this.services[serviceId]);
		this.currentController = new routes[route[0]].controller(route[1], ...servicesToInject);
		try {
			const view = await this.currentController.loadView();
			document.getElementById("body-wrapper").innerHTML = view;
		} catch(e) {
			console.error("Fatal: Could not load view:", e);
		}
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

	/**
	 * 
	 */
	async instantiateServices() {
		const services = Object.values(routes).reduce((prev, curr) => curr.services.concat(prev), []);
		for(const service of services) {
			this.services[service] = new service();
		}
		for(const service of services) {
			if(service.init)
				await service.init();
		}
	}

}

/**
 * We wait for the content to be loaded before starting the application
 */
document.addEventListener('DOMContentLoaded', () => new Main().init());