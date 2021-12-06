import { BaseController } from '../core/base.controller.js';
import { ApiService } from '../services/api.service.js';


export class SignupController extends BaseController {

	id = "signup";
	ressourcePath = "signup";

	/**
	 * @param {ApiService} apiService
	 */
	constructor(params, apiService) {
		super("signup", params);
		this.apiService = apiService;
	}

	async onInit() {
	}
}