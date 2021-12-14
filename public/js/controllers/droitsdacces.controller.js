import { BaseController } from '../core/base.controller.js';
import { ApiService } from '../services/api.service.js';


export class DroitsdaccesController extends BaseController {

	ressourcePath = "droitsdacces";

	/**
	 * @param {ApiService} apiService
	 */
	constructor(params, apiService) {
		super("droitsdacces", params);
		this.apiService = apiService;
	}

	async onInit() {
        
         

	}
}