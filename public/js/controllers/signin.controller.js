import { BaseController } from '../core/base.controller.js';
import { ApiService } from '../services/api.service.js';


export class SigninController extends BaseController {

	id = "signin";
	ressourcePath = "signin";

	/**
	 * @param {ApiService} apiService
	 */
	constructor(params, apiService) {
		super("signin", params);
		this.apiService = apiService;
	}

	async onInit() {
		this.navigate("signin", "#buttonconnexion");
		this.navigate("signup", ".inscription");
	}
}