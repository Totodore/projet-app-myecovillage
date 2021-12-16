import { BaseController } from '../core/base.controller.js';
import { ApiService } from '../services/api.service.js';


export class Gestion_forumController extends BaseController {

	id = "gestion_forum";

	/**
	 * @param {ApiService} apiService
	 */
	constructor(params, apiService) {
		super("gestion_forum", params);
		this.apiService = apiService;
	}

	async onInit() {
	}
}