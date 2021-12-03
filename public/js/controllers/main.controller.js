import { BaseController } from '../core/base.controller.js';
import { ApiService } from '../services/api.service.js';


export class MainController extends BaseController {

	id = "index";
	ressourcePath = "/";

	/**
	 * @param {ApiService} apiService
	 */
	constructor(params, apiService) {
		super(params);
		this.apiService = apiService;
	}

	async onInit() {
		const header = document.querySelector("header");
		const footer = document.querySelector("footer");
	}
}