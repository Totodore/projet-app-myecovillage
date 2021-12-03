import { routes } from "./routes.js";
import { BaseController } from "./core/base.controller.js";
class Main {

	/**
	 * @type {BaseController}
	 */
	currentController;

	/**
	 * @type {BaseController}
	 */
	mainController;

	currentView;

	/**
	 * @type {Object.<typeof BaseService, BaseService>}
	 */
	services = {};

	/**
	 * Load all services and parse current route
	 */
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
		this.currentController.core = this;
		try {
			const view = await this.currentController.loadView();
			document.getElementById("body-wrapper").innerHTML = view;
			if (this.currentController.onInit) {
				await this.currentController.onInit();
				this.currentController.log("Controller inited");
			}
		} catch(e) {
			console.error("Fatal: Could not load view:", e);
		} finally {
			if (!this.mainController) {
				const servicesToInject = routes['*'].services.map(serviceId => this.services[serviceId]);
				this.mainController = new routes['*'].controller(route[1], ...servicesToInject);
				this.mainController.core = this;
				if (this.mainController.onInit) {
					this.mainController.onInit();
					this.mainController.log("Controller inited");
				}
			}
		}
	}

	navigate(route) {
		history.pushState(null, null, baseUrl + "/" + route);
		route = this.routeParser();
		if (route)
			this.render(route);
	}

	/**
	 * @returns {null|[string, string[]]}
	 */
	routeParser(location = window.location.pathname) {
		location = location.replace(baseUrl + "/", "");
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