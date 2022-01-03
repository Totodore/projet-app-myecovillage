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
		if (this.apiService.logged)
			this.navigate("")
		this.navigate("signup", ".inscription");
		this.select("form").addEventListener("submit", e => this.onSelectForm(e));
	}

	/**
	 * @param {Event} e
	 */
	async onSelectForm(e) {
		e.preventDefault();
		const email = this.select("form input[name=email]").value;
		const password = this.select("form input[name=password]").value;
		try {
			const res = await this.apiService.login(email, password);
			this.log("User", res);
			this.core.mainController.updateLoginStatus();
			this.navigate("");
		} catch(e) {
			this.error(e);
		}
	}
}