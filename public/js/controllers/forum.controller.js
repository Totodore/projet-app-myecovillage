import { BaseController } from '../core/base.controller.js';
import { ApiService } from '../services/api.service.js';


export class ForumController extends BaseController {

	id = "forum";

	/**
	 * @param {ApiService} apiService
	 */
	constructor(params, apiService) {
		super("forum", params);
		this.apiService = apiService;
	}

	async onInit() {
	}
}