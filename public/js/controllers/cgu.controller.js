import { BaseController } from '../core/base.controller.js';
import { ApiService } from '../services/api.service.js';


export class CguController extends BaseController {

	id = "cgu";

	/**
	 * @param {ApiService} apiService
	 */
	constructor(params, apiService) {
		super("cgu", params);
		this.apiService = apiService;
	}

	async onInit() {
	}
}