import { BaseController } from '../core/base.controller.js';
import { ApiService } from '../services/api.service.js';


export class AccountEditController extends BaseController {

	id = "account_edit";
	ressourcePath = "account_edit";

	/**
	 * @param {ApiService} apiService
	 */
	constructor(params, apiService) {
		super("account/edit", params);
		this.apiService = apiService;
	}

	async onInit() {
		this.onClick(".boutonvalider", (_, e) => this.fonc_edit_profil(e));
	}

	async fonc_edit_profil(e) {
		e.preventDefault();
		const form = this.select(".form_edit_P");
		if (!form.reportValidity())
			return;
		const formData = new FormData(form);
		const body = Object.fromEntries(formData.entries());
		console.log(body);
		for (const [key, value] of Object.entries(body))
			if (typeof value === "string" && !isNaN(parseInt(value)))
				body[key] = parseInt(value);
			else if (typeof value === "string" && value.length == 0)
				body[key] = null;
		console.log(body);
		await this.apiService.post("/api/users/edit_profil", body);
		this.navigate("/account");
	}
}