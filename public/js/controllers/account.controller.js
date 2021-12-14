import { BaseController } from '../core/base.controller.js';
import { ApiService } from '../services/api.service.js';


export class AccountController extends BaseController {

	ressourcePath = "account";

	/**
	 * @param {ApiService} apiService
	 */
	constructor(params, apiService) {
		super("account", params);
		this.apiService = apiService;
	}

	async onInit() {
		this.navigate("account/edit", ".boutonconnexion1");
	}
}