import { BaseController } from '../core/base.controller.js';
import { ApiService } from '../services/api.service.js';


export class AccountEditController extends BaseController {

	id = "account_edit";
	ressourcePath = "account/edit";

	/**
	 * @param {ApiService} apiService
	 */
	constructor(params, apiService) {
		super("account/edit", params);
		this.apiService = apiService;
	}

	async onInit() {
		this.navigate("account", ".boutonconnexion1");
	}
}