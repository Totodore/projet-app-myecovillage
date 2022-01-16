import { BaseController } from "../../core/base.controller.js";

export class AdminController extends BaseController {
	
	id = "admin/index";

	/**
	 * @param {ApiService} apiService
	 */
	constructor(params, apiService) {
		super("admin/index", params);
		this.apiService = apiService;
	}

	async onInit() {
		this.navigate("admin/ticket", ".ticket-btn");
	}

}