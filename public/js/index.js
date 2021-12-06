import { routes } from "./routes.js";
import { BaseController } from "./core/base.controller.js";
export class Main {

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
		window.onpopstate = () => {
			const route = this.routeParser();
			if (route)
				this.render(route);
		};
	}

	/**
	 * @param {[string, string[]]} route
	 * Render method, it will load the appropriate controller and view
	 */
	async render(route) {
		const servicesToInject = routes[route[0]].services.map(serviceId => this.services[serviceId]);
		if (this.currentController)
			this.bodyWrapper.removeAttribute(this.currentController.id);
		this.currentController = new routes[route[0]].controller(route[1], ...servicesToInject);
		this.currentController.core = this;
		this.currentController.id = this.getNewId();
		try {
			const view = await this.currentController.loadView();
			this.bodyWrapper.innerHTML = view;
			this.bodyWrapper.setAttribute(this.currentController.id, '');
			if (this.currentController.onInit) {
				await this.currentController.onInit();
				this.currentController.log("Controller inited");
			}
		} catch(e) {
			console.error("Fatal: Could not load view:", e);
		} finally {
			if (!this.mainController) {
				this.createMainController(route);	
			}
		}
	}

	createMainController(route) {
		const servicesToInject = routes['*'].services.map(serviceId => this.services[serviceId]);
		this.mainController = new routes['*'].controller(route[1], ...servicesToInject);
		this.mainController.core = this;
		this.mainController.id = this.getNewId();
		document.querySelector("header").setAttribute(this.mainController.id, '');
		document.querySelector("footer").setAttribute(this.mainController.id, '');
		if (this.mainController.onInit) {
			this.mainController.onInit();
			this.mainController.log("Controller inited");
		}
	}

	/**
	 * Navigate to a given route
	 * @param {string} route 
	 */
	navigate(route) {
		history.pushState(null, null, "/" + baseUrl + (!route.startsWith("/") ? "/" : '') + route);
		
		route = this.routeParser();
		if (route)
			this.render(route);
	}

	/**
	 * Parse a given route or the current one
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
	 * Create all registered services
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

	/**
	 * Generate random string without digits of 6 characters
	 * @returns {string}
	 */
	getNewId() {
		let text = "";
		const possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";

		for (let i = 0; i < 6; i++)
			text += possible.charAt(Math.floor(Math.random() * possible.length));

		return text;
	}

	get bodyWrapper() {
		return document.querySelector("#body-wrapper");
	}

}

/**
 * We wait for the content to be loaded before starting the application
 */
document.addEventListener('DOMContentLoaded', () => new Main().init());