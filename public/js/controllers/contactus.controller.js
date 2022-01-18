import { BaseController } from '../core/base.controller.js';
import { ApiService } from '../services/api.service.js';


export class ContactusController extends BaseController {

	ressourcePath = "contactus";

	/**
	 * @param {ApiService} apiService
	 */
	constructor(params, apiService) {
		super("contactus", params);
		this.apiService = apiService;
	}

	async onInit() {
		this.select("form").addEventListener("submit", e => this.onSubmit(e));

	}

	async onSubmit(e) {
		e.preventDefault();
		const form = e.target;
		if (!form.checkValidity())
			return;
		const data = Object.fromEntries(new FormData(form).entries());
		try {
			const response = await this.apiService.post("/api/contactus", data);
			this.navigate("/contactus");
		} catch (e) {
			console.error(e);
		}
	}
}