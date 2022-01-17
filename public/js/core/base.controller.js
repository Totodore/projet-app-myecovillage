import { Main } from "../index.js";
import { ApiService } from "../services/api.service.js";
export class BaseController {

	/**
	 * @type {object}
	 */
	params = {};
	ressourcePath = "";
	viewParams = {};
	id = "";

	/**
	 * @type {Main}
	 */
	core;

	constructor(ressourcePath, params) {
		this.params = params;
		this.ressourcePath = ressourcePath;
		this.view = `/${baseUrl}/${this.ressourcePath}`;
		this.log("Current view", this.view);
		this.log("Controller loaded");
	}

	/**
	 * @return {Promise<[string, string]>} html, css content
	 */
	async loadView() {
		if (!this.view)
			this.error("No view found!");
		else {
			this.log("Loading view...");
			let cssResponse = await fetch(`/${baseUrl}/public/css/${this.ressourcePath}.css`);
			let response = await fetch(`${this.view}?${Object.entries(this.params).map(el => el[0] + "=" + el[1]).join('&')}`, {
				headers: { Dynamic: "true", Authorization: ApiService.instance.token },
			});
			const html = await response.text();
			const css = await cssResponse.text();
			this.log("View loaded");
			return [html, css];
		}
	}

	/**
	 * Will navigate to another url on click on element if querySelector is provided
	 * Otherwise directly redirect to given url
	 * @param {string} url
	 * @param {string} querySelector 
	 */
	navigate(url, querySelector) {
		if (querySelector) {
			this.onClick(querySelector, (el, e) => {
				e.preventDefault();
				this.core.navigate(url)
				window.scrollTo({ top: 0, behavior: 'smooth' });
			});
		} else
			this.core.navigate(url);
	}

	/**
	 * @param {string} query
	 * @returns {HTMLElement}
	 */
	select(query) {
		return document.querySelector(this.id ? `[${this.id}] ${query}` : query);
	}

	/**
	 * @param {string} query
	 * @returns {NodeListOf<HTMLElement>}
	 */
	 selectAll(query) {
		return document.querySelectorAll(this.id ? `[${this.id}] ${query}` : query);
	}

	/**
	 * @param {string} query
	 * @param {(el: HTMLElement, e: MouseEvent) => void} callback
	 * @returns {HTMLElement}
	 */
	onClick(query, callback) {
			let element = this.select(query);
			if (element) {
				element.addEventListener("click", (e) => callback(element, e));
			} else
				this.log("WARN Cannot find element", query);
			return element;
	}

	/**
	 * @param {string} message
	 */
	log(message) {
		console.log(`[${this.constructor.name}] ${JSON.stringify(message)}`);
	}

	/**
	 * @param {string} message
	 */
	error(message) {
		console.error(`[${this.constructor.name}] ${message}`);
	}


}