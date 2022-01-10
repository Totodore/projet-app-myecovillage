import { BaseController } from '../core/base.controller.js';
import { ApiService } from '../services/api.service.js';


export class AccountController extends BaseController {

	id = "account";
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
		this.onClick(".boutondeconnexion", (_, e) => this.fonc_click(e));
	}

	fonc_click(e) {
		e.preventDefault();
		this.apiService.logout();
		location = "/" + baseUrl;
	}
}