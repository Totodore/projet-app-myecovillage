import { BaseController } from '../core/base.controller.js';
import { ApiService } from '../services/api.service.js';


export class HomeController extends BaseController {

	id = "home";
	ressourcePath = "";

	/**
	 * @param {ApiService} apiService
	 */
	constructor(params, apiService) {
		super(params);
		this.apiService = apiService;
	}

	async onInit() {
		this.log("init");
	}
}