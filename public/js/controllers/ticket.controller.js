import { BaseController } from '../core/base.controller.js';
import { ApiService } from '../services/api.service.js';


export class TicketController extends BaseController {

	
	id = "ticket";

	/**
	 * @param {ApiService} apiService
	 */
	constructor(params, apiService) {
		super("ticket", params);
		this.apiService = apiService;
	}

	async onInit() {
		this.select("form").addEventListener("submit", e => this.onSubmit(e));
	}

	/**
	 * @param {Event} e
	 */
	async onSubmit(e) {
		e.preventDefault();
		const form = e.target;
		if (!form.checkValidity())
			return;
		const data = Object.fromEntries(new FormData(form).entries());
		try {
			const response = await this.apiService.post("/api/ticket/create", data);
			this.navigate("/ticket");
		} catch(e) {
			console.error(e);
		}
	}
}