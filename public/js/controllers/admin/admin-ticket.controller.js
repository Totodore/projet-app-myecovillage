import { BaseController } from "../../core/base.controller.js";
import { ApiService } from "../../services/api.service.js";

export class AdminTicketController extends BaseController {

	id = "admin/ticket";

	/**
	 * @param {ApiService} apiService
	 */
	apiService;

	constructor(params, apiService) {
		super("admin/ticket", params);
		this.apiService = apiService;
	}

	async onInit() {
		for (const btn of this.selectAll(".answer-btn")) {
			btn.addEventListener("click", e => btn.parentElement.classList.toggle("answer-show"));
			btn.parentElement.querySelector("form").addEventListener("submit", e => this.onAnswer(e));
		}
	}

	/**
	 * @param {Event} e
	 */
	async onAnswer(e) {
		e.preventDefault();
		const form = e.target;
		const data = Object.fromEntries(new FormData(form).entries());
		try {
			const res = await this.apiService.put("/api/ticket/answer", data);
			this.navigate("admin/ticket");
		} catch(e) {
			console.error(e);
		}
	}
}