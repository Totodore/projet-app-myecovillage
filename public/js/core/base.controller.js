import { Main } from "../index.js";
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
	 * @return {Promise<string>} html content
	 */
	async loadView() {
		if (!this.view)
			this.error("No view found!");
		else {
			this.log("Loading view...");
			let response = await fetch(`${this.view}?${Object.entries(el => el[0] + "=" + el[1]).join('&')}`, {
				headers: { dynamic: "true" }
			});
			let html = await response.text();
			this.log("View loaded");
			return html;
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
	 * @param {(el: HTMLElement, e: MouseEvent) => void} callback
	 * @returns {HTMLElement}
	 */
	onClick(query, callback) {
			let element = this.select(query);
			if (element) {
				element.addEventListener("click", (e) => callback(element, e));
			}
			return element;
	}

	/**
	 * @param {string} message
	 */
	log(message) {
		console.log(`[${this.constructor.name}] ${message}`);
	}

	/**
	 * @param {string} message
	 */
	error(message) {
		console.error(`[${this.constructor.name}] ${message}`);
	}


}