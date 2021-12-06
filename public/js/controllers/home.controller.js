import { BaseController } from '../core/base.controller.js';
import { ApiService } from '../services/api.service.js';


export class HomeController extends BaseController {

	id = "home";

	/**
	 * @param {ApiService} apiService
	 */
	constructor(params, apiService) {
		super("home", params);
		this.apiService = apiService;
	}

	async onInit() {
	}
}